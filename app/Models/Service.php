<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'name_en', 'description_en'];

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
                $tr = new \Stichoza\GoogleTranslate\GoogleTranslate('en', 'tr'); // tr to en
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
}
