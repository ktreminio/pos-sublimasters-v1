<?php

namespace App\Http\Livewire\Maintenance;

use App\Models\Color;
use App\Traits\SearchingTrait;
use App\Traits\SortingTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Colors extends Component
{
    use WithPagination;
    use SortingTrait;
    use SearchingTrait;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['render', 'updatingSearch'];

    public function mount()
    {
        $this->sortField = 'name';
    }

    public function render()
    {
        $colors = Color::where(DB::raw('UPPER(name)'), 'like', '%'.Str::upper($this->search).'%')
            ->orderByRaw($this->sortField .' '. $this->direction)
            ->paginate($this->perPage);
        return view('livewire.maintenance.colors', compact('colors'));
    }
}
