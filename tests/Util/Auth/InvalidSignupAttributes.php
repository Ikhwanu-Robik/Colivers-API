<?php

namespace Tests\Util\Auth;

class InvalidSignupAttributes
{
    private $invalidAttributes;

    public function __construct()
    {
        $this->invalidAttributes = $this->createInvalidAttributes();
    }

    private function createInvalidAttributes()
    {
        return [
            'name' => null,
            'phone' => '+628122908228',
            'password' => null,
            'birthdate' => now()->toDateString(),
            'gender' => 'transgender'
        ];
    }

    public function filterByKeys($keys)
    {
        $filtered = [];
        foreach ($keys as $key) {
            $filtered[$key] = $this->invalidAttributes[$key];
        }
        return $filtered;
    }
}