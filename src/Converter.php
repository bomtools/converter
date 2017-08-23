<?php
/**
 * Tools for simple variables and array converting
 *
 * @version 0.0.1
 * @released 2017-08-22
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Bakay Omuraliev
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace BomTools;

abstract class Converter
{
    public static function toNumber($variable)
    {
        if (!is_string($variable)) $variable = (string)$variable;
        if (false !== mb_strpos($variable, '.') || false !== mb_strpos($variable, ',')) {
            $variable = str_replace(',', '.', $variable);
            return (float)$variable;
        }
        return (int)$variable;
    }

    public static function arrayToNumber(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToNumber($array);
            else $array[$key] = self::toNumber($value);
        }
        return $array;
    }

    public static function toBool($variable, bool $default = false): bool
    {
        if (is_bool($variable)) return $variable;
        if (is_string($variable)) $variable = trim($variable);

        if (is_array($variable)) {
            return !empty($variable);
        }

        if ('true' === $variable || 1 === $variable ||  '1' === $variable) return true;
        if ('false' === $variable || 0 === $variable || '0' === $variable || null === $variable) return false;

        return $default;
    }

    public static function arrayToBool(array $array, bool $default = false): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToBool($value, $default);
            else $array[$key] = self::toBool($value, $default);
        }
        return $array;
    }

    public static function arrayToString(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToString($value);
            else $array[$key] = (string)$value;
        }
        return $array;
    }

    public static function arrayToInt(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToInt($value);
            else $array[$key] = (int)$value;
        }
        return $array;
    }

    public static function arrayToFloat(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToFloat($value);
            else $array[$key] = (float)$value;
        }
        return $array;
    }

    public static function arrayToFirstLine(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToFirstLine($value);
            else {
                if (!is_string($value)) $value = (string)$value;
                $value = str_replace("\r", "", $value);
                $lines = explode("\n", $value);
                $array[$key] = $lines[0];
            }
        }
        return $array;
    }

    public static function arrayToLine(array $array, string $separator = ' '): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToLine($value);
            else {
                if (!is_string($value)) $value = (string)$value;
                $value = str_replace("\r", "", $value);
                $value = str_replace("\n", $separator, $value);
                $array[$key] = $value;
            }
        }
        return $array;
    }

    public static function arrayRemoveHtml(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayRemoveHtml($value);
            else {
                if (!is_string($value)) $value = (string)$value;
                $array[$key] = strip_tags($value);
            }
        }
        return $array;
    }

    public static function arrayEscapeSpecialChars(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayEscapeSpecialChars($value);
            else {
                if (!is_string($value)) $value = (string)$value;
                $array[$key] = htmlspecialchars($value);
            }
        }
        return $array;
    }

    public static function arrayTrim(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayTrim($value);
            else {
                if (!is_string($value)) $value = (string)$value;
                $array[$key] = trim($value);
            }
        }
        return $array;
    }

    public static function arrayReplace(array $array, string $from, string $to): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayReplace($value, $from, $to);
            else {
                if (!is_string($value)) $value = (string)$value;
                $array[$key] = str_replace($from, $to, $value);
            }
        }
        return $array;
    }

    public static function arrayRemoveNumbers(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayRemoveNumbers($value);
            else {
                if (!is_string($value)) $value = (string)$value;
                $array[$key] = preg_replace('/[0-9]/iu', '', $value);
            }
        }
        return $array;
    }

    public static function arrayLowercase(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayLowerCase($value);
            else {
                if (!is_string($value)) $value = (string)$value;
                $array[$key] = mb_strtolower($value);
            }
        }
        return $array;
    }

    public static function arrayUppercase(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayLowerCase($value);
            else {
                if (!is_string($value)) $value = (string)$value;
                $array[$key] = mb_strtoupper($value);
            }
        }
        return $array;
    }

    public static function arrayToMinimum(array $array, float $minimum): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToMinimum($array, $minimum);
            else $array[$key] = (float)$value < $minimum ? (float)$value : $minimum;
        }
        return $array;
    }

    public static function arrayToMaximum(array $array, float $maximum): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToMaximum($array, $maximum);
            else $array[$key] = (float)$value > $maximum ? (float)$value : $maximum;
        }
        return $array;
    }

    public static function arrayToAbsolute(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayToAbsolute($array);
            else $array[$key] = abs($value);
        }
        return $array;
    }

    public static function arrayStrMaxLength(array $array, int $length): array
    {
        if ($length < 0) $length = abs($length);
        foreach ($array as $key => $value) {
            if (is_array($value)) $array[$key] = self::arrayStrMaxLength($array, $length);
            else {
                if ($length < mb_strlen($array[$key])) {
                    $array[$key] = mb_substr($value, 0, $length, 'UTF-8');
                }
            }
        }
        return $array;
    }
}
