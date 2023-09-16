<?php
namespace App\Traits;

trait SortingTrait
{
    public $sortField = '';
    public $direction = 'asc';

    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->direction = $this->direction == 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->direction = 'asc';
        }
    }
}
