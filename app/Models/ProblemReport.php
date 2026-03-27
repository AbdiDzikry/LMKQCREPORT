<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemReport extends Model
{
    protected $fillable = [
        'user_id',
        'report_date',
        'section',
        'comp_name_2w',
        'part_number',
        'part_name',
        'customer',
        'line_problem',
        'category',
        'quantity',
        'problem_status',
        'vendor',
        'type',
        'problem_type',
        'detail',
        'pic_qc',
        'status',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'report_date' => 'date',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
