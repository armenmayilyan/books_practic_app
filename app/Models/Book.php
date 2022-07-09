<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];
    use HasFactory;

    protected $with = 'payments';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payment()
    {
        return $this->morphOne(Payment::class, 'paymanteable_type');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'paymantable_id');
    }
}
