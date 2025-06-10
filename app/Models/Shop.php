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
}
