# Laravel Blog Platform  

A simple blog platform built with Laravel.  
Features include user authentication, posts CRUD, API with token authentication, and email notifications when a post is published.  

A) Project Setup

1. Clone the repository: 
   git clone https://github.com/username/laravel-blog-platform.git

2. Install dependencies:
   composer install
   npm install && npm run dev

3. Environment setup
   Copy `.env.example` to `.env`: 
   cp .env.example .env

4. Generate application key: 
   php artisan key:generate

5. Setup database & SMTP
   Open .env and add your database + mail credentials:

   DB_DATABASE=your_db
   DB_USERNAME=your_user
   DB_PASSWORD=your_password

   MAIL_MAILER=smtp
   MAIL_HOST=smtp.yourserver.com
   MAIL_PORT=587
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=no-reply@example.com
   MAIL_FROM_NAME="Blog Platform"

6. Configure Admin Email
   Add the admin email in .env:
   ADMIN_EMAIL=admin@example.com

   This email will receive notifications when a new post is published.
   In config/mail.php, we added:

   'admin_address' => env('ADMIN_EMAIL', 'admin@gmail.com'),


(B) Database & Seeders

(1) Run Migrations
   php artisan migrate

(2) Run Seeders (creates 10 users & 50 posts)
   php artisan db:seed

(C) API Documentation

1. Login API

   Method: POST

   URL: http://localhost:8000/api/login

   Headers:
   
   Accept: application/json
   Content-Type: application/json

   Body (JSON):

   {
     "email": "user@example.com",
     "password": "password"
   }

   Success Response:

   {
     "success": true,
     "message": "Login successful",
     "user": {
       "id": 1,
       "name": "Test User",
       "email": "user@example.com"
     },
     "token": "1|long_token_string_here"
   }

Note: Copy "token" from response → use in Authorization: Bearer <token> header for all other requests.

2. Logout API

   Method: POST

   URL: http://localhost:8000/api/logout

   Headers:

   Accept: application/json
   Authorization: Bearer <your_token>

   Success Response:

   {
     "message": "Logged out successfully"
   }

Posts CRUD

3. Create Post

   Method: POST

   URL: http://localhost:8000/api/posts

   Headers:

   Accept: application/json
   Authorization: Bearer <your_token>
   Content-Type: application/json

   Body (JSON):

   {
     "title": "My First Post",
     "content": "This is the content of my post",
     "published_at": "2025-09-18 10:00:00"
   }

   Success Response:

   {
     "id": 1,
     "title": "My First Post",
     "content": "This is the content of my post",
     "published_at": "2025-09-18T10:00:00.000000Z",
     "user_id": 1,
     "created_at": "2025-09-18T10:05:00.000000Z",
     "updated_at": "2025-09-18T10:05:00.000000Z"
   }

4. List All Posts

   Method: GET

   URL: http://localhost:8000/api/posts

   Headers:

   Accept: application/json
   Authorization: Bearer <your_token>

   Success Response:

   [
     {
       "id": 1,
       "title": "My First Post",
       "content": "This is the content",
       "published_at": "2025-09-18T10:00:00.000000Z",
       "user_id": 1
     },
     {
       "id": 2,
       "title": "Another Post",
       "content": "Second post content",
       "published_at": null,
       "user_id": 1
     }
   ]

5. View Single Post

   Method: GET

   URL: http://localhost:8000/api/posts/{id}

   Example: http://localhost:8000/api/posts/1

   Headers:

   Accept: application/json
   Authorization: Bearer <your_token>

   Success Response:

   {
     "id": 1,
     "title": "My First Post",
     "content": "This is the content",
     "published_at": "2025-09-18T10:00:00.000000Z",
     "user_id": 1
   }

6. Update Post

   Method: PUT

   URL: http://localhost:8000/api/posts/{id}

   Example: http://localhost:8000/api/posts/1

   Headers:

   Accept: application/json
   Authorization: Bearer <your_token>
   Content-Type: application/json

   Body (JSON):

   {
     "title": "Updated Title",
     "content": "Updated content",
     "published_at": "2025-09-19 12:00:00"
   }

   Success Response:

   {
     "id": 1,
     "title": "Updated Title",
     "content": "Updated content",
     "published_at": "2025-09-19T12:00:00.000000Z",
     "user_id": 1,
     "created_at": "2025-09-18T10:05:00.000000Z",
     "updated_at": "2025-09-19T12:01:00.000000Z"
   }

7. Delete Post

   Method: DELETE

   URL: http://localhost:8000/api/posts/{id}

   Example: http://localhost:8000/api/posts/1

   Headers:

   Accept: application/json
   Authorization: Bearer <your_token>

   Success Response:

   {
      "message": "Post deleted successfully"
   }


Note:

Quick Tip for Postman:

1st run Login → copy "token".

Add Authorization: Bearer <token> in Postman Authorization tab → select "Bearer Token".

Then test all Post APIs without copying token manually every time.

<!--  -->


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
