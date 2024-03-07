<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $with = [
        'user',
        'comments',
        'content'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function communityGroup(): BelongsTo {
        return $this->belongsTo(communityGroup::class);
    }

    public function content(): HasOne {
        return $this->hasOne(PostContent::class);
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

}
