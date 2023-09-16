<?php

namespace App\Http\Livewire\Finance;

use App\Models\CashRegister;
use App\Traits\SearchingTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class CashRegisters extends Component
{
    use WithPagination;
    use SearchingTrait;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['render', 'updatingSearch'];

    public function render()
    {
        $cash_registers = CashRegister::select('cash_register.*')
            ->where(DB::raw('CONCAT(closing_date)'), 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.finance.cash-registers', compact('cash_registers'));
    }
}
