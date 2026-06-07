<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Community extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'owner_user_id',
        'name',
        'slug',
        'category_id',
        'description',
        'profile_pic',
        'banner_img',
        'visibility',
        'posting_mode',
        'commenting_mode',
        'requires_join_approval'
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sections() {
        return $this->hasMany(CommunitySection::class, 'community_id', 'id');
    }

    public function members() {
        return $this->hasMany(CommunityMember::class, 'community_id', 'id');
    }

    public function myMembership() {
        return $this->hasOne(CommunityMember::class)
            ->where('user_id', auth()->id());
    }
}
