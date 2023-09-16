<?php

namespace App\Http\Livewire\Order;

use App\Enums\CashTransactionType;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\CashRegister;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class OrderForm extends Component
{
    use LivewireAlert;

    public $products,
        $subTotal,
        $discount,
        $total,
        $colors,
        $color_id,
        $paymentMethod,
        $deadline,
        $payWith,
        $exchange,
        $sizes,
        $size_id,
        $available_stock,
        $description,
        $product_id,
        $product,
        $cash_register_open,
        $orderProducts;

    protected $listeners = ['updatedOrderProducts'];

    public function mount()
    {
        $query = DB::table('products as p')
            ->select('p.id', 'p.name')
            ->where('p.quantity', '>', 0)
            ->where('p.pasive', false)
            ->union(function ($query) {
                $query->select('p1.id', 'p1.name')
                    ->from('products as p1')
                    ->join('color_products as cp', 'cp.product_id', '=', 'p1.id')
                    ->where('cp.pasive', false)
                    ->where('p1.pasive', false)
                    ->where('cp.quantity', '>', 0);
            })
            ->union(function ($query) {
                $query->select('p2.id', 'p2.name')
                    ->from('products as p2')
                    ->join('sizes as s', 's.product_id', '=', 'p2.id')
                    ->join('color_sizes as cs', 'cs.size_id', '=', 's.id')
                    ->where('p2.pasive', false)
                    ->where('s.pasive', false)
                    ->where('cs.pasive', false)
                    ->where('cs.quantity', '>', 0);
            })
            ->get();

        $this->products = $query->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
            ];
        });

        $this->cash_register_open = CashRegister::where('is_closed', false)->where('pasive', false)->first();
        $this->subTotal = 0;
        $this->discount = 0;
        $this->total = 0;
        $this->payWith = 0;
        $this->exchange = 0;
        $this->colors = [];
        $this->sizes = [];
        $this->orderProducts = [];
        $this->paymentMethod = 'CASH';
        $this->deadline = Carbon::now()->format('d/m/Y');
    }

    public function rules() {
        return [
            'orderProducts' => [
                Rule::requiredIf(function () {
                    if ($this->orderProducts == [] || $this->orderProducts == null) {
                        $this->alert('warning',
                            __('pages.orders.you_must_add_products'),
                            ['timer' =>  '5000', 'toast' =>  true, 'timerProgressBar' =>  true,]
                        );
                        return true;
                    }
                    return false;
                }),
            ],
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
            'paymentMethod' => 'required|string',
            'deadline' => 'required|date_format:d/m/Y'
        ];
    }

    public function messages() {
        return [
            'paymentMethod.required' => __('validation.required', ['attribute' => __('pages.orders.payment_method')]),
            'deadline.required' => __('validation.required', ['attribute' => __('pages.fields.deadline')]),
            'deadline.date_format' => __('validation.date_format', ['attribute' => __('pages.fields.deadline'), 'format' => 'dd/mm/yyyy'])
        ];
    }

    public function resetFields() {
        $this->reset([
            'product_id',
            'subTotal',
            'discount',
            'total',
            'size_id',
            'color_id',
            'payWith',
            'deadline',
            'exchange',
            'description',
            'orderProducts'
        ]);
        $this->mount();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetAddProduct() {
        $this->reset([
            'product_id',
            'size_id',
            'color_id',
            'available_stock'
        ]);
        $this->sizes = [];
        $this->colors = [];
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedPayWith()
    {
        $this->exchange = floatval($this->payWith) - floatval($this->total);
    }

    public function updatedOrderProducts()
    {
        $this->subTotal = 0;
        $this->discount = 0;

        foreach ($this->orderProducts as $orderProduct) {
            $this->subTotal += floatval($orderProduct['total']);
        }

        $this->total = floatval($this->subTotal) - floatval($this->discount);
    }

    public function removeProduct($index)
    {
        unset($this->orderProducts[$index]);
        $this->orderProducts = array_values($this->orderProducts);
        $this->emit('updatedOrderProducts');
    }

    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required',
            'size_id' => [Rule::requiredIf($this->product->subCategory->size)],
            'color_id' => [Rule::requiredIf($this->product->subCategory->color)],
        ],
        [
            'product_id.required' => __('validation.required', ['attribute' => __('pages.fields.product')]),
            'color_id.required' => __('validation.required', ['attribute' => __('pages.fields.color')]),
            'size_id.required' => __('validation.required', ['attribute' => __('pages.fields.size')])
        ]);

        $color_product_id = null;
        $color_name = '';
        $color_hex = '';
        $color_size_id = null;
        $size_name = '';
        $stock = 0;

        if ($this->orderProducts) {
            foreach ($this->orderProducts as $key => $orderProduct) {
                if ($this->product->subCategory->size) {
                    if ($orderProduct['color_id'] == $this->color_id && $orderProduct['size_id'] == $this->size_id && $orderProduct['product_id'] == $this->product_id) {
                        $this->incrementQuantity($key);
                        return;
                    }
                } else if ($this->product->subCategory->color) {
                    if ($orderProduct['color_id'] == $this->color_id && $orderProduct['product_id'] == $this->product_id) {
                        $this->incrementQuantity($key);
                        return;
                    }
                } else if ($orderProduct['product_id'] == $this->product_id) {
                    $this->incrementQuantity($key);
                    return;
                }
            }
        }

        if ($this->product->subCategory->size) {
            $size = Size::find($this->size_id)->load('colors');
            foreach ($size->colors as $color) {
                if ($color->id == $this->color_id && $color->pivot->quantity > 0 && !$color->pivot->pasive) {
                    $color_size_id = $color->pivot->id;
                    $size_name = $size->name;
                    $color_name = $color->name;
                    $color_hex = $color->hex;
                    $stock = $color->pivot->quantity;
                    break;
                }
            }
        } else if ($this->product->subCategory->color) {
            $colors = Color::find($this->color_id)->load('products');
            foreach ($colors->products as $product) {
                if ($product->id == $this->product_id && $product->pivot->quantity > 0 && !$product->pivot->pasive) {
                    $color_product_id = $product->pivot->id;
                    $color_name = $colors->name;
                    $color_hex = $colors->hex;
                    $stock = $product->pivot->quantity;
                    break;
                }
            }
        } else {
            $stock = $this->product->quantity;
        }

        $this->orderProducts[] = [
            'product_id' => $this->product->id,
            'color_product_id' => $color_product_id,
            'color_size_id' => $color_size_id,
            'name' => $this->truncateText($this->product->name, 30),
            'price' => $this->product->price,
            'image' => $this->product->url_image_principal,
            'size_id' => $this->product->subCategory->size ? $this->size_id : null,
            'size_name' => $this->product->subCategory->size ? $size_name : null,
            'color_id' => $this->product->subCategory->color ? $this->color_id : null,
            'color_name' => $this->product->subCategory->color ? $color_name : null,
            'hex' => $this->product->subCategory->color ? $color_hex : null,
            'available_stock' => $stock,
            'new_available_stock' => $stock - 1,
            'quantity' => 1,
            'total' => $this->product->price
        ];

        $this->emit('updatedOrderProducts');
        $this->dispatchBrowserEvent('log-data', $this->orderProducts);
        $this->resetAddProduct();
    }

    public function incrementQuantity($index)
    {
        $this->orderProducts[$index]['quantity'] += 1;
        $this->orderProducts[$index]['total'] = $this->orderProducts[$index]['quantity'] * $this->orderProducts[$index]['price'];
        $this->onChangeAvailableStock($index, 1);
        $this->emit('updatedOrderProducts');
        $this->resetAddProduct();
    }

    public function onChangeProduct($productId) {
        $this->product_id = $productId;
        $this->product = Product::with('subCategory', 'sizes', 'colors')->find($this->product_id);
        $this->sizes = [];
        $this->colors = [];

        if ($this->product->subCategory->size) {
            foreach ($this->product->sizes as $sizeProduct) {
                if (!$sizeProduct->pasive) {
                    $this->sizes[] = [
                        'id' => $sizeProduct->id,
                        'name' => $sizeProduct->name
                    ];
                }
            }
        }

        if ($this->product->subCategory->color && !$this->product->subCategory->size) {
            foreach ($this->product->colors as $colorProduct) {
                if (!$colorProduct->pivot->pasive) {
                    $this->colors[] = [
                        'name' => $colorProduct->name,
                        'color_id' => $colorProduct->id
                    ];
                }
            }
        }

        if (!$this->product->subCategory->color && !$this->product->subCategory->size) {
            $this->available_stock = $this->product->quantity;
            $this->addProduct();
        }
    }

    public function onChangeSize($sizeId)
    {
        $this->size_id = $sizeId;
        $size = Size::find($this->size_id)->load('colors');
        $this->colors = [];

        if ($size->colors) {
            foreach ($size->colors as $color) {
                if (!$color->pivot->pasive && !$color->pasive && $color->pivot->quantity > 0) {
                    $this->colors[] = [
                        'color_id' => $color->id,
                        'name' => $color->name
                    ];
                }
            }
        }
    }

    public function onChangeColor($colorId) {
        $this->color_id = $colorId;
        $color = Color::find($this->color_id)->load('products', 'sizes');
        $stock = 0;

        if ($this->product->subCategory->size) {
            foreach ($color->sizes as $size) {
                if ($size->id == $this->size_id) {
                    $stock = $size->pivot->quantity;
                    break;
                }
            }
        }

        if ($this->product->subCategory->color && !$this->product->subCategory->size) {
            foreach ($color->products as $product) {
                if ($product->id == $this->product_id) {
                    $stock = $product->pivot->quantity;
                    break;
                }
            }
        }

        $this->available_stock = $stock;
        $this->addProduct();
    }

    public function truncateText($text, $length) {
        return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
    }

    public function onChangeQuantity($index, $quantity, $increment) {
        if ($quantity >= 1 && $quantity <= $this->orderProducts[$index]['available_stock']) {
            if ($increment === 0) {
                $quantity = $quantity - 1;
            } else if ($increment === 1) {
                $quantity = $quantity + 1;
            }

            $this->orderProducts[$index]['quantity'] = $quantity;
            $this->onChangeAvailableStock($index, (($increment == 0 && $quantity >= 1 ) ? -1 : (($increment == 1) ? 1 : intval($quantity))), $increment == 2);
            $this->orderProducts[$index]['total'] = intval($quantity) * floatval($this->orderProducts[$index]['price']);
            $this->emit('updatedOrderProducts');
        } else {
            $this->orderProducts[$index]['quantity'] = $this->orderProducts[$index]['available_stock'];
            $this->onChangeAvailableStock($index, $this->orderProducts[$index]['quantity'], true);
        }
    }

    public function onChangeAvailableStock($index, $increment, $blur = false) {
        if ($blur){
            $this->orderProducts[$index]['new_available_stock'] = $this->orderProducts[$index]['available_stock'];
        }
        $this->orderProducts[$index]['new_available_stock'] = $this->orderProducts[$index]['new_available_stock'] - $increment;
    }

    public function save() {
        $this->validate();

        DB::transaction(function () {
            $order = Order::create([
                'created_by' => auth()->user()->id,
                'total' => $this->total,
                'discount' => $this->discount,
                'payment_method' => $this->paymentMethod,
                'description' => $this->description,
                'deadline' =>  Carbon::createFromFormat('d/m/Y', $this->deadline)->format('Y-m-d'),
                'status' => OrderStatus::NEW_ORDER,
                'payment_status' => PaymentStatus::PENDING,
                'pasive' => false
            ]);

            $dataCashRegister = [
                'modified_by' => auth()->user()->id
            ];
            if ($this->paymentMethod == 'CASH') {
                $dataCashRegister['cash_according_to_system'] = $this->cash_register_open->cash_according_to_system + $this->total;
            } else {
                $dataCashRegister['transfer_according_to_system'] = $this->cash_register_open->transfer_according_to_system + $this->total;
            }
            $this->cash_register_open->update($dataCashRegister);
            $this->cash_register_open->cashTransactions()->create([
                'amount' => $this->total,
                'date' => Carbon::now()->format('Y-m-d'),
                'comment' => __('pages.comment.sale_products'),
                'type_transaction' => CashTransactionType::SALE,
                'id_income' => $order->id,
            ]);

            foreach ($this->orderProducts as $orderProduct) {
                $order->products()->attach($orderProduct['product_id'], [
                    'quantity' => $orderProduct['quantity'],
                    'price' => $orderProduct['price'],
                    'id_color_product' => $orderProduct['color_product_id'] ?: null,
                    'id_color_size' => $orderProduct['color_size_id'] ?: null,
                ]);

                if ($orderProduct['size_id']) {
                    $productSize = Size::find($orderProduct['size_id']);
                    $productSize->colors()->updateExistingPivot($orderProduct['color_id'], [
                        'quantity' => $orderProduct['available_stock'] - $orderProduct['quantity'],
                        'modified_by' => auth()->user()->id
                    ]);
                } elseif ($orderProduct['color_id']) {
                    $colorProduct = Color::find($orderProduct['color_id']);
                    $colorProduct->products()->updateExistingPivot($orderProduct['product_id'], [
                        'quantity' => $orderProduct['available_stock'] - $orderProduct['quantity'],
                        'modified_by' => auth()->user()->id
                    ]);
                } else {
                    $product = Product::find($orderProduct['product_id']);
                    $product->update([
                        'quantity' => $product->quantity - $orderProduct['quantity'],
                        'modified_by' => auth()->user()->id
                    ]);
                }
            }
        });

        $this->alert('success',
            __('pages.messages_alert.create.success', ['field' => __('pages.fields.order')]),
            [
                'timer' =>  '7000',
                'toast' =>  true,
                'timerProgressBar' =>  true,
            ]
        );

        $this->resetFields();
        $this->emitTo('order.orders', 'render');
    }

    public function render()
    {
        return view('livewire.order.order-form');
    }
}
