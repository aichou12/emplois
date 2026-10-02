<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminEmailCampaign extends Model
{
    protected $table = 'admin_email_campaigns';

    protected $fillable = [
        'name', 'subject', 'body', 'filters', 'channel', 'status',
        'recipient_count', 'sent_count', 'failed_count', 'created_by',
        'dispatched_at', 'completed_at',
    ];

    protected $casts = [
        'filters' => 'array',
        'dispatched_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function recipients()
    {
        return $this->hasMany(AdminEmailCampaignRecipient::class, 'campaign_id');
    }
}
