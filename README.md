## About This App

This is a second version of a multipage E-commerce web application (work in progress). The following features will be (or already have been) implemented:

- 4 levels of categories.
- Every category with products has an individual set of product specifications.
- A product catalog with a set of filters by price, brand, and selected product specifications.
- Products can have any number of variants grouped by attributes.
- A product page where users can see all product's specifications, images, rate the product, leave reviews, and rate others' reviews.
- Promo and discount mechanism.
- Live search by products and brands.
- User registration and authentication mechanism with email confirmation and password reset.
- User profile page with ability to edit all personal data.
- A product cart.
- An ordering mechanism.
- User notifications about order status changing — by email, and on a web page.
- Adding products to Favorites.
- Comparing products by their specifications.
- Any user regardless of authentication status can use a product cart, make an order, see his order history, manage Favorites section, and compare products.
- Products have "Available at" and "Available until" properties that can be used to schedule their availability in stock.
- Multi-language support.
- Multi-currency support. Every product's price can be set in arbitrary currency. Prices calculated according to exchange rates which updates daily. 
- Correct responsive layout for all devices: smartphones, tablets, laptops and PCs.
- An Admin panel for managing everything: adding, searching, exploring, editing, deleting — categories, products, attributes, variants, specifications, reviews, promos, languages and translations, currencies, as well as viewing log, the dashboard with sales and rate statistics, managing orders and users.

Currently, the work in progress.

## Technology stack

Frameworks, libraries and tools:

- Laravel PHP framework
- Spatie/Laravel-translatable
- PostgreSQL
- Redis
- Docker
- Vite
- Some modules of Bootstrap library
- Swiper
- Fancybox

Languages:

- HTML
- CSS, SCSS
- Blade
- Javascript (ECMAScript 2016 and newer)
- PHP 8.2
- SQL, Eloquent ORM

## Installation

Install app depencies:  
`$ composer install`

Run migrations:  
`$ php artisan migrate`

Run all necessary app installation commands:  
`$ php artisan app:install`
