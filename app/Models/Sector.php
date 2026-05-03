<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image', 'icon', 'name_en', 'description_en'];

    public function getNameLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->name_en ? $this->name_en : $this->name;
    }

    public function getDescriptionLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->description_en ? $this->description_en : $this->description;
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
            } catch (\Exception $e) {
                // ignore
            }
        });
    }

    public function fairs(): HasMany
    {
        return $this->hasMany(Fair::class);
    }
}
