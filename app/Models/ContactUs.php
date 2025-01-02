<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = "contact_us";

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'message',
    ];

    public function getNameAttribute()
    {
        return $this->first_name .' '. $this->last_name;
    }

    public function getReceivedAtAttribute()
    {
        return $this->created_at->format('d-m-Y') ?? '';
    }
}
