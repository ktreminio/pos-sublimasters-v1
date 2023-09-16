<?php

namespace App\Http\Livewire\Maintenance;

use App\Models\SubCategory;
use App\Traits\SearchingTrait;
use App\Traits\SortingTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SubCategories extends Component
{
    use WithPagination;
    use SortingTrait;
    use SearchingTrait;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['render', 'updatingSearch'];

    public function mount()
    {
        $this->sortField = 'sub_categories.name';
    }

    public function render()
    {
        $subcategories = SubCategory::join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->select('sub_categories.*', 'categories.name as category_name')
            ->where(DB::raw('UPPER(sub_categories.name)'), 'like', '%'.Str::upper($this->search).'%')
            ->orWhere(DB::raw('UPPER(categories.name)'), 'like', '%'.Str::upper($this->search).'%')
            ->orderByRaw($this->sortField .' '. $this->direction)
            ->paginate($this->perPage);
        return view('livewire.maintenance.sub-categories', compact('subcategories'));
    }
}
