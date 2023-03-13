<?php

namespace Tests\Feature;

use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Data\Foo;

class ServiceContainerTest extends TestCase
{

    public function testDependencyInjection(): void
    {
        $foo1 = $this->app->make(Foo::class); // new Foo()
        $foo2 = $this->app->make(Foo::class); // new Foo()

        self::assertEquals("Foo", $foo1->foo());
        self::assertEquals("Foo", $foo2->foo());
        self::assertNotSame($foo1, $foo2);
    }

    public function testBind(){
//        $person = $this->app->make(Person::class);
//        self::assertNotNull($person);

        $this->app->bind(Person::class, function ($app) {
            return new Person('Chrystalio', 'Kie');
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals('Chrystalio', $person1->firstName);
        self::assertEquals('Kie', $person2->lastName);
        self::assertNotSame($person1, $person2);
    }
}
