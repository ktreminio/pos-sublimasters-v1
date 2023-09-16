<?php

namespace App\Http\Livewire\Maintenance;

use App\Models\Product;
use App\Traits\SearchingTrait;
use App\Traits\SortingTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    use SortingTrait;
    use SearchingTrait;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['render', 'updatingSearch'];

    public function mount()
    {
        $this->sortField = 'products.name';
    }

    public function render()
    {
        $products = Product::join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->select('products.*', 'sub_categories.name as sub_category_name', 'categories.name as category_name')
            ->where(DB::raw('UPPER(products.name)'), 'like', '%'.Str::upper($this->search).'%')
            ->orWhere(DB::raw('UPPER(sub_categories.name)'), 'like', '%'.Str::upper($this->search).'%')
            ->orWhere(DB::raw('UPPER(categories.name)'), 'like', '%'.Str::upper($this->search).'%')
            ->orderByRaw($this->sortField .' '. $this->direction)
            ->paginate($this->perPage);
        return view('livewire.maintenance.products', compact('products'));
    }
}
