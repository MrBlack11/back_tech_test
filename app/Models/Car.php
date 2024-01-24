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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'car_users');
    }
}
