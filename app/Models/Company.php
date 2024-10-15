<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Models\GroupCompany;

class Company extends Model
{
    use HasFactory;

    /**
     * @var array string
     */
    protected $fillable = [
        'company',
        'groupcompany_id'
    ];

    /**
     * Get the groupcompany that owns the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupcompany(): BelongsTo
    {
        return $this->belongsTo(GroupCompany::class);
    }
}
