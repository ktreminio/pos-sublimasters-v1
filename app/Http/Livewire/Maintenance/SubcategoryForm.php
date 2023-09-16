<?php

namespace App\Http\Livewire\Maintenance;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SubcategoryForm extends Component
{
    public $name,
        $icon,
        $color = false,
        $size = false,
        $category_id = '',
        $action = 'new',
        $modelId;

    protected $listeners = ['getSubCategoryById', 'resetFields', 'changeCategory'];

    public function changeCategory($value)
    {
        $this->category_id = $value;
    }

    public function getSubCategoryById($modelId): void
    {
        $this->modelId = $modelId;
        $model = SubCategory::find($this->modelId);
        $this->name = $model->name;
        $this->icon = $model->icon;
        $this->color = $model->color;
        $this->size = $model->size;
        $this->category_id = $model->category_id;
        $this->action = 'edit';
        $this->dispatchBrowserEvent('setValueCategorySelect', ['category_id' => $this->category_id]);
        $this->dispatchBrowserEvent('openModalSubCategory');
    }

    protected function rules() {
        return [
            'name' => ['required', Rule::unique('sub_categories')->ignore($this->modelId)],
            'category_id' => ['required']
        ];
    }

    protected function messages() {
        return [
            'name.required' => __('validation.required', ['attribute' => __('pages.fields.name')]),
            'name.unique' => __('validation.unique', ['attribute' => __('pages.fields.name')]),
            'category_id.required' => __('validation.required', ['attribute' => __('pages.fields.category')]),
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
            'color',
            'size',
            'category_id',
            'action',
            'modelId'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->dispatchBrowserEvent('setValueCategorySelect', ['category_id' => '']);
    }

    public function save() {
        $this->validate();

        $data = [
            'name' => $this->name,
            'icon' => $this->icon,
            'color' => $this->color,
            'size' => $this->size,
            'category_id' => $this->category_id,
            'pasive' => false
        ];

        if ($this->modelId) {
            $data = Arr::add($data, 'modified_by', Auth::user()->id);
            $record = SubCategory::find($this->modelId);
            $record->update($data);
        } else {
            $data = Arr::add($data, 'created_by', Auth::user()->id);
            SubCategory::create($data);
        }

        $this->emitTo('maintenance.sub-categories','render');
        $this->emitTo('maintenance.sub-categories','updatingSearch');
        $this->dispatchBrowserEvent('closeModalSubCategory');
        $this->resetFields();
    }

    public function render()
    {
        $categories = Category::where('pasive', false)->get();
        return view('livewire.maintenance.subcategory-form', compact('categories'));
    }
}
