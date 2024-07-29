<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chapter extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
    ];

    public function vault(): HasOne
    {
        return $this->hasOne(Vault::class);
    }
}
