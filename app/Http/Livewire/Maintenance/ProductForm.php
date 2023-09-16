<?php

namespace App\Http\Livewire\Maintenance;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    // Product properties
    public $name,
        $description,
        $categories = [],
        $subcategories = [],
        $category_id = '',
        $subcategory_id = '',
        $image,
        $image_actual,
        $pasive_image_actual = false,
        $quantity,
        $status,
        $stock_min,
        $price,
        $action = 'new',
        $open = true,
        $modelId;

    //Color product properties
    public $color_id = '',
        $quantity_color,
        $stock_min_color,
        $index_color_edit,
        $color_id_edit = '',
        $quantity_color_edit,
        $stock_min_color_edit,
        $color_products = [],
        $colors = [],
        $colors_deletes = [];

    //Size product properties
    public $color_size_id = '',
        $stock_min_color_size,
        $stock_min_color_size_edit,
        $quantity_color_size_edit,
        $color_size_id_edit = '',
        $index_color_size_edit,
        $name_size_edit,
        $name_size,
        $sizes = [],
        $sizes_deletes = [],
        $quantity_color_size,
        $color_size_products = [],
        $colors_size_deletes = [];

    protected $listeners = ['updatedColorProducts', 'updatedSizes'];

    public function mount($id = null) {
        $this->categories = Category::where('pasive', false)->get();

        if ($id) { $this->editProduct($id);}
    }

    public function hydrate() {
        $this->dispatchBrowserEvent('render-select2');
    }

    public function updatedCategoryId($value) {
        $this->subcategories = Category::find($value)->subCategories;
        $this->reset('subcategory_id');
    }

    public function updatedColorProducts() {
        if ($this->color_products) {
            $this->colors_deletes = array_filter($this->color_products, function($color_product) {
                return $color_product['pasive'] == true;
            });
        }
    }

    public function updatedSizes() {
        if ($this->sizes) {
            $this->sizes_deletes = array_filter($this->sizes, function($size) {
                return $size['pasive'] == true;
            });

            $this->colors_size_deletes = [];

            if ($this->index_color_size_edit !== null && array_key_exists($this->index_color_size_edit, $this->sizes)) {
                $selectedSize = $this->sizes[$this->index_color_size_edit];
                $this->colors_size_deletes = array_filter($selectedSize['colors'], function($color) {
                    return $color['pasive'] == true;
                });
            }
        }

        $this->dispatchBrowserEvent('log', $this->colors_size_deletes);
    }

    public function updatedSubcategoryId() {
        if ($this->subcategory) {
            if ($this->subcategory->color || $this->subcategory->size) {
                $this->colors = Color::where('pasive', false)->get();
            }
        }
        $this->reset([
            'color_id',
            'quantity_color',
            'stock_min_color',
            'color_products',
            'sizes',
            'name_size',
            'color_size_products',
            'colors_size_deletes',
            'sizes_deletes',
            'colors_deletes'
        ]);
    }

    public function deleteImage() {
        $this->pasive_image_actual = true;
        $this->image = null;
    }

    public function editProduct($modelId) {
        $this->modelId = $modelId;
        $product = Product::find($this->modelId);
        $this->name = $product->name;
        $this->description = $product->description;
        $this->category_id = $product->subCategory->category_id;
        $this->image_actual = $product->url_image_principal;
        $this->subcategory_id = $product->sub_category_id;
        $this->quantity = $product->quantity;
        $this->status = $product->status;
        $this->stock_min = $product->stock_min;
        $this->price = $product->price;
        $this->open = false;
        $this->action = 'edit';

        $this->subcategories = Category::find($this->category_id)->subCategories;

        if ($product->subCategory->color || $product->subCategory->size) {
            $this->colors = Color::where('pasive', false)->get();
        }

        if ($product->subCategory->color && !$product->subCategory->size) {
            foreach ($product->colors as $colorProduct) {
                if (!$colorProduct->pivot->pasive) {
                    $this->color_products[] = [
                        'id' => $colorProduct->pivot->id,
                        'name' => $colorProduct->name,
                        'color_id' => $colorProduct->id,
                        'quantity' => $colorProduct->pivot->quantity,
                        'stock_min' => $colorProduct->pivot->stock_min,
                        'pasive' => $colorProduct->pivot->pasive
                    ];
                }
            }
        }

        if ($product->subCategory->size) {
            foreach ($product->sizes as $size) {
                if (!$size->pasive) {
                    $this->sizes[] = [
                        'id' => $size->id,
                        'name' => $size->name,
                        'pasive' => $size->pasive,
                        'colors' => []
                    ];

                    foreach ($size->colors as $color) {
                        if (!$color->pivot->pasive) {
                            $this->sizes[count($this->sizes) - 1]['colors'][] = [
                                'id' => $color->pivot->id,
                                'name' => $color->name,
                                'color_id' => $color->id,
                                'quantity' => $color->pivot->quantity,
                                'stock_min' => $color->pivot->stock_min,
                                'pasive' => $color->pivot->pasive
                            ];
                        }
                    }
                }
            }
        }
    }

    protected function rules() {
        return [
            'name' => ['required', Rule::unique('products')->where( function ($query) {
                $query->where('pasive', false);
            })->ignore($this->modelId)],
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'image' => ['nullable','image', 'max:5000', 'mimes:jpeg,jpg,png',
                Rule::requiredIf($this->modelId == null || $this->pasive_image_actual)
            ],
            'quantity' => ['nullable', 'integer',
                Rule::requiredIf($this->subcategory_id && !$this->subcategory->color && !$this->subcategory->size)
            ],
            'price' => 'required|numeric',
            'stock_min' => ['nullable', 'integer',
                Rule::requiredIf($this->subcategory_id && !$this->subcategory->color && !$this->subcategory->size)
            ],
            'color_products' => [
                Rule::requiredIf($this->subcategory_id && $this->subcategory->color && !$this->subcategory->size),
                'color_list_cannot_be_empty:colors_deletes,subcategory_id'
            ],
            'sizes' => [
                Rule::requiredIf($this->subcategory_id && ($this->quantity == null) && $this->subcategory->size),
                'size_list_cannot_be_empty:sizes_deletes,subcategory_id'
            ],
            'sizes.*.colors' => [
                Rule::requiredIf($this->subcategory_id && ($this->quantity == null) && $this->subcategory->size),
                'color_size_list_cannot_be_empty:colors_size_deletes,subcategory_id'
            ]
        ];
    }

    protected function messages() {
        return [
            'name.required' => __('validation.required', ['attribute' => __('pages.fields.name')]),
            'name.unique' => __('validation.unique', ['attribute' => __('pages.fields.name')]),
            'category_id.required' => __('validation.required', ['attribute' => __('pages.fields.category')]),
            'subcategory_id.required' => __('validation.required', ['attribute' => __('pages.fields.subcategory')]),
            'quantity.integer' => __('validation.integer', ['attribute' => __('pages.fields.quantity')]),
            'quantity.required' => __('validation.required', ['attribute' => __('pages.fields.quantity')]),
            'price.required' => __('validation.required', ['attribute' => __('pages.fields.price')]),
            'price.numeric' => __('validation.numeric', ['attribute' => __('pages.fields.price')]),
            'stock_min.required' => __('validation.required', ['attribute' => __('pages.fields.stock_min')]),
            'image.image' => __('validation.image', ['attribute' => __('pages.fields.image')]),
            'image.max' => __('validation.max.file', ['attribute' => __('pages.fields.image'), 'max' => '5MB']),
            'image.mimes' => __('validation.mimes', ['attribute' => __('pages.fields.image'), 'values' => 'jpeg, jpg, png']),
            'image.required' => __('validation.required', ['attribute' => __('pages.fields.image')]),
            'color_products.required' => __('pages.colors.must_color'),
            'color_products.color_list_cannot_be_empty' => __('pages.colors.must_color'),
            'color_id.required' => __('validation.required', ['attribute' => __('pages.fields.color')]),
            'quantity_color.required' => __('validation.required', ['attribute' => __('pages.fields.quantity')]),
            'stock_min_color.required' => __('validation.required', ['attribute' => __('pages.fields.stock_min')]),
            'sizes.required' => __('pages.sizes.must_size'),
            'sizes.size_list_cannot_be_empty' => __('pages.sizes.must_size'),
            'name_size.required' => __('validation.required', ['attribute' => __('pages.fields.name')]),
            'quantity_color_size.required' => __('validation.required', ['attribute' => __('pages.fields.quantity')]),
            'color_size_id.required' => __('validation.required', ['attribute' => __('pages.fields.color')]),
            'sizes.*.colors.required' => __('pages.sizes.must_color_to_size'),
            'sizes.*.colors.color_size_list_cannot_be_empty' => __('pages.sizes.must_color_to_size'),
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function getSubcategoryProperty() {
        return SubCategory::find($this->subcategory_id ?: 0);
    }

    public function resetFields() {
        $this->reset([
            'name',
            'description',
            'category_id',
            'subcategory_id',
            'quantity',
            'status',
            'image',
            'image_actual',
            'stock_min',
            'price',
            'action',
            'modelId',
            'color_products',
            'sizes',
            'sizes_deletes',
            'colors_deletes',
            'colors_size_deletes'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->redirect(route('products'));
    }

    public function cancelSave() {
        $this->dispatchBrowserEvent('openModalConfirmCancel');
    }

    public function resetColorFields() {
        $this->reset([
            'color_id',
            'quantity_color'
        ]);
        $this->resetErrorBag([
            'color_id',
            'quantity_color'
        ]);
        $this->resetValidation([
            'color_id',
            'quantity_color'
        ]);
    }

    public function editColor($index, $indexSize = null) {
        if ($indexSize !== null) {
            $color = $this->sizes[$indexSize]['colors'][$index];
            $this->index_color_size_edit = $indexSize;
        } else {
            $color = $this->color_products[$index];
        }

        $this->stock_min_color_edit = $color['stock_min'];
        $this->quantity_color_edit = $color['quantity'];
        $this->color_id_edit = $color['color_id'];
        $this->index_color_edit = $index;
        $this->dispatchBrowserEvent('openModalEditColor');
    }

    public function saveColor() {
        $this->validate([
            'color_id_edit' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->color && !$this->subcategory->size)],
            'quantity_color_edit' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->color && !$this->subcategory->size), 'integer'],
            'stock_min_color_edit' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->color && !$this->subcategory->size), 'integer'],
        ],
        [
            'color_id_edit.required' => __('validation.required', ['attribute' => __('pages.fields.color')]),
            'quantity_color_edit.required' => __('validation.required', ['attribute' => __('pages.fields.quantity')]),
            'quantity_color_edit.integer' => __('validation.integer', ['attribute' => __('pages.fields.quantity')]),
            'stock_min_color_edit.required' => __('validation.required', ['attribute' => __('pages.fields.stock_min')]),
            'stock_min_color_edit.integer' => __('validation.integer', ['attribute' => __('pages.fields.stock_min')]),
        ]);

        if($this->index_color_size_edit !== null) {
            $color_product = $this->sizes[$this->index_color_size_edit]['colors'][$this->index_color_edit];
        } else {
            $color_product = $this->color_products[$this->index_color_edit];
        }

        $color_product['color_id'] = $this->color_id_edit;
        $color_product['quantity'] = $this->quantity_color_edit;
        $color_product['stock_min'] = $this->stock_min_color_edit;

        if($this->index_color_size_edit !== null) {
            $this->sizes[$this->index_color_size_edit]['colors'][$this->index_color_edit] = $color_product;
        } else {
            $this->color_products[$this->index_color_edit] = $color_product;
        }

        $this->resetColorEditFields();
        $this->dispatchBrowserEvent('closeModalEditColor');
    }

    public function resetColorEditFields() {
        $this->reset(['color_id_edit', 'quantity_color_edit', 'stock_min_color_edit', 'index_color_edit', 'index_color_size_edit']);
        $this->resetErrorBag(['color_id_edit', 'quantity_color_edit', 'stock_min_color_edit']);
        $this->resetValidation(['color_id_edit', 'quantity_color_edit', 'stock_min_color_edit']);
    }

    public function addColor() {
        $this->validate([
            'color_id' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->color && !$this->subcategory->size)],
            'quantity_color' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->color && !$this->subcategory->size)],
            'stock_min_color' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->color && !$this->subcategory->size && !($this->quantity_color > 0 && $this->color_id))],
        ]);

        $color = Color::find($this->color_id);

        if ($this->color_products) {
            foreach ($this->color_products as $indexColor => $color_product) {
                if ($color_product['color_id'] == $this->color_id) {
                    if ($this->stock_min_color > 0) {
                        $newStockMin =  $color_product['stock_min'] + $this->stock_min_color;
                        $this->color_products[$indexColor]['stock_min'] = $newStockMin;
                    }

                    $newQuantity =  $color_product['quantity'] + $this->quantity_color;
                    $this->color_products[$indexColor]['quantity'] = $newQuantity;
                    $this->resetColorFields();
                    return;
                }
            }
        }

        $this->color_products[] = [
            'id' => '',
            'color_id' => $this->color_id,
            'quantity' => $this->quantity_color,

            'stock_min' => $this->stock_min_color,
            'name' => $color->name,
            'pasive' => false,
        ];

        $this->resetColorFields();
    }

    public function removeColor($index) {
        if ($this->color_products[$index]['id'] != '') {
            $this->color_products[$index]['pasive'] = true;
        } else {
            unset($this->color_products[$index]);
            $this->color_products = array_values($this->color_products);
        }

        $this->emit('updatedColorProducts');
    }

    public function editSize($index) {
        foreach ($this->sizes as $indexSize => $size) {
            if ($indexSize == $index) {
                $this->name_size_edit = $size['name'];
                $this->index_color_size_edit = $index;
                $this->dispatchBrowserEvent('openModalEditSize');
                break;
            }
        }
    }

    public function resetSizeEditFields() {
        $this->reset(['name_size_edit', 'index_color_size_edit']);
        $this->resetErrorBag(['name_size_edit']);
        $this->resetValidation(['name_size_edit']);
    }

    public function saveSize() {
        $this->validate([
            'name_size_edit' => [
                Rule::requiredIf($this->subcategory_id && $this->subcategory->size),
                Rule::unique('sizes', 'name')->where( function ($query) {
                    $query->where('pasive', false);
                })->ignore($this->sizes[$this->index_color_size_edit]['id'])
            ]
        ],
        [
            'name_size_edit.required' => __('validation.required', ['attribute' => __('pages.fields.size')]),
            'name_size_edit.unique' => __('validation.unique', ['attribute' => __('pages.fields.size')]),
        ]);

        foreach ($this->sizes as $indexSize => $size) {
            if ($indexSize == $this->index_color_size_edit) {
                $size['name'] = $this->name_size_edit;
                $this->sizes[$indexSize] = $size;
                $this->resetSizeEditFields();
                $this->dispatchBrowserEvent('closeModalEditSize');
                break;
            }
        }
    }

    public function addSize() {
        $this->validate([
            'name_size' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->size)],
        ]);

        if ($this->sizes) {
            foreach ($this->sizes as $size) {
                if ($size['name'] == $this->name_size) {
                    $this->alert('info', __('pages.sizes.already_added'),
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

        $this->sizes[] = [
            'id' => '',
            'name' => $this->name_size,
            'pasive' => false,
            'colors' => []
        ];

        $this->reset('name_size');
    }

    public function removeSize($index) {
        if ($this->sizes[$index]['id'] != '') {
            $this->sizes[$index]['pasive'] = true;
        } else {
            unset($this->sizes[$index]);
            $this->sizes = array_values($this->sizes);
        }
        $this->emit('updatedSizes');
    }

    public function addColorToSize($indexSize) {
        $this->validate([
            'color_size_products.'.$indexSize.'.color_size_id' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->size)],
            'color_size_products.'.$indexSize.'.quantity_color_size' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->size)],
            'color_size_products.'.$indexSize.'.stock_min_color_size' => [Rule::requiredIf($this->subcategory_id && $this->subcategory->size)],
        ],
        [
            'color_size_products.'.$indexSize.'.color_size_id.required' => __('validation.required', ['attribute' => __('pages.fields.color')]),
            'color_size_products.'.$indexSize.'.quantity_color_size.required' => __('validation.required', ['attribute' => __('pages.fields.quantity')]),
            'color_size_products.'.$indexSize.'.stock_min_color_size.required' => __('validation.required', ['attribute' => __('pages.fields.stock_min')]),
        ]);

        $color = Color::find($this->color_size_products[$indexSize]['color_size_id']);

        if ($this->sizes[$indexSize]['colors']) {
            foreach ($this->sizes[$indexSize]['colors'] as $color_index => $color_size) {
                if ($color_size['color_id'] == $this->color_size_products[$indexSize]['color_size_id']) {
                    if ($this->color_size_products[$indexSize]['stock_min_color_size'] > 0) {
                        $newStockMin =  $color_size['stock_min'] + $this->color_size_products[$indexSize]['stock_min_color_size'];
                        $this->sizes[$indexSize]['colors'][$color_index]['stock_min'] = $newStockMin;
                    }

                    $newQuantity =  $color_size['quantity'] + $this->color_size_products[$indexSize]['quantity_color_size'];
                    $this->sizes[$indexSize]['colors'][$color_index]['quantity'] = $newQuantity;
                    $this->resetColorToSizeFields();
                    return;
                }
            }
        }

        $this->sizes[$indexSize]['colors'][] = [
            'id' => '',
            'color_id' => $color->id,
            'name' => $color->name,
            'quantity' => $this->color_size_products[$indexSize]['quantity_color_size'],
            'stock_min' => $this->color_size_products[$indexSize]['stock_min_color_size'],
            'pasive' => false,
        ];

        $this->resetColorToSizeFields();
    }

    public function resetColorToSizeFields() {
        $this->reset('color_size_products');
        $this->resetErrorBag('color_size_products');
        $this->resetValidation('color_size_products');
    }

    public function removeColorToSize($indexSize, $indexColor) {
        if ($this->sizes[$indexSize]['id'] != '' && $this->sizes[$indexSize]['colors'][$indexColor]['id'] != '') {
            $this->sizes[$indexSize]['colors'][$indexColor]['pasive'] = true;
            $this->index_color_size_edit = $indexSize;
            $this->index_color_edit = $indexColor;
        } else {
            unset($this->sizes[$indexSize]['colors'][$indexColor]);
            $this->sizes[$indexSize]['colors'] = array_values($this->sizes[$indexSize]['colors']);
        }

        $this->emit('updatedSizes');
    }

    public function save() {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'sub_category_id' => $this->subcategory_id,
            'stock_min' => $this->stock_min,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'pasive' => false
        ];

        if ($this->modelId) {
            if ($this->image) {
                $url_image = $this->image->store('products', 'public');
                Storage::disk('public')->delete($this->image_actual);
            } else {
                $url_image = $this->image_actual;
            }
            $data['url_image_principal'] = $url_image;
            $data['modified_by'] = auth()->user()->id;

            $product = Product::find($this->modelId);
            $product->update($data);

            if (count($this->sizes) > 0) {
                foreach ($this->sizes as $size) {
                    if ($size['id']) {
                        $size_product = Size::find($size['id']);
                        $size_product->update([
                            'name' => $size['name'],
                            'pasive' => $size['pasive'],
                            'modified_by' => auth()->user()->id
                        ]);
                    } else {
                        $size_product = $product->sizes()->create([
                            'name' => $size['name'],
                            'pasive' => false,
                            'created_by' => auth()->user()->id
                        ]);
                    }

                    foreach ($size['colors'] as $color) {
                        if ($color['id']) {
                            $size_product->colors()->updateExistingPivot($color['color_id'], [
                                'quantity' => $color['quantity'],
                                'stock_min' => $color['stock_min'],
                                'pasive' => $size['pasive'] ?: $color['pasive'],
                                'modified_by' => auth()->user()->id
                            ]);
                        } else {
                            $size_product->colors()->attach($color['color_id'], [
                                'quantity' => $color['quantity'],
                                'stock_min' => $color['stock_min'],
                                'pasive' => false,
                                'created_by' => auth()->user()->id
                            ]);
                        }
                    }
                }
            } else if (count($this->color_products) > 0){
                foreach ($this->color_products as $color_product) {
                    if ($color_product['id']) {
                        $product->colors()->updateExistingPivot($color_product['color_id'], [
                            'quantity' => $color_product['quantity'],
                            'stock_min' => $color_product['stock_min'],
                            'pasive' => $color_product['pasive'],
                            'modified_by' => auth()->user()->id
                        ]);
                    } else {
                        $product->colors()->attach($color_product['color_id'], [
                            'quantity' => $color_product['quantity'],
                            'stock_min' => $color_product['stock_min'],
                            'pasive' => false,
                            'created_by' => auth()->user()->id
                        ]);
                    }
                }
            }
        } else {
            $data['created_by'] = auth()->user()->id;
            $data['url_image_principal'] = $this->image->store('products', 'public');
            $product = Product::create($data);

            if (count($this->color_products) > 0) {
                foreach ($this->color_products as $color_product) {
                    $product->colors()->attach($color_product['color_id'], [
                        'quantity' => $color_product['quantity'],
                        'stock_min' => $color_product['stock_min'],
                        'pasive' => false,
                        'created_by' => auth()->user()->id
                    ]);
                }
            } else if (count($this->sizes) > 0) {
                foreach ($this->sizes as $size) {
                    $size_product = $product->sizes()->create([
                        'name' => $size['name'],
                        'pasive' => false,
                        'created_by' => auth()->user()->id
                    ]);

                    foreach ($size['colors'] as $color_size) {
                        $size_product->colors()->attach($color_size['color_id'], [
                            'quantity' => $color_size['quantity'],
                            'stock_min' => $color_size['stock_min'],
                            'pasive' => false,
                            'created_by' => auth()->user()->id
                        ]);
                    }
                }
            }
        }

        $this->dispatchBrowserEvent('closeModalConfirmCancel');
        $this->resetFields();
    }

    public function render()
    {
        return view('livewire.maintenance.product-form');
    }
}
