<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Data\Foo;

class ServiceContainerTest extends TestCase
{

    public function testDependency(): void
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

    public function testInstance()
    {
        $person = new Person('Chrystalio', 'Kie');
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // $person
        $person2 = $this->app->make(Person::class); // $person
        $person3 = $this->app->make(Person::class); // $person
        $person4 = $this->app->make(Person::class); // $person

        self::assertEquals('Chrystalio', $person1->firstName);
        self::assertEquals('Chrystalio', $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection(): void
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);

        self::assertSame($foo, $bar->foo);
    }

    public function testDependencyInjectionClosure(): void
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);


        self::assertSame($foo, $bar1->foo);
        self::assertSame($bar1, $bar2);
    }
}
