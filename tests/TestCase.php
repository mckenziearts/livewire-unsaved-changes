<?php

declare(strict_types=1);

namespace ShopperLabs\LivewireUnsavedChanges\Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use ShopperLabs\LivewireUnsavedChanges\Providers\LivewireUnsavedChangesServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            LivewireUnsavedChangesServiceProvider::class,
        ];
    }

}
