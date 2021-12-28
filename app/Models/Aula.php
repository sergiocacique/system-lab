<?php

namespace App\Models;

use App\Traits\Blameable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use stdClass;

class Aula extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'day',
        'hour_start',
        'hour_end',
        'name',
        'teacher',
        'seat_limit',
    ];

    protected $dates = [
        'day',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $times = ['hour_start', 'hour_end'];


    protected $appends = ['checkin_count', 'students_checkin', 'checkable', 'checkin_pivot'];

    public function getCheckinCountAttribute()
    {
        return $this->alunos()->where('checkin', true)->count();
    }

    public function getCheckinPivotAttribute()
    {
        $isAluno = Auth::user()->roles->contains('name', 'aluno');
        if ($isAluno) {
            $pivot = $this->alunos()->firstWhere('aluno_id', Auth::user()->aluno->id);
            return $pivot ? $pivot->pivot->checkin : $pivot;
        }
        return false;
    }

    public function getStudentsCheckinAttribute()
    {
        return $this->alunos;
    }

    public function getCheckableAttribute()
    {
        $hour = Carbon::create("$this->day $this->hour_start");
        $minute = Carbon::create("$this->day $this->hour_start");

        $conditional =
            now()->isBefore($hour->subHours(24)) ||
            $minute->subMinutes(30)->isBefore(now());

        return $conditional;
    }

    public function getDayAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'alunos_aulas')->withPivot('checkin');
    }
}
