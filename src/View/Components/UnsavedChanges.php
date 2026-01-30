<?php

declare(strict_types=1);

namespace ShopperLabs\LivewireUnsavedChanges\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class UnsavedChanges extends Component
{
    public string $position;

    public bool $preventNavigation;

    /**
     * @param  array<string, mixed>  $form
     */
    public function __construct(
        public array $form = [],
        public string $saveMethod = 'saveChanges',
        public string $color = 'blue',
        ?string $position = null,
        ?bool $preventNavigation = null,
        public ?string $message = null,
        public ?string $saveLabel = null,
        public ?string $discardLabel = null,
    ) {
        $this->position = $position ?? config('unsaved-changes.position', 'bottom');
        $this->preventNavigation = $preventNavigation ?? config('unsaved-changes.prevent_navigation', false);
    }

    public function getMessage(): string
    {
        return $this->message ?? __('livewire-unsaved-changes::messages.unsaved_changes');
    }

    public function getSaveLabel(): string
    {
        return $this->saveLabel ?? __('livewire-unsaved-changes::messages.save');
    }

    public function getDiscardLabel(): string
    {
        return $this->discardLabel ?? __('livewire-unsaved-changes::messages.discard');
    }

    public function render(): View
    {
        return view('livewire-unsaved-changes::unsaved-changes-bar');
    }
}
