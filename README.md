# Todo API

A RESTful API for managing todos built with Laravel. This API provides endpoints for creating, reading, updating, and deleting todos with features like filtering, sorting, and searching.

## Features

- CRUD operations for todos
- Filter todos by status
- Search todos by title and details
- Sort todos by various fields
- Comprehensive test coverage
- API documentation with Swagger/OpenAPI

## API Endpoints

- `GET /api/todos` - List all todos (with filtering and sorting)
- `POST /api/todos` - Create a new todo
- `GET /api/todos/{id}` - Get a specific todo
- `PUT /api/todos/{id}` - Update a todo
- `DELETE /api/todos/{id}` - Delete a todo
- `PATCH /api/todos/{id}/toggle` - Toggle todo status

## Installation

1. Clone the repository
```bash
git clone https://github.com/[your-username]/todo-api.git
cd todo-api
```

2. Install dependencies
```bash
composer install
```

3. Copy .env.example to .env and configure your environment
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Run migrations
```bash
php artisan migrate
```

6. Run tests
```bash
php artisan test
```

## API Documentation

API documentation is available at `/api/documentation` when running locally.

## License

This project is open-sourced software licensed under the MIT license.
