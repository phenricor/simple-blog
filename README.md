<img src="https://i.imgur.com/Ji4Xtmw.png"></img>
This is a personal project using Laravel. The application is a simple blog for basic usage, such as posting and commenting.
# Features
- [x] Blog posting and management (CRUD)
- [x] Pagination
- [x] Rich text editor
- [x] Image uploading
- [x] Comment section
- [x] Categories
- [x] Admin features
- [x] Custom navbar pages
- [x] Customizable social media icons (github, linkedin, telegram etc.)
- [x] RSS Feed
- [ ] Schedule post
- [ ] Pinned post
- [ ] Search system
- [ ] Layout customization
- [ ] Reactions to posts
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
4. Insert the admin credentials on .env:
```
ADMIN_USERNAME=
ADMIN_PASSWORD=
```
These credentials are going to be used for authentication, so it is recommended to use a strong password.

5. Generate your encryption keys
```
php artisan key:generate
```
6. Run migrations and seed the database:
```
php artisan migrate --seed
```
7. Start the server:
```
php artisan serve
```
## Adittional steps
- **Feed**: On config/feed.php, you can change `title` and `description` values, that will reflect on the blog's RSS properties.
- 

Access http://localhost:8000 to use the application.
# What is being used
1. Bootstrap
2. Laravel
3. Quill
4. spatie/laravel-feed
