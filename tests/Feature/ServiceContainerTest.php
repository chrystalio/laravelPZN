<?php

namespace Tests\Feature;

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
}
