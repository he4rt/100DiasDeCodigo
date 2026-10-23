<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithCachedRoutes;

abstract class TestCase extends BaseTestCase
{
    use WithCachedRoutes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }
}
