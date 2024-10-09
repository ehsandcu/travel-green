<?php

namespace App\Lib;

use ReflectionClass;

class Enum
{
    /**
     * Get array that contains list of constants
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getConstants(): array
    {
        $reflectionClass = new ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }

    /**
     * Get description of enum value
     *
     * @param int $value
     * @return string
     */
    public static function getDescription(int|string $value): string
    {
        $constants = static::getConstants();

        return array_search($value, $constants);
    }

    /**
     * Collect all enum values as array
     *
     * @param bool $withDescription
     * @return array<int, int>|array<int, string>
     * @throws \ReflectionException
     */
    public static function collectAsArray(bool $withDescription = false): array
    {
        $refClass = new ReflectionClass(static::class);
        $enums = $refClass->getConstants();

        if ($withDescription === true) {
            $tempEnums = [];
            foreach ($enums as $enum) {
                $tempEnums[$enum] = self::getDescription($enum);
            }

            $enums = $tempEnums;
        }

        return $enums;
    }

    /**
     * Get values of the enum
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function collectValues(): array
    {
        return array_values(self::getConstants());
    }

    /**
     * Get keys of the enum
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function collectKeys(): array
    {
        return array_keys(self::getConstants());
    }

    /**
     * Check whether a subscription status existed.
     *
     * @param int|string $value
     * @return bool
     * @throws \ReflectionException
     */
    public static function hasValue(int|string $value): bool
    {
        $values = self::collectValues();

        return in_array($value, $values); 
    }
}
