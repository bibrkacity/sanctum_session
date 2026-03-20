# Sanctum Session
Supporting work with variables related to Sanctum token For Laravel. It can be useful, for example, for storing user preferences or session-specific data.
## Installation
1. Run <br />`composer require bibrkacity/sanctum_session`<br />from the root of your project.
2. Run <br />`php artisan vendor:publish --provider="Bibrkacity\SanctumSession\SanctumSessionServiceProvider"`<br /> from the root of your project.
3. Run <br />`php artisan migrate`<br /> from the root of your project.
## Usage
The Service `Bibrkacity\SanctumSession\SanctumService` available in your project after installation. The token for use as argument in the methods you can get from the request:

`$token = request()->bearerToken();`

This service has methods to get and set session variables:

| Method      | Arguments                                                                   | Description                                                            |
|-------------|-----------------------------------------------------------------------------|------------------------------------------------------------------------|
| has()       | string \$token,<br /> string \$key                                          | Checking if a variable with name=\$key exists in the Sanctum session   |
| get()       | string \$token,<br /> string \$key, <br />mixed $default                    | Getting a variable from the Sanctum session                            |
| getAll()    | string \$token                                                              | Getting all variables from the Sanctum session                         |
| put()       | string \$token, <br />string \$key, <br />string \$type,<br />mixed \$value | Setting a variable in the Sanctum session                              |
| forget()    | string \$token, <br /> string \$key                                         | Removing a variable from the Sanctum session                           |
| forgetAll() | string \$token                                                              | Removing all variables from the Sanctum session                        |

### Examples




