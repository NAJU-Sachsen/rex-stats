<?php

class naju_credentials
{
    private static $TOKEN_CHARS = 'abcdefghijklmnopqrstuvwxyz0123456789';

    public static function generateToken($lenght=128)
    {
        $token = '';
        for ($i = 0; $i < $lenght; ++$i) {
            $token .= self::$TOKEN_CHARS[random_int(0, strlen(self::$TOKEN_CHARS)-1)];
        }
        return $token;
    }

    public static function checkToken($token)
    {
        $sql = rex_sql::factory()->setQuery('select token from naju_stat_credential where token = :token', ['token' => $token]);
        return 1 == $sql->getRows();
    }

}
