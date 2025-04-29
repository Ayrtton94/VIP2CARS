<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacts extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'first_name',
        'last_name',
        'document_number',
        'email',
        'phone',
    ];

    
    public function Vehicles()
    {
        return $this->belongsTo(Vehicles::class, 'vehicle_id');
    }
}
