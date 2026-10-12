<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'header_logo',
        'footer_logo',
        'favicon',
        'admin_login_logo',
        'admin_dashboard_logo',
        'admin_email',
        'support_email',
        'phone',
        'whatsapp',
        'business_address',
        'footer_description',
        'footer_copyright',
        'google_map_url',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'pinterest',
        'currency',
        'currency_symbol',
        'timezone',
        'maintenance_mode',
        'admin_session_timeout',
        'product_reviews',
        'wishlist',
        'stock_alerts',
        'cod_enabled',
        'working_hours',
        'email_response_note',
        'address_short',
        'enquiry_subjects',
        'popular_searches',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'product_reviews' => 'boolean',
        'wishlist' => 'boolean',
        'stock_alerts' => 'boolean',
        'cod_enabled' => 'boolean',
    ];

    /**
     * Subject dropdown options for the contact form, one per line in the admin field.
     */
    public function getEnquirySubjectListAttribute(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->enquiry_subjects))
            ->map(fn($s) => trim($s))
            ->filter()
            ->values()
            ->all();
    }

    public function getPopularSearchListAttribute(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->popular_searches))
            ->map(fn($s) => trim($s))
            ->filter()
            ->values()
            ->all();
    }

}