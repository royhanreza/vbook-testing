<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasMany(User::class, 'division_id');
    }

    public function guest()
    {
        return $this->hasMany(Guest::class, 'division_id');
    }
}
