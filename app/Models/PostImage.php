<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'path'
    ];

    public function postContent(): BelongsTo {
        return $this->belongsTo(PostContent::class);
    }
}
