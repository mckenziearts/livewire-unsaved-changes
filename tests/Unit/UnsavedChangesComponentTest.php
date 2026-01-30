<?php

declare(strict_types=1);

use ShopperLabs\LivewireUnsavedChanges\View\Components\UnsavedChanges;

describe('UnsavedChanges Component', function (): void {
    it('has default values', function (): void {
        $component = new UnsavedChanges;

        expect($component->form)->toBe([])
            ->and($component->saveMethod)->toBe('saveChanges')
            ->and($component->position)->toBe('bottom')
            ->and($component->preventNavigation)->toBeFalse();
    });

    it('accepts custom data', function (): void {
        $data = ['name' => 'John', 'email' => 'john@example.com'];
        $component = new UnsavedChanges(form: $data);

        expect($component->form)->toBe($data);
    });

    it('accepts custom save method', function (): void {
        $component = new UnsavedChanges(saveMethod: 'customSave');

        expect($component->saveMethod)->toBe('customSave');
    });

    it('accepts custom position', function (): void {
        $component = new UnsavedChanges(position: 'top');

        expect($component->position)->toBe('top');
    });

    it('accepts prevent navigation option', function (): void {
        $component = new UnsavedChanges(preventNavigation: true);

        expect($component->preventNavigation)->toBeTrue();
    });

    it('accepts custom message', function (): void {
        $component = new UnsavedChanges(message: 'Custom message');

        expect($component->getMessage())->toBe('Custom message');
    });

    it('accepts custom save label', function (): void {
        $component = new UnsavedChanges(saveLabel: 'Save now');

        expect($component->getSaveLabel())->toBe('Save now');
    });

    it('accepts custom discard label', function (): void {
        $component = new UnsavedChanges(discardLabel: 'Reset');

        expect($component->getDiscardLabel())->toBe('Reset');
    });
});
