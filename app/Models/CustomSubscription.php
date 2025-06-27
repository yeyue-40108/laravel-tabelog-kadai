<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSubscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
