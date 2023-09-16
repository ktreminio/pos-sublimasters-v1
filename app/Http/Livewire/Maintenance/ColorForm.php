<?php

namespace App\Http\Livewire\Maintenance;

use App\Models\Color;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ColorForm extends Component
{
    use LivewireAlert;

    public $name, $hex, $action = 'new', $modelId;

    protected $listeners = ['getColorById', 'resetFields'];

    public function getColorById($modelId): void
    {
        $this->modelId = $modelId;
        $category = Color::find($this->modelId);
        $this->name = $category->name;
        $this->hex = $category->hex;
        $this->action = 'edit';
        $this->dispatchBrowserEvent('openModalColor');
    }

    protected function rules() {
        return [
            'name' => ['required', Rule::unique('colors')->ignore($this->modelId)],
            'hex' => 'required'
        ];
    }

    protected function messages() {
        return [
            'name.required' => __('validation.required', ['attribute' => __('pages.fields.name')]),
            'name.unique' => __('validation.unique', ['attribute' => __('pages.fields.name')]),
            'hex.required' => __('validation.required', ['attribute' => __('pages.fields.color')]),
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetFields()
    {
        $this->reset([
            'name',
            'hex',
            'action',
            'modelId'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function save() {
        $this->validate();

        $data = [
            'name' => $this->name,
            'hex' => $this->hex,
            'pasive' => false
        ];

        if ($this->modelId) {
            $data = Arr::add($data, 'modified_by', Auth::user()->id);
        } else {
            $data = Arr::add($data, 'created_by', Auth::user()->id);
        }

        Color::updateOrCreate(['id' => $this->modelId], $data);
        $this->dispatchBrowserEvent('closeModalColor');
        $this->alert('success',
            __('pages.messages_alert.'.($this->modelId ? 'update' : 'create').'.success', ['field' => __('pages.fields.color')]),
            [
                'timer' =>  '7000',
                'toast' =>  true,
                'timerProgressBar' =>  true,
            ]
        );
        $this->resetFields();
        $this->emitTo('maintenance.colors','render');
        $this->emitTo('maintenance.colors','updatingSearch');
    }

    public function render()
    {
        return view('livewire.maintenance.color-form');
    }
}
