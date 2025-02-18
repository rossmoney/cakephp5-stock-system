# CakePHP 5 Inventory Tracker
 
Objective: Create an application to manage product inventory with constraints. 
 
Requirements:
1. Models:
    * Product Model with fields:
        * id, name, quantity, price, status (in stock, low stock, out of stock).
        * Add validation rules:
            1. name: Required, unique, must be between 3 and 50 characters.
            2. quantity: Integer, >= 0, <= 1000.
            3. price: Decimal, > 0, <= 10,000.
        * Custom validation:
            1. Products with a price > 100 must have a minimum quantity of 10.
            2. Products with a name containing "promo" must have a price < 50.
2. Controllers:
    * ProductsController with:
        * index: List all products with filters for status (in stock, low stock, out of stock) and a search box for names.
        * add: Add a new product.
        * edit: Update product details.
        * delete: Soft-delete products (set a deleted flag instead of removing them from the database).
3. Views:
    * Product list page with:
        * Columns: name, quantity, price, status, last updated.
    * Search box for partial name matches.
    * Pagination
    * A form to add/edit products.
    * A confirmation modal before deleting a product. 
4. Additional Requirements:
    * Calculate the status dynamically based on quantity:
        * in stock: Quantity > 10.
        * low stock: Quantity between 1 and 10.
        * out of stock: Quantity = 0.
    * Implement a behaviour to automatically update the last_updated field whenever a product is modified. 
    * Implement a unit test suite for the Product model and controller actions.
    * Seed the database with 10 sample products, ensuring variety in status, price, and quantity.
    * Ensure this follows CakePHP coding standards: https://book.cakephp.org/5/en/contributing/cakephp-coding-conventions.html

## Running the server
bin/cake server

## Migrate the database
bin/cake migrations migrate

## Seed the database
bin/cake migrations seed Products

## Run tests
./vendor/bin/phpunit