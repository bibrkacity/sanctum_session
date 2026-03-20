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

1. Middleware for get/set locale using the Sanctum session:

```php
<?php

namespace App\Http\Middleware;

use Bibrkacity\SanctumSession\SanctumSesssion;
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
        $locale = $request->input('locale');


        if ($locale && $locale != app()->getLocale() && in_array($locale, $supportedLocales)) {
            app()->setLocale($locale);
        } elseif (SanctumSesssion::has($request, 'locale')) {
            $cacheLocale = SanctumSesssion::get($request, 'locale');
            app()->setLocale(
                in_array($cacheLocale, $supportedLocales) ?
                    $cacheLocale :
                    config('app.locale'));
        } else {
            app()->setLocale(config('app.locale'));
        }

        SanctumCacheService::put($request, 'locale', app()->getLocale());

        return $next($request);
    }
}```




