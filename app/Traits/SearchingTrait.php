<?php
namespace App\Traits;

trait SearchingTrait
{
    public $search,
        $perPage = 5;

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
