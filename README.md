# Laravel Ecommerce Single Vendor Admin Panel

This is a Laravel-based e-commerce application script that can be used to build a single-vendor online store.

## Features

- User authentication
- Vendor dashboard
- Product management
- Order management
- Discount management
- Vendor profile management
- Payment integration
- Admin panel
- Role and permission management
- Report generation
- Settings management
- Product gallery management
- Product attribute management
- Product variant management
- Product review management
- Product stock management
- Product search management
- Email template management
- Stripe payment integration
- SMTP configuration
- Order status management
- Color management
- Authentication configuration

## Getting Started

### Prerequisites

- PHP >= 8.2
- MySQL
- Composer
- Node & NPM

### Installation

1. Clone the repository

``` bash
git clone https://github.com/Binary-Fusion/single-vendor-ecommerce-admin-panel.git
```

2. Install dependencies

``` bash
composer install
npm install
```

3. Configure environment variables

``` bash
cp .env.example .env
```

4. Generate application key

``` bash
php artisan key:generate
```

5. Run database migrations

``` bash
php artisan migrate
```

6. Seed dummy data (optional)

``` bash
php artisan db:seed
```

7. Build assets

``` bash
npm run dev
```

8. Serve application

``` bash
php artisan serve
```

The application will be available by default at http://localhost:8000

## License

This project is licensed under the MIT License.
