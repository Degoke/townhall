<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CommunityGroup extends Model
{
    use HasFactory;

    protected $gaurded = [
        'is_default'
    ];

    protected $fillable = [
        'name'
    ];

    public function community(): BelongsTO {
        return $this->belongsTO(Community::class);
    }

    public function communityMemberships(): BelongsToMany {
        return $this->belongsToMany(CommunityMembership::class);
    }
}
