<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
protected $guarded = [];
use HasFactory;

public function paymentable()
{
return $this->morphTo();
}
public function book()
{
    return $this->belongsTo(Book::class);
}
}
