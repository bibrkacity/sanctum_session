# Sanctum Session
Supporting work with variables related to Sanctum token For Laravel. It can be useful, for example, for storing user preferences or user-specific data.

<!-- TOC -->
* [Sanctum Session](#sanctum-session)
  * [Installation](#installation)
  * [Usage](#usage)
    * [Examples](#examples)
  * [Prune old Sanctum session variables](#prune-old-sanctum-session-variables)
<!-- TOC -->
## Installation
1. Run <br />`composer require bibrkacity/sanctum_session`<br />from the root of your project.
2. Run <br />`php artisan vendor:publish --provider="Bibrkacity\SanctumSession\SanctumSessionServiceProvider"`<br /> from the root of your project.
3. Run <br />`php artisan migrate`<br /> from the root of your project.
## Usage
The Service `Bibrkacity\SanctumSession\SanctumService` available in your project after installation. The token for use as argument in the methods you can get from the request:

```php 
$token = request()->bearerToken();
// or 
$token = $request->bearerToken();
```

Available types of variables:
- string
- integer
- float
- boolean
- array
- object
- json

The Service `Bibrkacity\SanctumSession\SanctumService` has a static methods for work with the Sanctum session variables:

| Method      | Arguments                                                                   | Description                                                            |
|-------------|-----------------------------------------------------------------------------|------------------------------------------------------------------------|
| has()       | string \$token,<br /> string \$key                                          | Checking if a variable with name=\$key exists in the Sanctum session   |
| get()       | string \$token,<br /> string \$key, <br />mixed $default                    | Getting a variable from the Sanctum session                            |
| getAll()    | string \$token                                                              | Getting all variables from the Sanctum session                         |
| put()       | string \$token, <br />string \$key, <br />string \$type,<br />mixed \$value | Setting a variable in the Sanctum session                              |
| forget()    | string \$token, <br /> string \$key                                         | Removing a variable from the Sanctum session                           |
| forgetAll() | string \$token                                                              | Removing all variables from the Sanctum session                        |

### Examples

1. Middleware for get/set locale using the Sanctum session:

```php
<?php

namespace App\Http\Middleware;

use Bibrkacity\SanctumSession\Services\SanctumSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = config('app.supported_locales');
        $defaultLocale = config('app.locale');
        $locale = $request->input('locale');

        if ($locale && in_array($locale, $supportedLocales)) {
            app()->setLocale($locale);
        } elseif (SanctumSession::has($request->bearerToken(), 'locale')) {
            $sessionLocale = SanctumSession::get($request->bearerToken(), 'locale');
            app()->setLocale(
                in_array($sessionLocale, $supportedLocales) ?
                    $sessionLocale :
                    $defaultLocale
            );
        } else {
            app()->setLocale($defaultLocale);
        }
        $locale = app()->getLocale();
        if ($locale === $defaultLocale) {
            SanctumSession::forget($request->bearerToken(), 'locale');
        } else {
            SanctumSession::put($request->bearerToken(), 'locale', 'string', $locale);
        }


        return $next($request);
    }
}
```
## Prune old Sanctum session variables
You can prune old session variables by running the command: 
`php artisan sanctum::prune-expired`



