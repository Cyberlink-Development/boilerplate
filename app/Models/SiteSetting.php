<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'u_id','site_name', 'logo','location', 'phone', 'email_primary', 'email_secondary', 'facebook_link', 'linkedin_link', 'youtube_link', 'twitter_link', 'instagram_link', 'google_map', 'welcome_title', 'copyright_text'
    ];
}
