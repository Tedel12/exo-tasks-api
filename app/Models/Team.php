<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Team extends Model
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    // désactiver l'auto-incrémation pour utiliser uuid
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'name', 'slug'];

    // genrer un uuid automatiquement à la creation 
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
            $model->slug = Str::slug($model->name);
        });
    }

    // relation avec le model Member: 1:N
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }
}
