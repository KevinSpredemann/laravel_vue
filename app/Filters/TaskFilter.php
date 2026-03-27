<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TaskFilter
{
    public function __construct(protected Request $request){}
    public function apply($query){
        return $query->when($this->request->filled('name'),
        fn($query) => $query->whereLike('name', '%' . $this->request->name . '%')
        )
        ->when($this->request->filled('started_at'),
        fn($query) => $query->where('started_at', '>=', Carbon::parse($this->request->started_at))
        )
        ->when($this->request->filled('finished_at'),
        fn($query) => $query->where('finished_at', '<=', Carbon::parse($this->request->finished_at))
        );
    }
}
