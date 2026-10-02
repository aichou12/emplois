<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminEmailCampaignRecipient extends Model
{
    protected $table = 'admin_email_campaign_recipients';

    protected $fillable = [
        'campaign_id', 'utilisateur_id', 'email', 'status', 'error_message', 'sent_at',
    ];

    protected $casts = ['sent_at' => 'datetime'];
}
