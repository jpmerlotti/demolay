<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chapter extends Model
{
    use HasFactory, HasUuids;

    public $fillable = [
        'name',
        'is_active'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function demolays(): HasMany
    {
        return $this->hasMany(Demolay::class);
    }

    public function leadings(): HasMany
    {
        return $this->hasMany(Leading::class);
    }

    public function vault(): HasOne
    {
        return $this->hasOne(Vault::class, 'id', 'vault_id');
    }
}
