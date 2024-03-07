<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'title'
    ];

    public function postContent(): BelongsTo {
        return $this->belongsTo(PostContent::class);
    }
}
