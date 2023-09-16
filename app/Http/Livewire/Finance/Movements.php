<?php

namespace App\Http\Livewire\Finance;

use App\Models\CashTransaction;
use App\Traits\SearchingTrait;
use Livewire\Component;
use Livewire\WithPagination;

class Movements extends Component
{
    use WithPagination;
    use SearchingTrait;

    public $balance = 0;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['render', 'updatingSearch'];

    public function render()
    {
        $movements = CashTransaction::where('comment', 'LIKE', '%' . $this->search . '%')
            ->orWhere('amount', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $expenses = CashTransaction::where('type_transaction', 'EXPENSE')->orWhere('type_transaction', 'PURCHASE')->sum('amount');
        $incomes = CashTransaction::where('type_transaction', 'INCOME')->orWhere('type_transaction', 'SALE')->sum('amount');

        $this->balance = $incomes - $expenses;

        return view('livewire.finance.movements', compact('movements'));
    }
}
