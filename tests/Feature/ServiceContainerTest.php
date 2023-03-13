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

    public function testBind()
    {
//        $person = $this->app->make(Person::class);
//        self::assertNotNull($person);

        $this->app->bind(Person::class, function ($app) {
            return new Person('Chrystalio', 'Kie');
        });

        $person1 = $this->app->make(Person::class); // closure() // new Person("Chrystalio", "Kie")
        $person2 = $this->app->make(Person::class); // closure() // new Person("Chrystalio", "Kie")

        self::assertEquals('Chrystalio', $person1->firstName);
        self::assertEquals('Chrystalio', $person2->firstName);
        self::assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app) {
            return new Person('Chrystalio', 'Kie');
        });

        $person1 = $this->app->make(Person::class); // new Person("Chrystalio", "Kie") ;  If not exist, create new instance
        $person2 = $this->app->make(Person::class); // If exist, return existing instance

        self::assertEquals('Chrystalio', $person1->firstName);
        self::assertEquals('Chrystalio', $person2->firstName);
        self::assertSame($person1, $person2);
    }
}
