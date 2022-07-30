<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfig(){
        $firstName = config('contoh.author.first');
        $lastName = config('contoh.author.last');
        $email = config('contoh.email');
        $website = config('contoh.website');

        self::assertEquals('John', $firstName);
        self::assertEquals('Doe', $lastName);
        self::assertEquals('johndoe@example.com', $email);
        self::assertEquals('https://example.com', $website);
    }
}
