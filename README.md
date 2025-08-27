# Tasks Manager API

This repository contains a **Laravel API** for managing tasks.

## Features

- Laravel API with `/api/v1/tasks` endpoint
    - GET: Retrieve tasks with pagination
    - POST: Create new tasks
- Tasks have `id`, `title`, `description`, and `status`
    - Status values: Pending, In Progress, Done

## Getting Started

### Prerequisites

- Docker & Docker Compose

### Setup Steps

- Clone the repository:
```bash
git clone git@github.com:Hossam-Tarek/tasks-manager-api.git
cd tasks-manager-api
```
- Copy .env.example to .env and configure environment variables if needed:
```bash
cp .env.example .env
```
- Build and start Docker containers:
```bash
docker-compose up -d
```
- Run migrations and seed the database:
```bash
docker-compose exec php php artisan migrate --seed
```
- Run PHPUnit tests:
```bash
docker-compose exec php php artisan test
```
- Access the API:
```bash
http://localhost:8000/api/v1/tasks
```
