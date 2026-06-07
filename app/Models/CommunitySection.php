<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunitySection extends Model
{
    protected $fillable = [
        'name',
        'community_id',
        'color',
        'section_pic',
        'position',
        'description'
    ];

    public function community() {
        return $this->belongsTo(Community::class, 'community_id');
    }
}
