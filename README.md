# Welcome to my Blog Platform

## Project info

A full-stack, responsive blog platform designed to allow creators to publish, edit, and manage articles seamlessly. Built with modern web technologies, the application features user authentication, dynamic content rendering, interactive comments, and an intuitive dashboard for managing posts and user profiles.

**Key Features**

* **Authentication & Authorization**: Secure user registration, login, and role-based access control (Admin/Author/Reader).
* **Content Management**: Full CRUD capabilities for writing, updating, formatting, and deleting posts.
* **Interactive Features**: Real-time comment threads, post categorization, tag filtering, and search functionality.
* **Responsive UI**: Optimized layout for desktop, tablet, and mobile devices.
* **Performance & SEO**: Dynamic page rendering with optimized API routes and structured metadata for search engine indexing.

## How can I edit this code?

Follow these steps:

```sh
# Step 1: Clone this repository using the project's Git URL.
git clone <YOUR_GIT_URL>

# Step 2: Navigate to the project directory.
cd <YOUR_PROJECT_NAME>

# Step 3: Install PHP dependencies.
composer install

# Step 4: Install Node dependencies.
npm install

# Step 5: Configure your environment file and generate application key.
cp .env.example .env
php artisan key:generate

# Step 6: Run database migrations.
php artisan migrate

# Step 7: Start the development server and frontend assets compile.
php artisan serve
npm run dev

```

## What technologies are used for this project?

This project is built with:

* Laravel
* PHP
* Blade / Inertia.js
* Tailwind CSS
* MySQL
