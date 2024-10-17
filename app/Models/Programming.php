<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programming extends Model
{
    use HasFactory;

    protected $fillable = [
        'naction',
        'ngroup',
        'action_id',
        'modality',
        'platform_id',
        'nhours',
        'communication_date',
        'start_date',
        'end_date',
        'number_students',
        'company_id',
        'observations',
        'tutor_id',
        'coordinator_id',
        'agent_id',
        'supplier_id',
        'course_type',
        'cost',
        'billed_month',
        'rlt',
        'rlt_send',
        'rlt_received',
        'rlt_favorable',
        'rlt_incident',
        'canceled',
        'incident'      
    ];
}
