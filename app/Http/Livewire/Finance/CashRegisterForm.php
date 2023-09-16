<?php

namespace App\Http\Livewire\Finance;

use App\Models\CashRegister;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CashRegisterForm extends Component
{
    use LivewireAlert;

    public $opening_amount = 0,
        $opening_date,
        $opening_time = '08:00',
        $closing_amount,
        $closing_date,
        $closing_time,
        $difference,
        $cash_according_to_system,
        $cash_according_to_user,
        $transfer_according_to_system,
        $transfer_according_to_user,
        $comment,
        $system,
        $user,
        $closed,
        $action = 'new',
        $modelId;

    protected $listeners = ['getEditCashRegister', 'resetFields', 'setOpeningDate', 'setOpeningTime'];

    public function mount()
    {
        $this->opening_date = Carbon::now()->format('d/m/Y');
    }

    public function getEditCashRegister($modelId)
    {
        $this->modelId = $modelId;
        $cashRegister = CashRegister::find($this->modelId);
        $this->opening_amount = $cashRegister->opening_amount;
        $this->opening_date = Carbon::parse($cashRegister->opening_date)->format('d/m/Y');
        $this->opening_time = Carbon::parse($cashRegister->opening_time)->format('H:i');
        $this->closing_amount = $cashRegister->closing_amount;
        $this->closing_date = $cashRegister->closing_date;
        $this->closing_time = $cashRegister->closing_time;
        $this->difference = $cashRegister->difference;
        $this->cash_according_to_system = $cashRegister->cash_according_to_system;
        $this->cash_according_to_user = $cashRegister->cash_according_to_user;
        $this->transfer_according_to_system = $cashRegister->transfer_according_to_system;
        $this->transfer_according_to_user = $cashRegister->transfer_according_to_user;
        $this->comment = $cashRegister->comment;
        $this->system = $cashRegister->system;
        $this->user = $cashRegister->user;
        $this->closed = $cashRegister->closed;
    }

    public function setOpeningDate($value)
    {
        $this->opening_date = $value;
    }

    public function setOpeningTime($value)
    {
        $this->opening_time = $value;
    }

    protected function rules() {
        return [
            'opening_amount' => ['required', 'numeric', 'min:0'],
            'opening_date' => 'required',
            'opening_time' => 'required',
            'closed' => 'already_open_cash_register',
            'closing_amount' => [Rule::requiredIf($this->modelId), 'nullable'],
            'closing_date' => [Rule::requiredIf($this->modelId), 'nullable'],
            'closing_time' => [Rule::requiredIf($this->modelId), 'nullable'],
            'cash_according_to_user' => [Rule::requiredIf($this->modelId), 'nullable'],
            'transfer_according_to_user' => [Rule::requiredIf($this->modelId), 'nullable']
        ];
    }

    protected function messages() {
        return [
            'opening_amount.required' => __('validation.required', ['attribute' => __('pages.fields.opening_amount')]),
            'opening_date.required' => __('validation.required', ['attribute' => __('pages.fields.opening_date')]),
            'opening_time.required' => __('validation.required', ['attribute' => __('pages.fields.opening_time')]),
            'closing_amount.required_if' => __('validation.required', ['attribute' => __('pages.fields.closing_amount')]),
            'closing_date.required_if' => __('validation.required', ['attribute' => __('pages.fields.closing_date')]),
            'closing_time.required_if' => __('validation.required', ['attribute' => __('pages.fields.closing_time')]),
            'cash_according_to_user.required_if' => __('validation.required', ['attribute' => __('pages.fields.cash_according_to_user')]),
            'transfer_according_to_user.required_if' => __('validation.required', ['attribute' => __('pages.fields.transfer_according_to_user')]),
            'closed.already_open_cash_register' => __('pages.cash_register.there_is_already_open'),
        ];
    }

    public function resetFields()
    {
        $this->reset([
            'opening_amount',
            'opening_date',
            'opening_time',
            'closing_amount',
            'closing_date',
            'closing_time',
            'difference',
            'cash_according_to_system',
            'cash_according_to_user',
            'transfer_according_to_system',
            'transfer_according_to_user',
            'comment',
            'system',
            'user',
            'closed',
            'action',
            'modelId'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function save() {
        $this->validate();
        $data = [
            'opening_amount' => $this->opening_amount,
            'opening_date' => Carbon::createFromFormat('d/m/Y', $this->opening_date)->format('Y-m-d'),
            'opening_time' => $this->opening_time,
            'closing_amount' => $this->closing_amount,
            'closing_date' => $this->closing_date,
            'closing_time' => $this->closing_time,
            'difference' => $this->difference,
            'cash_according_to_system' => $this->cash_according_to_system,
            'cash_according_to_user' => $this->cash_according_to_user,
            'transfer_according_to_system' => $this->transfer_according_to_system,
            'transfer_according_to_user' => $this->transfer_according_to_user,
            'comment' => $this->comment,
            'system' => $this->system,
            'user' => $this->user,
            'closed' => $this->closed,
        ];

        if ($this->action == 'new' && !$this->modelId) {
            $data['created_by'] = auth()->user()->id;
            $data['pasive'] = false;
            CashRegister::create($data);
        } else {
            $data['modified_by'] = auth()->user()->id;
            CashRegister::find($this->modelId)->update($data);
        }

        $this->dispatchBrowserEvent('closeModalCashRegister');
        $this->alert('success',
            __('pages.messages_alert.'.($this->modelId ? 'update' : 'create').'.success', ['field' => __('pages.cash_register.title')]),
            [
                'timer' =>  '7000',
                'toast' =>  true,
                'timerProgressBar' =>  true,
            ]
        );
        $this->resetFields();
        $this->emitTo('finance.cash-registers','render');
        $this->emitTo('finance.cash-registers','updatingSearch');
    }

    public function render()
    {
        return view('livewire.finance.cash-register-form');
    }
}
