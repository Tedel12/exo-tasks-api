<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    // désactiver l'auto-incrémation pour utiliser uuid
    public $incrementing = false;
    protected $keyType = 'string';
    // les variables fillables
    protected $fillable = ['id', 'title', 'description', 'status', 'due_date', 'created_by'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    //relation avec le model Member N:1
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }


    //relation avec le model Member N:N

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_member', 'task_id', 'user_id');
    }
}
