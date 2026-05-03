<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representation extends Model
{
    protected $fillable = ['name', 'logo', 'website', 'description', 'order', 'name_en', 'description_en'];

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
                    // strip HTML to avoid translating tags, but since they have HTML entities, we can decode them first
                    $decoded = html_entity_decode($model->description);
                    $model->description_en = $tr->translate($decoded);
                }
            } catch (\Exception $e) {
                // ignore
            }
        });
    }
}
