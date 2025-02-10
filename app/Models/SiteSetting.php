<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo',
        'favicon',
        'phone',
        'email',
        'address',
        'footer_description',
        'facebook_url',
        'instagram_url',
        'youtube_url'
    ];
}
