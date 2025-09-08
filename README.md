# 🎓 Online LMS – Laravel + Livewire  

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red?logo=laravel)](https://laravel.com)  
[![Livewire](https://img.shields.io/badge/Livewire-3.x-purple?logo=livewire)](https://livewire.laravel.com/)  
[![Payments](https://img.shields.io/badge/Payments-Checkout.com-blue)](https://www.checkout.com/)  
[![License](https://img.shields.io/badge/license-MIT-green)](#)  

> A modern **Learning Management System (LMS)** where instructors can share knowledge and students can learn seamlessly.  
> Built with Laravel + Livewire, featuring course management, enrollment, secure payments, and progress tracking.  

---

## ✨ Highlights  

- 👨‍🏫 **Instructor Tools** → Create & manage courses, upload lessons.  
- 🎓 **Student Experience** → Browse courses, enroll, track learning journey.  
- 💳 **Payments** → Checkout.com integration for paid enrollments.  
- 📊 **Progress Tracking** → Watch logs for lessons and completion.  

---

## 🔗 Learning Flow  

1. Register or log in.  
2. Instructors publish courses with lessons.  
3. Students explore available courses.  
4. Enrollment:  
   - Free → instant access.  
   - Paid → secure payment flow.  
5. Lessons unlocked & tracked.  

---

## 🛠️ Tech Overview  

- Backend → Laravel 10  
- Frontend → Blade + Livewire  
- Database → MySQL  
- Payments → Checkout.com  
- Styling → TailwindCSS  

---

## ⚡ Setup  

```bash
git clone <repo-url>
cd lms-laravel

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan storage:link

php artisan serve
```

---

## 🔑 Environment  

```env
APP_NAME="LMS"
APP_ENV=local
APP_KEY=base64:xxxxxx
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms
DB_USERNAME=root
DB_PASSWORD=

# Checkout.com
CHECKOUT_PUBLIC_KEY=pk_test_xxxxx
CHECKOUT_SECRET_KEY=sk_test_xxxxx
```

---

## 🧪 Payments (Sandbox)  

| Card Number          | Status      |
|----------------------|-------------|
| 4242 4242 4242 4242 | ✅ Success   |
| 4000 0000 0000 0002 | ❌ Declined  |

Use any valid expiry date & CVV.  

---

## 🎯 Next Improvements

- 🔔 Real-time notifications.  
- 📊 Admin dashboard.  
- 🌍 Cloud deployment.  
- 🎨 Improved user experience.  

---

## 👨‍💻 Author  

**Shahzad Ali**  
🌐 [LinkedIn](https://www.linkedin.com/in/shahzadali035) | 💻 [GitHub](https://github.com/)  

---

✨ *Crafted with Laravel, Livewire & a lot of ☕*  