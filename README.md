## About This App

This is a multi-language E-commerce web application with an admin panel. It is a classic multi-page monolith web app created using Laravel Blade templates which renders html pages on a server in a classic way. It is made using Laravel PHP framework, vanilla Javascript (ES modules), pure CSS written with a SCSS preprocessor, and Vite.js for building assets to single files. For form elements, some Bootstrap modules were used.

The following features were implemented:

- 4 levels of category nesting. Categories with products have an individual sets of product specifications.
- A product catalog with a set of filters by price, brand, and selected product specifications.
- Products can have any number of variants grouped by attributes.
- A product page where users can see all product's specifications, images, rate the product, leave reviews, and rate others' reviews.
- A brand page with a brand description and links to categories with products of this brand.
- Promo pages with ability to set discounts to groups of products with scheduling starting and ending day. Separate discount settings for individual products.
- Live search by products and brands.
- User registration and authentication mechanism with email confirmation and password reset.
- User profile page with ability to edit all personal data.
- A product cart.
- An order history page.
- User notifications about order status changing — by email, and on a web page.
- Adding products to Favorites.
- Comparing products by their specifications.
- Recently viewed products.
- Any user regardless of authentication status can use a product cart, make an order, see his order history, manage Favorites section, and compare products.
- Products have "Available at" and "Available until" properties that can be used to schedule their availability in stock.
- Full multi-language support. The website, the Admin panel interface, and all the content can be viewed and managed on 3 languages.
- Multi-currency support. Every product's price can be set in arbitrary currency. Prices calculated according to exchange rates which updates daily. 
- Correct responsive layout on all devices. The site and the Admin panel are comfortable to use on computers, laptops, tablets and smartphones.
- An Admin panel for managing everything: adding, searching, exploring, editing, deleting — categories, products, attributes, variants, specifications, reviews, promos, languages and translations, currencies, as well as viewing log, the dashboard with sales and rate statistics, managing orders and users.

Currently, the work in progress.

## Technology stack

Frameworks, libraries and tools:

- Laravel PHP framework
- Spatie/Laravel-translatable
- Spatie/Image
- PostgreSQL
- Redis (for caching)
- Docker
- Vite
- Some modules of Bootstrap library
- Swiper
- Fancybox
- SortableJS

Languages:

- PHP 8.2
- SQL, Eloquent ORM
- HTML
- Laravel Blade
- CSS, SCSS
- Javascript (ES2016 and newer, ES modules)


## Installation

Install app dependencies:  
`$ composer install`

Run migrations:  
`$ php artisan migrate`

Run all necessary app installation commands:  
`$ php artisan app:install`
