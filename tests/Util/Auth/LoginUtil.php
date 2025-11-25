<?php

namespace Tests\Util\Auth;

use App\Models\User;

class LoginUtil
{
    public static function getLoginDataWithout(array $exclusions)
    {
        $loginData = self::getLoginData();
        return self::excludeFromLoginData($loginData, $exclusions);
    }

    public static function getLoginDataInvalidate(array $keysToInvalidate)
    {
        $loginData = self::getLoginData();
        $invalidLoginData = self::getInvalidLoginData();

        $filteredInvalidLoginData = self::filterInvalidLoginData(
           $invalidLoginData,
           $keysToInvalidate
        );

        return self::replaceLoginData($loginData, $filteredInvalidLoginData);
    }

    public static function getIncorrectLoginData()
    {
        $loginData = self::getLoginData();
        $wrongLoginData = self::setWrongPhoneTo($loginData);

        return $wrongLoginData;
    }

    private static function setWrongPhoneTo(array $loginData)
    {
        $otherPhone = '0812-2782-8219';
        $loginData['phone'] = $otherPhone;

        return $loginData;
    }

    private static function getLoginData()
    {
        $user = self::createUser();
        $loginData = [
            'phone' => $user->phone,
            'password' => $user->passwordPlain
        ];
        return $loginData;
    }
    
    private static function createUser()
    {
        $phone = '0812-6578-9189'; // factory doesn't generate phone with this format
        $password = '12345678';
        $user = User::factory()->create(['phone' => $phone, 'password' => $password]);
        $user->passwordPlain = $password;
        return $user;
    }

    private static function excludeFromLoginData(array $loginData, array $exclusions)
    {
        $filteredLoginData = array_diff_key(
            $loginData,
            array_flip($exclusions)
        );

        return $filteredLoginData;
    }

    private static function getInvalidLoginData()
    {
        $invalidLoginData = [
            'phone' => '+628122908228',
            'password' => null
        ];
        return $invalidLoginData;
    }

    private static function filterInvalidLoginData(array $invalidLoginData, array $keysToInvalidate)
    {
        $filtered = [];
        foreach ($keysToInvalidate as $key) {
            $filtered[$key] = $invalidLoginData[$key];
        }
        return $filtered;
    }

    private static function replaceLoginData(array $loginData, array $replacings)
    {
        foreach ($replacings as $key => $value) {
            $loginData[$key] = $value;
        }
        return $loginData;
    }
}
