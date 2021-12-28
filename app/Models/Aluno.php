<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno extends Model
{
    use HasFactory, SoftDeletes, Blameable;

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function aulas()
    {
        return $this->belongsToMany(Aula::class, 'alunos_aulas')->withPivot('checkin');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
