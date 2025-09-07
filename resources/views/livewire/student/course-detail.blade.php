<div class="p-6">
    {{-- Flash messages --}}
    @if(session()->has('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session()->has('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    <h1 class="text-2xl font-bold mb-2">{{ $course->title }}</h1>
    <p class="mb-4 text-gray-700">{{ $course->description }}</p>

    <div class="mb-4">
        <span class="text-sm text-gray-500">Price:</span>
        <span class="font-medium">{{ $course->price ? '$'.$course->price : 'Free' }}</span>
    </div>

    @if(!$isEnrolled)
        <div class="mb-6">
            @if(!$course->price || $course->price == 0)
                <button wire:click="enroll" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Enroll in Course
                </button>
            @else
                <form id="payment-form" action="{{ route('student.payment.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="token" id="payment-token">

                    <!-- Checkout.com Card Frame -->
                    <div class="border p-4 rounded mb-4">
                        <label class="block text-gray-600 text-sm mb-2">Card Details</label>
                        <div class="card-frame border p-3 rounded"></div>
                        <div class="error-message text-red-600 text-sm mt-2" id="card-errors"></div>
                    </div>

                    <button type="button" id="checkout-button"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Pay & Enroll (${{ $course->price }})
                    </button>
                </form>

                <!-- Checkout Frames Script -->
                <script src="https://cdn.checkout.com/js/framesv2.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        if (!window.Frames) {
                            console.error('Checkout Frames not loaded');
                            return;
                        }

                        Frames.init("{{ env('CHECKOUT_PUBLIC_KEY') }}"); // pk_test_xxx

                        const form = document.getElementById("payment-form");
                        const button = document.getElementById("checkout-button");

                        // Handle errors
                        Frames.addEventHandler(Frames.Events.CARD_VALIDATION_CHANGED, function (event) {
                            const errorMessage = document.getElementById("card-errors");
                            if (event.isValid || !event.isValid) {
                                errorMessage.textContent = Frames.getCardValidationState().isValid ? "" : "Invalid card details";
                            }
                        });

                        // When card tokenized
                        Frames.addEventHandler(Frames.Events.CARD_TOKENIZED, function (event) {
                            document.getElementById("payment-token").value = event.token;
                            form.submit();
                        });

                        // On button click → trigger submit
                        button.addEventListener("click", function () {
                            Frames.submitCard();
                        });
                    });
                </script>
            @endif
        </div>

        <div class="p-4 border rounded bg-yellow-50 text-sm text-gray-700">
            You must enroll to access lessons. After enrolling (or payment) you will be redirected to <strong>My
                Enrollments</strong>.
        </div>
    @else
        <div class="mt-4">
            <h2 class="text-xl font-semibold mb-2">Lessons</h2>

            @if($course->lessons->count())
                <ul class="space-y-3">
                    @foreach($course->lessons as $lesson)
                        <li class="p-3 border rounded flex items-center justify-between bg-white">
                            <div>
                                <div class="font-medium">
                                    @if($lesson->order) {{ $lesson->order }}. @endif {{ $lesson->title }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    Duration: {{ $lesson->duration ? gmdate('H:i:s', $lesson->duration) : '-' }}
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="text-sm text-gray-600">
                                    {{ isset($progress[$lesson->id]) ? $progress[$lesson->id].'%' : '0%' }}
                                </div>

                                <a href="{{ route('student.lessons.view', $lesson->id) }}"
                                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                    Start / Continue
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">No lessons yet. Instructor will add lessons soon.</p>
            @endif
        </div>
    @endif
</div>
