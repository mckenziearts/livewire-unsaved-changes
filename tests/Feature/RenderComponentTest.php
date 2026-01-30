<?php

declare(strict_types=1);

use ShopperLabs\LivewireUnsavedChanges\View\Components\UnsavedChanges;

function renderComponent(UnsavedChanges $component, string $slot = ''): string
{
    return view('livewire-unsaved-changes::unsaved-changes-bar', [
        'form' => $component->form,
        'color' => $component->color,
        'saveMethod' => $component->saveMethod,
        'position' => $component->position,
        'preventNavigation' => $component->preventNavigation,
        'message' => $component->message,
        'saveLabel' => $component->saveLabel,
        'discardLabel' => $component->discardLabel,
        'slot' => new Illuminate\Support\HtmlString($slot),
        'getMessage' => $component->getMessage(...),
        'getSaveLabel' => $component->getSaveLabel(...),
        'getDiscardLabel' => $component->getDiscardLabel(...),
    ])->render();
}

describe('Unsaved Changes Component Rendering', function (): void {
    it('renders the component', function (): void {
        $component = new UnsavedChanges(form: []);
        $html = renderComponent($component);

        expect($html)->toContain('x-data');
        expect($html)->toContain('isDirty');
    });

    it('renders with custom data', function (): void {
        $component = new UnsavedChanges(form: ['name' => 'John']);
        $html = renderComponent($component);

        expect($html)->toContain('John');
    });

    it('renders with custom save method', function (): void {
        $component = new UnsavedChanges(form: [], saveMethod: 'customSave');
        $html = renderComponent($component);

        expect($html)->toContain('customSave');
    });

    it('renders with bottom position by default', function (): void {
        $component = new UnsavedChanges(form: []);
        $html = renderComponent($component);

        expect($html)->toContain('bottom-6');
    });

    it('renders with top position when specified', function (): void {
        $component = new UnsavedChanges(form: [], position: 'top');
        $html = renderComponent($component);

        expect($html)->toContain('top-6');
    });

    it('renders slot content', function (): void {
        $component = new UnsavedChanges(form: []);
        $html = renderComponent($component, '<input type="text" id="test-input" />');

        expect($html)->toContain('test-input');
    });

    it('renders with prevent navigation script when enabled', function (): void {
        $component = new UnsavedChanges(form: [], preventNavigation: true);
        $html = renderComponent($component);

        expect($html)->toContain('beforeunload');
    });

    it('does not render prevent navigation script when disabled', function (): void {
        $component = new UnsavedChanges(form: [], preventNavigation: false);
        $html = renderComponent($component);

        expect($html)->not->toContain('beforeunload');
    });

    it('renders custom message', function (): void {
        $component = new UnsavedChanges(form: [], message: 'Custom message here');
        $html = renderComponent($component);

        expect($html)->toContain('Custom message here');
    });

    it('renders custom save label', function (): void {
        $component = new UnsavedChanges(form: [], saveLabel: 'Save now');
        $html = renderComponent($component);

        expect($html)->toContain('Save now');
    });

    it('renders custom discard label', function (): void {
        $component = new UnsavedChanges(form: [], discardLabel: 'Reset form');
        $html = renderComponent($component);

        expect($html)->toContain('Reset form');
    });

    it('includes alpine directives', function (): void {
        $component = new UnsavedChanges(form: []);
        $html = renderComponent($component);

        expect($html)->toContain('x-show="isDirty"');
        expect($html)->toContain('x-on:click="save"');
        expect($html)->toContain('x-on:click="discard"');
        expect($html)->toContain('x-cloak');
    });

    it('includes loading state', function (): void {
        $component = new UnsavedChanges(form: []);
        $html = renderComponent($component);

        expect($html)->toContain('x-bind:disabled="loading"');
        expect($html)->toContain('x-show="loading"');
    });
});
