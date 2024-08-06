# VoucherVault

VoucherVault is a web application designed to streamline the management of voucher claims and their associated histories. It provides an intuitive interface for users to submit, track, and review voucher claims efficiently. 

## Features
- **Claim Management**: Users can easily submit and manage their voucher claims.
- **History Tracking**: View detailed history and status updates for each voucher claim
- **User-Friendly Interface**: Clean and straightforward UI for an optimal user experience.

## Technologies Used
- PHP (Version 8.3.9)
- Laravel Framework (Version 11.1.3)
- MySQL

## Installation
1. Clone the repository:
    ```sh
    git clone https://github.com/novirachmahwati/voucherVault.git
    ```
2. Navigate to the project directory:
    ```sh
    cd voucherVault
    ```
3. Install dependencies:
    ```sh
    composer install
    ```
4. Set up the environment variables:
    ```sh
    cp .env.example .env
    ```
5. Update the `.env` file with your database configuration:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

   Make sure to replace `your_database_name`, `your_database_username`, and `your_database_password` with your actual database credentials.

6. Generate Application Key:
    ```sh
    php artisan key:generate
    ```

7. Run the migrations:
    ```sh
    php artisan migrate
    ```

8. Run the seeders:
    ```sh
    php artisan db:seed
    ```

9. Run generate swagger:
    ```sh
    php artisan l5-swagger:generate
    ```

10. Install dependencies:
    ```sh
    yarn
    ```

## Usage
1. To run the project, you need to run the following command in the project directory. It will compile JavaScript and Styles.
    ```sh
    yarn dev
    ```
2. To serve the application, you need to run the following command in the project directory

    ```sh
    php artisan serve
    ```
3. Access the API on:
    ```
    http://localhost:8000/api/{endpoint_name}
    ```

## API Documentation
Explore the API endpoints using Swagger UI:
- Swagger Documentation URL: [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

You can view the documentation for this API using Swagger. It provides an interactive interface where you can explore endpoints, parameters, request/response schemas, and even test API calls directly from the documentation page.