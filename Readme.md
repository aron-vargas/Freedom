# ReactLaravel User Administration

This project is a user administration dashboard built with React (Vite) for the frontend and Laravel for the backend. It features user listing, editing, and deletion, with API integration and SPA navigation using Inertia.js.

## Features

- List active users in a table
- Edit and delete users with confirmation
- Responsive UI with Tailwind CSS
- Laravel backend with Eloquent models and API routes
- Inertia.js for seamless SPA experience

## Getting Started

### Prerequisites

- Node.js & npm
- PHP & Composer
- MySQL or compatible database

### Installation

1. **Clone the repository**
   ```sh
   git clone https://github.com/yourusername/ReactLaravel.git
   cd ReactLaravel
   ```

2. **Install backend dependencies**
   ```sh
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

3. **Install frontend dependencies**
   ```sh
   cd resources/js
   npm install
   ```

4. **Configure your `.env` file**
   Set up your database and other environment variables.

5. **Run migrations**
   ```sh
   php artisan migrate
   ```

6. **Start the development servers**
   ```sh
   # In one terminal
   php artisan serve

   # In another terminal (inside resources/js)
   npm run dev
   ```

## Usage

- Access the dashboard at `http://localhost:8000/admin/user/list`
- Edit or delete users using the action buttons

## Project Structure

```
app/Models/User.php           # Laravel User model
resources/js/pages/admin/     # React pages for admin
resources/js/pages/admin/user.tsx  # User list page
routes/web.php                # Laravel web routes
routes/api.php                # Laravel API routes
```

## Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](LICENSE)