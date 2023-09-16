<?php

namespace App\Http\Livewire\Finance;

use App\Models\CashRegister;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MovementForm extends Component
{
    use LivewireAlert;

    public $action = 'new',
        $cash_register_open,
        $modelId,
        $comment,
        $amount,
        $date,
        $type;

    protected $listeners = ['getEditMovement', 'resetFields', 'setDate', 'setType'];

    public function hydrate() {
        $this->dispatchBrowserEvent('reset-selects');
    }

    public function mount()
    {
        $this->date = Carbon::now()->format('d/m/Y');
        $this->cash_register_open = CashRegister::where('is_closed', false)->where('pasive', false)->first();
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function rules()
    {
        return [
            'comment' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required',
            'type' => 'required',
            'cash_register_open' => [
                Rule::requiredIf(function () {
                    if ($this->cash_register_open == null) {
                        $this->alert('warning',
                            __('pages.orders.you_must_open_cash_register'),
                            ['timer' =>  '5000', 'toast' =>  true, 'timerProgressBar' =>  true,]
                        );
                        return true;
                    }
                    return false;
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => __('validation.required', ['attribute' => __('pages.fields.comment')]),
            'amount.required' => __('validation.required', ['attribute' => __('pages.fields.amount')]),
            'amount.numeric' => __('validation.numeric', ['attribute' => __('pages.fields.amount')]),
            'date.required' => __('validation.required', ['attribute' => __('pages.fields.date')]),
            'type.required' => __('validation.required', ['attribute' => __('pages.fields.type_transaction')]),
        ];
    }

    public function resetFields()
    {
        $this->reset(['comment', 'amount', 'date', 'type']);
        $this->mount();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'comment' => $this->comment,
            'amount' => $this->amount,
            'date' => Carbon::createFromFormat('d/m/Y', $this->date)->format('Y-m-d'),
            'type' => $this->type,
            'cash_register_id' => $this->cash_register_open->id,
        ];

        $this->cash_register_open->cashTransactions()->create($data);

        if ($this->type == 'EXPENSE') {
            $dataCashRegister['cash_according_to_system'] = $this->cash_register_open->cash_according_to_system + $this->total;
        } else {
            $dataCashRegister['transfer_according_to_system'] = $this->cash_register_open->transfer_according_to_system + $this->total;
        }
        $this->cash_register_open->update($dataCashRegister);

        $this->alert('success',
            __('pages.messages_alert.create.success', ['field' => __('pages.cash_movements.title')]),
            [
                'timer' =>  '7000',
                'toast' =>  true,
                'timerProgressBar' =>  true,
            ]
        );
        $this->resetFields();
        $this->emitTo('finance.movements', 'render');
    }

    public function render()
    {
        return view('livewire.finance.movement-form');
    }
}
