<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Reservation extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'shop_id', 'user_id', 'reservation_date', 'reservation_time', 'people',
    ];
    
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
