<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title', 'slug', 'image', 'summary', 'content', 'is_active',
        'title_en', 'summary_en', 'content_en'
    ];

    public function getTitleLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->title_en ? $this->title_en : $this->title;
    }

    public function getSummaryLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->summary_en ? $this->summary_en : $this->summary;
    }

    public function getContentLocAttribute()
    {
        return app()->getLocale() == 'en' && $this->content_en ? $this->content_en : $this->content;
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            try {
                $tr = new \Stichoza\GoogleTranslate\GoogleTranslate('en', 'tr');
                $tr->setOptions(['verify' => false]);
                if (empty($model->title_en) && !empty($model->title)) {
                    $model->title_en = $tr->translate($model->title);
                }
                if (empty($model->summary_en) && !empty($model->summary)) {
                    $model->summary_en = $tr->translate($model->summary);
                }
                if (empty($model->content_en) && !empty($model->content)) {
                    $model->content_en = $tr->translate($model->content);
                }
            } catch (\Exception $e) {
                // ignore
            }
        });
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
