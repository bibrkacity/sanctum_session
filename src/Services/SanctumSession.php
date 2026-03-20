<?php

namespace Bibrkacity\SanctumSession\Services;

use Bibrkacity\SanctumSession\Models\PersonalAccessTokenVar;

/**
 * Service for working with session variables of the Sanctum
 */
class SanctumSession
{
    /**
     * The available types of variables
     * @var array|string[]
     */
    protected static array $available = ['int','integer','float','bool','boolean','string','array','json','object'];

    /**
     * Getting a variable from the Sanctum session
     * @param string $token Sanctum token
     * @param string $key Variable key
     * @param mixed|null $default Default value if the variable is not found
     * @return mixed Variable value
     */
    public static function get(string $token, string $key, mixed $default = null): mixed
    {
        $var = PersonalAccessTokenVar::query()
            ->where('personal_access_token_id', self::getTokenId($token))
            ->where('key', $key)
            ->first();
        if (!$var) {
            return $default;
        }

        return self::convert($var->type, $var->value);

    }

    /**
     * Getting all variables from the Sanctum session
     * @param string $token Sanctum token
     * @return array
     */
    public static function getAll(string $token): array
    {
        $vars = PersonalAccessTokenVar::query()
            ->where('personal_access_token_id', self::getTokenId($token))
            ->get();

        $session = [];

        foreach ($vars as $var) {

            $session[$var->key] = self::convert($var->type, $var->value);

        }

        return $session;
    }

    /**
     * Setting a variable in the Sanctum session
     * @param string $token Sanctum token
     * @param string $key Variable key
     * @param string $type Variable type
     * @param mixed $value Variable value
     * @return void
     */
    public static function put(string $token, string $key, string $type, mixed $value): void
    {

        $type = strtolower($type);

        if (!in_array($type, self::$available)) {
            throw new \InvalidArgumentException('Invalid type: '.$type);
        }

        $stringValue =  match($type) {
            'bool','boolean' => $value ? '1' : '0',
            'array', 'json', 'object' => json_encode($value),
            default => (string) $value,
        };

        $var = PersonalAccessTokenVar::query()
            ->where('personal_access_token_id', self::getTokenId($token))
            ->where('key', $key)
            ->first();

        if ($var) {
            $var->value = $stringValue;
            $var->type = $type;
        } else {
            $var = PersonalAccessTokenVar::create([
                'personal_access_token_id' => self::getTokenId($token),
                'key' => $key,
                'type' => $type,
                'value' => $stringValue,
            ]);
        }
        $var->save();
    }

    /**
     * Removing a variable from the Sanctum session
     * @param string $token Sanctum token
     * @param string $key Variable key
     * @return void
     */
    public static function forget(string $token, string $key): void
    {

        PersonalAccessTokenVar::query()
            ->where('personal_access_token_id', self::getTokenId($token))
            ->where('key', $key)
            ->delete();
    }

    /**
     * Removing all variables from the Sanctum session
     * @param string $token
     * @return void
     */
    public static function forgetAll(string $token): void
    {

        PersonalAccessTokenVar::query()
            ->where('personal_access_token_id', self::getTokenId($token))
            ->delete();
    }

    protected static function getTokenId(string $token): int
    {
        return (int) explode('|', $token)[0];
    }

    protected static function convert(string $type, string $value): mixed
    {
        return match($type) {
            'int','integer' => (int) $value,
            'float' => (float) $value,
            'bool','boolean' => (bool) $value,
            'string' => (string) $value,
            'array', 'json', 'object' => json_decode($value, true),

        };
    }
}
