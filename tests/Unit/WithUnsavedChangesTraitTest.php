<?php

declare(strict_types=1);

use Livewire\Component;
use Livewire\Form;
use ShopperLabs\LivewireUnsavedChanges\Traits\WithUnsavedChanges;

class TestForm extends Form
{
    public string $name = '';

    public string $email = '';
}

class ComponentWithArrayForm extends Component
{
    use WithUnsavedChanges;

    public array $form = [
        'name' => 'John',
        'email' => 'john@example.com',
    ];

    public function render(): string
    {
        return '<div></div>';
    }
}

class ComponentWithFormObject extends Component
{
    use WithUnsavedChanges;

    public TestForm $form;

    public function mount(): void
    {
        $this->form = new TestForm($this, 'form');
        $this->form->name = 'John';
        $this->form->email = 'john@example.com';
    }

    public function render(): string
    {
        return '<div></div>';
    }
}

class ComponentWithoutForm extends Component
{
    use WithUnsavedChanges;

    public function render(): string
    {
        return '<div></div>';
    }
}

describe('WithUnsavedChanges Trait', function (): void {
    it('returns form data from array form', function (): void {
        $component = new ComponentWithArrayForm;

        expect($component->getUnsavedChangesData())->toBe([
            'name' => 'John',
            'email' => 'john@example.com',
        ]);
    });

    it('returns empty array when no form property exists', function (): void {
        $component = new ComponentWithoutForm;

        expect($component->getUnsavedChangesData())->toBe([]);
    });

    it('updates array form with saveChanges', function (): void {
        $component = new ComponentWithArrayForm;

        $component->saveChanges([
            'name' => 'Jane',
            'email' => 'jane@example.com',
        ]);

        expect($component->form)->toBe([
            'name' => 'Jane',
            'email' => 'jane@example.com',
        ]);
    });
});
