<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function Models()
    {
        return $this->hasMany(Models::class);
    }
}
