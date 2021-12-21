<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'due_date',
        'balance',
        'account_id',
        'goal',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
