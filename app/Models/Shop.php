<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Shop extends Model
{
    use HasFactory, Sortable;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorite_users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    public function holidays()
    {
        return $this->hasMany(ShopHoliday::class);
    }

    protected $fillable = [
        'name',
        'description',
        'postal_code',
        'address',
        'phone',
        'open_time',
        'close_time',
        'category_id',
        'price_id',
    ];
}
