<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fair extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'start_date', 'end_date', 'location', 'description', 'website', 'image', 'video', 'is_featured',
        'logo', 'subject', 'venue', 'organizer', 'edition', 'grant_amount', 'exhibitor_profile',
        'name_en', 'description_en', 'exhibitor_profile_en'
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
            } catch (\Exception $e) {
                // ignore if api fails
            }
        });
    }

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
    ];


}
