<?php

namespace App\Models;

use App\Models\Action;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    /** @var array string */
    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the actions for the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }
}
