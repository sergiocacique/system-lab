<?php

namespace App\Http\Requests;

use App\Rules\AulaRule;
use Illuminate\Foundation\Http\FormRequest;

class AulaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'day' => ['required', 'date'],
            'hour_start' => 'required',
            'hour_end' => ['required', new AulaRule($this->hour_start)],
            'name' => 'required|string',
            'teacher' => 'required|string',
            'seat_limit' => 'required|numeric|min:5',
        ];

        if ($this->isMethod('put')) {
            $rules['day'] = ['required', 'date'];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'day' => 'Dia',
            'hour_start' => 'Hora de início',
            'hour_end' => 'Hora de término',
            'name' => 'Nome',
            'teacher' => 'Professor',
            'seat_limit' => 'Quantidade de vagas'
        ];
    }
}
