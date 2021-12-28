<?php

namespace App\Rules;

use App\Models\Aula;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class AulaRule implements Rule
{
    private $hour_start;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($hour_start)
    {
        $this->hour_start = $hour_start;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $hour_end = Carbon::create($value);
        $hour_start = Carbon::create($this->hour_start);
        return $hour_end->isAfter($hour_start);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A hora de término deve ser maior que o início da aula.';
    }
}
