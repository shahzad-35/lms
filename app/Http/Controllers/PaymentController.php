<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\Course;

class PaymentController extends Controller
{
    protected function baseUrl()
    {
        return 'https://api.sandbox.checkout.com';
    }

    public function pay(Request $request)
    {

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'token' => 'required|string',
        ]);

        $course = Course::findOrFail($request->course_id);

        // Server-side trusted amount (DO NOT trust client)
        $amount = intval($course->price * 100); // in cents
        $currency = 'USD';

        // Prevent enrolling twice
        if (Enrollment::where('user_id', auth()->id())->where('course_id', $course->id)->exists()) {
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }

        $payload = [
            'source' => [
                'type' => 'token',
                'token' => $request->token,
            ],
            'amount' => $amount,
            'currency' => $currency,
            'reference' => 'course_' . $course->id . '_user_' . auth()->id(),
            'processing_channel_id' => env('CHECKOUT_PROCESSING_CHANNEL_ID'),
        ];

        $secret = env('CHECKOUT_SECRET_KEY');

        try {
            $resp = Http::withToken($secret)
                ->withHeaders(['Accept' => 'application/json'])
                ->post($this->baseUrl() . '/payments', $payload);

            $body = $resp->json();

            // Save the raw response for audit
            $payment = Payment::create([
                'user_id' => auth()->id(),
                'course_id' => $course->id,
                'transaction_id' => $body['id'] ?? null,
                'provider' => 'checkout',
                'status' => $body['status'] ?? ($resp->ok() ? 'unknown' : 'failed'),
                'raw_response' => $body,
            ]);

            // Consider success statuses (case-insensitive)
            $status = isset($body['status']) ? strtoupper($body['status']) : null;
            $okStatuses = ['AUTHORIZED', 'AUTHORISED', 'CAPTURED', 'SUCCESS', 'DECLINED'];

            if (in_array($status, ['AUTHORIZED', 'AUTHORISED', 'CAPTURED', 'SUCCESS'])) {
                
                Enrollment::firstOrCreate([
                    'user_id' => auth()->id(),
                    'course_id' => $course->id,
                ], [
                    'stripe_payment_id' => $payment->transaction_id,
                    'status' => 'paid',
                ]);

                return redirect()->route('student.enrollments')
                    ->with('success', 'Payment successful! You are now enrolled.');
            }

            $message = $body['response_summary'] ?? ($body['result'] ?? 'Payment failed. Try again.');
            return redirect()->back()->with('error', 'Payment failed: ' . $message);
        } catch (\Exception $e) {
            \Log::error('Payment error: ' . $e->getMessage(), [
                'payload' => $payload,
            ]);
            return redirect()->back()->with('error', 'Payment error: ' . $e->getMessage());
        }
    }
}
