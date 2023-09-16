<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use App\Traits\SearchingTrait;
use App\Traits\SortingTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;
    use SortingTrait;
    use SearchingTrait;

    public $statusFilter = 'ALL';
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['render', 'updatingSearch', 'filterByStatus'];

    public function mount()
    {
        $this->sortField = 'id';
        $this->direction = 'desc';
    }

    public function filterByStatus($status)
    {
        $this->statusFilter = $status;
    }

    public function render()
    {
        $query = Order::query();
        $query->when($this->statusFilter != 'ALL', function ($q) {
            return $q->where('status', $this->statusFilter);
        });
        $query->when($this->search, function ($q) {
            return $q->where(DB::raw('UPPER(status)'), 'like', '%'.Str::upper($this->search).'%')
                ->orWhere(DB::raw('UPPER(payment_status)'), 'like', '%'.Str::upper($this->search).'%');
        });
        $orders = $query->orderByRaw($this->sortField .' '. $this->direction)
            ->paginate($this->perPage);

        return view('livewire.order.order-history', compact('orders'));
    }
}
