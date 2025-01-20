<?php

namespace App\Models;

use App\Models\Tutor;
use App\Models\Action;
use App\Models\Company;

use App\Models\Platform;
use App\Models\Departure;
use App\Models\Coordinator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Programming extends Model
{
    use HasFactory;

    protected $fillable = [
        'naction',
        'denomination',
        'ngroup',
        'action_id',
        'modality',
        'platform_id',
        'nhoursp',
        'nhourstf',
        'nhourst',
        'communication_date',
        'start_date',
        'end_date',
        'number_students',
        'sionline',
        'company_id',
        'groupcompany',
        'observations',
        'tutor_id',
        'coordinator_id',
        'agent',
        'supplier',
        'course_type',
        'student_cost',
        'cost',
        'project_cost',
        'billed_month',
        'rlt',
        'rlt_send',
        'rlt_received',
        'rlt_favorable',
        'rlt_incident',
        'incident',
        'canceled' 
    ];

    /**
     * Get the action that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

    /**
     * Get the platform that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    /**
     * Get the departure that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departure(): BelongsTo
    {
        return $this->belongsTo(Departure::class);
    }

    /**
     * Get the tutor that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Get the coordinator that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(Coordinator::class);
    }

    /**
     * Get the company that owns the Programming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
