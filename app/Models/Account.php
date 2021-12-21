<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function partitions()
    {
        return $this->hasMany(Partition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
