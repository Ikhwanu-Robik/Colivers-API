<?php

namespace Tests\Util\Auth;

class SignupAttributes
{
    private $attributes;
    private $invalidAttributes;

    public function __construct()
    {
        $this->attributes = $this->createAttributes();
        $this->invalidAttributes = $this->createInvalidAttributes();
    }

    private function createAttributes()
    {
        return [
            'name' => fake()->name(),
            'phone' => '0812-2938-2333', // faker doesn't support localization here
            'password' => fake()->password(),
            'birthdate' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'address' => fake()->address(),
            'bio' => fake()->realText(),
        ];
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

    public function exclude($exclusions)
    {
        $filteredAttributes = array_diff_key(
            $this->attributes,
            array_flip($exclusions)
        );

        return $filteredAttributes;
    }

    public function invalidate($keysToInvalidate)
    {
        $filteredInvalidAttributes = $this->getInvalidAttributesByKeys($keysToInvalidate);
        $attributesWithInvalids = $this->replaceWithInvalid($filteredInvalidAttributes);

        return $attributesWithInvalids;
    }

    private function getInvalidAttributesByKeys($keys)
    {
        $filtered = [];
        foreach ($keys as $key) {
            $filtered[$key] = $this->invalidAttributes[$key];
        }
        return $filtered;
    }

    private function replaceWithInvalid($invalids)
    {
        foreach ($invalids as $key => $value) {
            $this->attributes[$key] = $value;
        }
        return $this->attributes;
    }
}
