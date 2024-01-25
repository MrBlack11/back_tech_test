<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'renavam',
        'plate',
        'color'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_cars');
    }
}
