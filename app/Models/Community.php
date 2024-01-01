<?php

namespace App\Models;

use App\Events\CommunityCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $dispatchesEvents = [
        'created' => CommunityCreated::class,
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
