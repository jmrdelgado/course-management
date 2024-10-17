<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use App\Models\Programming;

class Platform extends Model
{
    use HasFactory;

    /**
     * @var array string
     */
    protected $fillable = [
        'name',
        'color',
        'description'
    ];

    /**
     * Get all of the cursos for the Platform
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Programming::class);
    }
}
