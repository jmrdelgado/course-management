<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use App\Models\Programming;

class Action extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'naction',
        'denomination',
        'nhours',
    ];

    /**
     * Get all of the cursos for the Action
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Programming::class);
    }
}
