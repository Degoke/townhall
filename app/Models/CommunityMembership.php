<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CommunityMembership extends Model
{
    use HasFactory;

    protected $gaurded = [
        'is_admin'
    ];

    protected $with = [
        'community'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function community(): BelongsTo {
        return $this->belongsTo(Community::class);
    }

    public function communityGroups(): BelongsToMany {
        return $this->belongsToMany(CommunityGroup::class);
    }
}
