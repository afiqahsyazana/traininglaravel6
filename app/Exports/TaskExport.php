<?php

namespace App\Exports;

use App\Task;
use Maatwebsite\Excel\Concerns\FromCollection;

class TaskExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $tasks;

    public function __construct($tasks)
    {
        return $this->tasks = $tasks;
    }

    public function collection()
    {
        return $this->tasks;
    }
}
