<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fair extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'start_date', 'end_date', 'location', 'description', 'website', 'image', 'images', 'video', 'is_featured',
        'logo', 'subject', 'venue', 'organizer', 'edition', 'grant_amount', 'exhibitor_profile',
        'name_en', 'description_en', 'exhibitor_profile_en', 'subject_en', 'location_en', 'venue_en', 'organizer_en', 'edition_en'
    ];

    public function getNameLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->name_en ? $this->name_en : $this->name;
    }

    public function getDescriptionLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->description_en ? $this->description_en : $this->description;
    }

    public function getProfileLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->exhibitor_profile_en ? $this->exhibitor_profile_en : $this->exhibitor_profile;
    }

    public function getSubjectLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->subject_en ? $this->subject_en : $this->subject;
    }

    public function getLocationLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->location_en ? $this->location_en : $this->location;
    }

    public function getVenueLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->venue_en ? $this->venue_en : $this->venue;
    }

    public function getOrganizerLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->organizer_en ? $this->organizer_en : $this->organizer;
    }

    public function getEditionLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->edition_en ? $this->edition_en : $this->edition;
    }

    public function getWebsiteAttribute($value)
    {
        if (empty($value)) return $value;
        if (!preg_match("~^(?:f|ht)tps?://~i", $value)) {
            return "https://" . $value;
        }
        return $value;
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            try {
                $tr = new \Stichoza\GoogleTranslate\GoogleTranslate('en', 'tr');
                $tr->setOptions(['verify' => false]);
                if (empty($model->name_en) && !empty($model->name)) {
                    $model->name_en = $tr->translate($model->name);
                }
                if (empty($model->description_en) && !empty($model->description)) {
                    $model->description_en = $tr->translate($model->description);
                }
                if (empty($model->exhibitor_profile_en) && !empty($model->exhibitor_profile)) {
                    $model->exhibitor_profile_en = $tr->translate($model->exhibitor_profile);
                }
                if (empty($model->subject_en) && !empty($model->subject)) {
                    $model->subject_en = $tr->translate($model->subject);
                }
                if (empty($model->location_en) && !empty($model->location)) {
                    $model->location_en = $tr->translate($model->location);
                }
                if (empty($model->venue_en) && !empty($model->venue)) {
                    $model->venue_en = $tr->translate($model->venue);
                }
                if (empty($model->organizer_en) && !empty($model->organizer)) {
                    $model->organizer_en = $tr->translate($model->organizer);
                }
                if (empty($model->edition_en) && !empty($model->edition)) {
                    $model->edition_en = $tr->translate($model->edition);
                }
            } catch (\Exception $e) {
                // ignore if api fails
            }
        });
    }

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'images' => 'array',
    ];


}
