<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Leading extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',

    ];

    public function body(): HasOne
    {
        return $this->hasOne(LeadingBody::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
