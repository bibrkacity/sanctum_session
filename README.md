# Sanctum Session
Supporting work with variables related to Sanctum token For Laravel. 
## Installation
1. Run <br />`composer require bibrkacity/sanctum_session`<br />from the root of your project.
2. Run <br />`php artisan vendor:publish --provider="Bibrkacity\SanctumSession\SanctumSessionServiceProvider"`<br /> from the root of your project.
3. Run <br />`php artisan migrate`<br /> from the root of your project.
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




