# Sanctum Session
Supporting work with variables related to Sanctum token For Laravel. 
## Installation
1. Run `composer require bibrkacity/sanctum_session` from the root of your project.
2. Run `php artisan vendor:publish --provider="Bibrkacity\SanctumSession\SanctumSessionServiceProvider"` from the root of your project.
3. Run `php artisan migrate` from the root of your project.
## Usage
The Service `Bibrkacity\SanctumSession\SanctumService` available in your project after installation. It has methods to get and set session variables:

| Method      | Arguments | Description |
|-------------|-----------|-------------|
| get()       |           |             |
| getAll()    |           |             |
| put()       |           |             |
| forget()    |           |             |
| forgetAll() |           |             |

### Examples




