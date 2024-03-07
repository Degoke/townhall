<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text_content',
    ];

    protected $with = [
        'images',
        'links'
    ];

    public function post(): HasOne {
        return $this->hasOne(Post::class);
    }

    public function images(): HasMany {
        return $this->hasMany(PostImage::class);
    }

    public function links(): HasMany {
        return $this->hasMany(PostLink::class);
    }
}
