<?php

declare(strict_types=1);

namespace ShopperLabs\LivewireUnsavedChanges\Providers;

use Illuminate\Support\Facades\Blade;
use ShopperLabs\LivewireUnsavedChanges\View\Components\UnsavedChanges;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class LivewireUnsavedChangesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('livewire-unsaved-changes')
            ->hasConfigFile('unsaved-changes')
            ->hasViews()
            ->hasTranslations()
            ->hasAssets();
    }

    public function bootingPackage(): void
    {
        Blade::component('unsaved-changes', UnsavedChanges::class);
    }
}
