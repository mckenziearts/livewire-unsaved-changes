<?php

declare(strict_types=1);

namespace ShopperLabs\LivewireUnsavedChanges\Traits;

use Livewire\Form;

trait WithUnsavedChanges
{
    /**
     * Get the form data for the unsaved changes component.
     * Override this method if your form property has a different name.
     *
     * @return array<string, mixed>
     */
    public function getUnsavedChangesData(): array
    {
        if (property_exists($this, 'form')) {
            $form = $this->form;

            if ($form instanceof Form) {
                return $form->all();
            }

            if (is_array($form)) {
                return $form;
            }
        }

        return [];
    }

    /**
     * Handle the save action from the unsaved changes component.
     * Override this method to customize the save behavior.
     *
     * @param  array<string, mixed>  $formData
     */
    public function saveChanges(array $formData): void
    {
        if (property_exists($this, 'form')) {
            if ($this->form instanceof Form) {
                $this->form->fill($formData);
            } elseif (is_array($this->form)) {
                $this->form = $formData;
            }
        }
    }
}
