<?php

namespace App\Http\Livewire\Maintenance;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CategoryForm extends Component
{
    public $name, $icon, $action = 'new', $modelId;

    protected $listeners = ['getCategoryById', 'resetFields'];

    public function getCategoryById($modelId): void
    {
        $this->modelId = $modelId;
        $category = Category::find($this->modelId);
        $this->name = $category->name;
        $this->icon = $category->icon;
        $this->action = 'edit';
        $this->dispatchBrowserEvent('openModalCategory');
    }

    protected function rules() {
        return [
            'name' => ['required', Rule::unique('categories')->ignore($this->modelId)],
        ];
    }

    protected function messages() {
        return [
            'name.required' => __('validation.required', ['attribute' => __('pages.fields.name')]),
            'name.unique' => __('validation.unique', ['attribute' => __('pages.fields.name')]),
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
            'icon',
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
            'icon' => $this->icon,
            'pasive' => false
        ];

        if ($this->modelId) {
            $data = Arr::add($data, 'modified_by', Auth::user()->id);
            $record = Category::find($this->modelId);
            $record->update($data);
        } else {
            $data = Arr::add($data, 'created_by', Auth::user()->id);
            Category::create($data);
        }

        $this->emitTo('maintenance.categories','render');
        $this->emitTo('maintenance.categories','updatingSearch');
        $this->resetFields();
        $this->dispatchBrowserEvent('closeModalCategory');
    }

    public function render()
    {
        return view('livewire.maintenance.category-form');
    }
}
