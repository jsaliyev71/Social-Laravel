<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'image'
    ];

    public function communities() {
        return $this->hasMany(Community::class, 'category_id', 'id');
    }
}
