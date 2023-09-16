<?php

namespace App\Http\Livewire\Maintenance;

use App\Models\Color;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ColorSize extends Component
{
    public $color_size_id = '',
        $name_size,
        $sizes = [],
        $quantity_color_size;

    public function addColorToSize($indexSize) {
        $this->validate([
            'color_size_id' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->size)],
            'quantity_color_size' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->size)],
        ]);

        $color = Color::find($this->color_size_id);

        if ($this->sizes[$indexSize]['colors']) {
            foreach ($this->sizes[$indexSize]['colors'] as $color_product) {
                if ($color_product['color_id'] == $this->color_size_id) {
                    $this->alert('info', __('pages.colors.already_added'),
                        [
                            'timer' =>  '7000',
                            'toast' =>  true,
                            'timerProgressBar' =>  true,
                        ]
                    );
                    return;
                }
            }
        }

        $this->sizes[$indexSize]['colors'][] = [
            'color_id' => $this->color_size_id,
            'quantity' => $this->quantity_color_size,
            'color' => $color->name
        ];

        $this->resetColorSizeFields();
    }

    public function render()
    {
        return view('livewire.maintenance.color-size');
    }
}
