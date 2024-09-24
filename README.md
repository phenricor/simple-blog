This is a personal project using Laravel. The application is a simple blog for basic usage, such as posting and commenting.
# Features
- Blog posting and management (CRUD)
- Pagination
- Rich text editor
- Image uploading
- Comment section
# Requirements
1. PHP >= 8.0
2. Composer
3. MySQL or other database
# Installation
Steps for setting up locally
Follow these steps to set up the project locally:

1. Clone the repository
```
git clone https://github.com/your-username/simple-blog.git
cd simple-blog
```
2. Install composer
```
composer install
```
3. Set up the environment variables:
```
cp .env.example .env
```
4. Run migrations and seed the database:
```
php artisan migrate --seed
```
5. Start the server:
```
php artisan serve
```
Access http://localhost:8000 to use the application.
# What is being used
1. Bootstrap
2. Laravel
3. Quill
