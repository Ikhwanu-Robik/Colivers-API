<?php

namespace Tests\Util\Auth;

class SignUpUtil
{
    private static $signUpData;

    private static $invalidSignUpData;

    public static function getSignUpDataWithout(array $exclusions)
    {
        self::setupSignUpData();
        return self::excludeFromSignUpData($exclusions);
    }

    private static function setupSignUpData()
    {
        self::$signUpData = [
            'name' => fake()->name(),
            'phone' => '0812-2938-2333', // faker doesn't support localization here
            'password' => fake()->password(),
            'birthdate' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'address' => fake()->address(),
            'bio' => fake()->realText(),
        ];
    }

    private static function excludeFromSignUpData(array $exclusions)
    {
        $filteredSignUpData = array_diff_key(
            self::$signUpData,
            array_flip($exclusions)
        );
        return $filteredSignUpData;
    }

    public static function getSignUpDataInvalidate(array $invalidKeys)
    {
        self::setupInvalidSignupData();
        $invalids = self::getInvalidSignUpDataByKeys($invalidKeys);
        $data = self::getSignUpDataReplaceWith($invalids);

        return $data;
    }

    private static function setupInvalidSignUpData()
    {
        self::$invalidSignUpData = [
            'name' => null,
            'phone' => '+628122908228',
            'password' => null,
            'birthdate' => now()->toDateString(),
            'gender' => 'transgender'
        ];
    }

    private static function getInvalidSignUpDataByKeys(array $invalidKeys)
    {
        $filteredInvalidSignUpData = [];
        foreach ($invalidKeys as $invalidKey) {
            $filteredInvalidSignUpData[$invalidKey] = self::$invalidSignUpData[$invalidKey];
        }
        return $filteredInvalidSignUpData;
    }

    private static function getSignUpDataReplaceWith(array $replacings)
    {
        $data = self::$signUpData;
        foreach ($replacings as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }
}