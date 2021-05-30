# Bounche Backend Test

### Mohamad Umar Aziz

### Installation

1. Install dependencies `composer install`
2. Configure database with .env file
3. Migrate database `php artisan migrate`
4. Run DB seeder (optional): `php artisan db:seed`
5. Run built in server: `php artisan serve`

### Routes

All routes tested using Postman API

| Method | URI                             | Visibility |
| ------ | ------------------------------- | ---------- |
| GET    | api/admin                       | auth:admin |
| GET    | api/admin/export                | auth:admin |
| POST   | api/enter-vehicle               | public     |
| POST   | api/exit-vehicle                | public     |
| POST   | api/admin/register              | public     |
| POST   | api/admin/login                 | public     |
| POST   | api/admin/logout                | auth:admin |
| POST   | api/admin/filter-by-date        | auth:admin |
| POST   | api/admin/filter-by-date/export | auth:admin |
