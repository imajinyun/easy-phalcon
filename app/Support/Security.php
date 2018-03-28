<?php

namespace App\Support;

use Illuminate\Support\Arr;

final class Security
{
    /**
     * Generate sign.
     *
     * @param array  $data
     * @param string $code
     *
     * @return bool|string
     */
    public static function generateSign($data, $code)
    {
        $json = json_encode($data) . $code;
        $sign = sha1(md5(sha1(md5($json))));
        $sign = substr($sign, 4, 32);

        return $sign;
    }

    /**
     * Verify sign.
     *
     * @param array $keys
     * @param array $data
     *
     * @return bool
     */
    public static function verifySign(array $keys, array $data = []): bool
    {
        $source = Arr::get($keys, 'data_sign');
        if (! $source) {
            return false;
        }
        $secret = env('APP_SECRET');
        $target = self::generateSign($data, $secret);

        return $target === $source;
    }

    /**
     * 加密数据字段
     *
     * Usage:
     *
     * ```php
     * $array = [
     *     self::encrypt('name'),
     *     self::encrypt('name', 'alias'),
     *     self::encrypt('name', 'alias', 'prefix'),
     * ];
     *
     * // Output:
     * [
     *     "ENCODE(name, 'your secret')",
     *     "ENCODE(name, 'your secret') AS alias",
     *     "ENCODE(prefix.name, 'your secret') AS alias",
     * ]
     * ```
     *
     * @param string $field  字段
     * @param string $alias  别名
     * @param string $prefix 前缀
     *
     * @return string
     */
    public static function encrypt($field, $alias = '', $prefix = ''): string
    {
        $key = env('DB_SECRET');
        $prefix = $prefix ? "{$prefix}." : '';
        $value = "ENCODE('{$prefix}{$field}', '{$key}')";

        if ($alias) {
            return $value . ' AS ' . $alias;
        }

        return $value;
    }

    /**
     * 解密数据字段
     *
     * Usage:
     *
     * ```php
     * $array = [
     *     self::decrypt('name'),
     *     self::decrypt('name', 'alias'),
     *     self::decrypt('name', 'alias', 'prefix'),
     * ];
     *
     * // Output:
     * [
     *     "DECODE(name, 'your secret')",
     *     "DECODE(name, 'your secret') AS alias",
     *     "DECODE(prefix.name, 'your secret') AS alias",
     * ]
     * ```
     *
     * @param string $field  字段
     * @param string $alias  别名
     * @param string $prefix 前缀
     *
     * @return string
     */
    public static function decrypt($field, $alias = '', $prefix = ''): string
    {
        $key = env('DB_SECRET');
        $prefix = $prefix ? "{$prefix}." : '';
        $value = "DECODE({$prefix}{$field}, '{$key}')";

        if ($alias) {
            return $value . ' AS ' . $alias;
        }

        return $value;
    }
}
