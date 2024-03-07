<?php

namespace App\Models;

use App\Events\CommunityCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    protected $dispatchesEvents = [
        'created' => CommunityCreated::class,
    ];

    protected $with = [
        'communityGroups'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function communityMemberships(): HasMany {
        return $this->hasMany(CommunityMembership::class);
    }

    public function communityGroups(): HasMany {
        return $this->hasMany(CommunityGroup::class);
    }
}
