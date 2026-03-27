<?php

namespace App\Http\Requests\Task;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function rules()
    {
        return [
                'name' => 'required|string|max:255',
                'started_at' => 'required|date',
                'finished_at' => 'required|date|after_or_equal:started_at',


                'name.required' => "Campo nome é obrigatório!",

                'started_at.required' => "Campo data/hora de início é obrigatório!",
                'started_at.date' => "Informe uma data/hora válida para o início!",

                'finished_at.required' => "Campo data/hora de término é obrigatório!",
                'finished_at.date' => "Informe uma data/hora válida para o término!",
                'finished_at.after_or_equal' => "A data de término deve ser igual ou posterior à data de início!",
            ];
    }
}
