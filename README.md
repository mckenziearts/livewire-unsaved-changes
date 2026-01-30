<p>
    <a href="https://github.com/mckenziearts/livewire-unsaved-changes/actions"><img src="https://github.com/mckenziearts/livewire-unsaved-changes/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
    <a href="https://github.com/mckenziearts/livewire-unsaved-changes/actions/workflows/quality.yml"><img src="https://github.com/mckenziearts/livewire-unsaved-changes/actions/workflows/quality.yml/badge.svg" alt="Coding Standards" /></a>
    <a href="https://packagist.org/packages/mckenziearts/livewire-unsaved-changes"><img src="https://img.shields.io/packagist/dt/mckenziearts/livewire-unsaved-changes" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/mckenziearts/livewire-unsaved-changes"><img src="https://img.shields.io/packagist/v/mckenziearts/livewire-unsaved-changes" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/mckenziearts/livewire-unsaved-changes"><img src="https://img.shields.io/packagist/l/mckenziearts/livewire-unsaved-changes" alt="License"></a>
</p>

# Introduction

A beautiful, animated "unsaved changes" bar for Laravel Livewire forms. Powered by Alpine.js for instant UI feedback without server round-trips.

## Features

- Animated slide-in bar when form changes are detected
- No server requests until save - instant UI feedback
- Prevent navigation with unsaved changes (optional)
- Customizable position (top/bottom)

## Installation

```bash
composer require mckenziearts/livewire-unsaved-changes
```

### Styling

The component uses Tailwind CSS classes. Choose the appropriate method based on your project setup:

#### Option 1: Project with Tailwind CSS (Recommended)

If your project already uses Tailwind CSS, simply add the package's views to your source paths in your CSS file:

```css
@import 'tailwindcss';

@source '../../vendor/mckenziearts/livewire-unsaved-changes/resources/views/**/*.blade.php';
```

This allows Tailwind to scan the component's Blade files and generate the necessary classes automatically.

#### Option 2: Project without Tailwind CSS

If your project doesn't use Tailwind CSS, publish the pre-compiled CSS assets:

```bash
php artisan vendor:publish --tag="livewire-unsaved-changes-assets"
```

Then include the CSS in your layout:

```blade
<link rel="stylesheet" href="{{ asset('vendor/livewire-unsaved-changes/unsaved-changes.css') }}">
```

### Optional Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag="livewire-unsaved-changes-config"
```

Publish the translations:

```bash
php artisan vendor:publish --tag="livewire-unsaved-changes-translations"
```

## Usage

### Basic Usage

Wrap your form with the `<x-unsaved-changes>` component and use `x-model` to bind your inputs:

```blade
<x-unsaved-changes :data="$form" save-method="save">
    <div class="space-y-4">
        <input x-model="form.name" type="text" />
        <input x-model="form.email" type="email" />
    </div>
</x-unsaved-changes>
```

In your Livewire component:

```php
<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

class Settings extends Component
{
    public array $form = [
        'name' => '',
        'email' => '',
    ];

    public function mount(): void
    {
        $this->form = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ];
    }

    public function save(array $form): void
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|email',
        ]);

        auth()->user()->update($form);

        $this->form = $form;

        session()->flash('success', 'Settings saved!');
    }
}
```

### With Livewire Form Objects

```php
<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Livewire\Form;

class SettingsForm extends Form
{
    public string $name = '';
    public string $email = '';

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
        ];
    }
}
```

```php
<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Forms\SettingsForm;
use Livewire\Component;

class Settings extends Component
{
    public SettingsForm $form;

    public function mount(): void
    {
        $this->form->name = auth()->user()->name;
        $this->form->email = auth()->user()->email;
    }

    public function save(array $form): void
    {
        $this->form->fill($form);
        $this->form->validate();

        auth()->user()->update($this->form->all());

        session()->flash('success', 'Settings saved!');
    }
}
```

```blade
<x-unsaved-changes :form="$form->all()" save-method="save">
    <input x-model="form.name" type="text" />
    <input x-model="form.email" type="email" />
</x-unsaved-changes>
```

### Using the Trait (Optional)

The package includes a trait that provides a default `saveChanges` method:

```php
declare(strict_types=1);

use ShopperLabs\LivewireUnsavedChanges\Traits\WithUnsavedChanges;

class Settings extends Component
{
    use WithUnsavedChanges;

    public array $form = [];

    public function saveChanges(array $form): void
    {
        parent::saveChanges($form); // Updates $this->form

        // Your save logic here
        auth()->user()->update($this->form);
    }
}
```

## Props

| Prop                 | Type     | Default        | Description                                                 |
|----------------------|----------|----------------|-------------------------------------------------------------|
| `form`               | `array`  | `[]`           | The form data to track                                      |
| `save-method`        | `string` | `saveChanges`  | The Livewire method to call on save                         |
| `position`           | `string` | `bottom`       | Bar position: `top` or `bottom`                             |
| `prevent-navigation` | `bool`   | `false`        | Show browser confirmation when leaving with unsaved changes |
| `message`            | `string` | *(translated)* | Custom message text                                         |
| `save-label`         | `string` | *(translated)* | Custom save button label                                    |
| `discard-label`      | `string` | *(translated)* | Custom discard button label                                 |

### Examples

**Position at top:**

```blade
<x-unsaved-changes :$form position="top">
    ...
</x-unsaved-changes>
```

**Prevent navigation:**

```blade
<x-unsaved-changes :$form prevent-navigation>
    ...
</x-unsaved-changes>
```

**Custom labels:**

```blade
<x-unsaved-changes
    :$form
    message="You have pending changes"
    save-label="Save now"
    discard-label="Reset"
>
    ...
</x-unsaved-changes>
```

## Configuration

```php
// config/unsaved-changes.php

return [
    // Bar position: 'bottom' or 'top'
    'position' => 'bottom',

    // Show browser confirmation when leaving with unsaved changes
    'prevent_navigation' => false,
];
```

## Translations (optional)

The package includes English and French translations. You can publish and customize them:

```bash
php artisan vendor:publish --tag="livewire-unsaved-changes-translations"
```

## Important: Use x-model, not wire:model

This component requires `x-model` for form bindings. Using `wire:model` will not work because:

1. `wire:model` syncs data with the server (Livewire)
2. The component tracks changes using Alpine.js (client-side)
3. Alpine won't detect changes made via `wire:model`

```blade
{{-- Correct --}}
<input x-model="form.name" />

{{-- Won't work --}}
<input wire:model="form.name" />
```

This is by design - the whole point is to avoid server requests until the user saves.

## Customization

To customize the component markup, publish the views:

```bash
php artisan vendor:publish --tag="livewire-unsaved-changes-views"
```

## License

MIT License. See [LICENSE](LICENSE) for more information.
