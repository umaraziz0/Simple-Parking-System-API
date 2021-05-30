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

| Method | URI                             | Visibility | Function                                                        |
| ------ | ------------------------------- | ---------- | --------------------------------------------------------------- |
| GET    | api/admin                       | auth:admin | Shows all of the parking data                                   |
| GET    | api/admin/export                | auth:admin | Exports all of the parking data to a .xlsx file                 |
| POST   | api/enter-vehicle               | public     | Enters a vehicle into the parking lot                           |
| POST   | api/exit-vehicle                | public     | Exits a vehicle from the parking lot                            |
| POST   | api/admin/register              | public     | Registers a new admin                                           |
| POST   | api/admin/login                 | public     | Admin login                                                     |
| POST   | api/admin/logout                | auth:admin | Admin logout                                                    |
| POST   | api/admin/filter-by-date        | auth:admin | Filters parking data by date range                              |
| POST   | api/admin/filter-by-date/export | auth:admin | Filters parking data by date range and exportss to a .xlsx file |
