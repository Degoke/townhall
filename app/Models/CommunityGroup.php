<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityGroup extends Model
{
    use HasFactory;

    protected $gaurded = [
        'is_default'
    ];

    protected $fillable = [
        'name'
    ];

    protected $with = [
        'posts'
    ];

    public function community(): BelongsT0 {
        return $this->belongsTo(Community::class);
    }

    public function communityMemberships(): BelongsToMany {
        return $this->belongsToMany(CommunityMembership::class);
    }

    public function posts(): HasMany {
        return $this->hasMany(Post::class);
    }
}
