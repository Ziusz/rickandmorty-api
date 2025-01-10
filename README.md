# Rick and Morty API Demo

A demo project built with Laravel and Vue.js that fetches and displays data from the Rick and Morty API.

## Requirements

- PHP 8.2+
- Node.js 20+
- Composer
- npm

## Installation

1. Clone the repository
   ```bash
   git clone https://github.com/Ziusz/rickandmorty-api.git
   ```

2. Copy example environment file to .env and set your database credentials (or use default values to use SQLite)
   ```bash
   cp .env.example .env
   ```   

3. Install PHP dependencies by Composer
   ```bash
   composer install
   ```

4. Generate application key
   ```bash
   php artisan key:generate
   ```   

5. Run database migrations
   ```bash
   php artisan migrate
   ```

6. Install JavaScript dependencies
   ```bash
   npm install
   ```

7. Build the frontend
   ```bash
   npm run build
   ```

8. Start the development server
   ```bash
   php artisan serve
   ```

## License

This project is under the [MIT license](LICENSE).