<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait Blameable
{

    public static function bootBlameable()
    {
        // parent::boot();

        if (Auth::check()) {

            static::creating(function ($model) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            });

            static::updating(function ($model) {
                $model->updated_by = Auth::id();
            });

            static::deleting(function ($model) {
                if (array_key_exists('deleted_by', $model->attributes)) {
                    $model->deleted_by = Auth::id();
                    $model->save();
                }
            });
        }
    }
    //Usuário criador da model
    public  function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
