
# Vending Machine

This project is a vending machine application built with

- Laravel
- Jetstream
- Inertia
- Vue

## Laravel Setup

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & npm

### Installation

1. **Clone the repository:**

    ```sh
    git clone https://github.com/your-username/vending-machine.git
    cd vending-machine
    ```

2. **Install PHP dependencies:**

    ```sh
    composer install
    ```

3. **Install Node.js dependencies:**

    ```sh
    npm install
    ```

4. **Copy the `.env.example` file to `.env`:**

    ```sh
    cp .env.example .env
    ```

5. **Generate the application key:**

    ```sh
    php artisan key:generate
    ```

6. **Set up your database:**

    Update your `.env` file with your database credentials.

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

7. **Run the database migrations:**

    ```sh
    php artisan migrate
    ```

8. **Run the database seeders (optional):**

    ```sh
    php artisan db:seed
    ```

9. **Compile the assets:**

    ```sh
    npm run dev
    ```

### Running the Application

1. **Start the local development server:**

    ```sh
    php artisan serve
    ```

2. **Visit the application in your browser:**

    Open your browser and go to `http://localhost:8000`.

### Running Tests

1. **Run the feature tests:**

    ```sh
    php artisan test
    ```

### Additional Notes

- Make sure to set up the necessary roles and permissions using the Spatie Laravel Permission package.
- Ensure your `.env` file is correctly configured for mail, cache, and other services as needed.

For more detailed information, refer to the [Laravel documentation](https://laravel.com/docs).

