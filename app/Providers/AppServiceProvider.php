<?php

namespace App\Providers;

use App\Models\CashRegister;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('color_list_cannot_be_empty', function ($attribute, $value, $parameters, $validator) {
            $subcategory_id = $validator->getData()[$parameters[1]];
            if ($subcategory_id == null) {
                return true;
            }
            $subcategory = SubCategory::find($subcategory_id);
            $array = $validator->getData()[$parameters[0]];
            return !((count($array) == count($value)) && $subcategory->color && !($subcategory->size));
        });

        Validator::extend('size_list_cannot_be_empty', function ($attribute, $value, $parameters, $validator) {
            $subcategory_id = $validator->getData()[$parameters[1]];
            if ($subcategory_id == null) {
                return true;
            }
            $subcategory = SubCategory::find($subcategory_id);
            $array = $validator->getData()[$parameters[0]];
            return !((count($array) == count($value)) && $subcategory->size);
        });

        Validator::extend('color_size_list_cannot_be_empty', function ($attribute, $value, $parameters, $validator) {
            $subcategory_id = $validator->getData()[$parameters[1]];
            if ($subcategory_id == null) {
                return true;
            }
            $subcategory = SubCategory::find($subcategory_id);
            $array = $validator->getData()[$parameters[0]];
            return !((count($array) == count($value)) && (($subcategory->color && $subcategory->size) || (!$subcategory->color && $subcategory->size)));
        });

        Validator::extend('already_open_cash_register', function ($attribute, $value, $parameters, $validator) {
            $cashRegister = CashRegister::where('is_closed', false)->where('pasive', false)->first();
            return $cashRegister == null;
        });
    }
}
