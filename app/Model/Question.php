<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($question) {
            $question->slug = str_slug($question->title);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = ['title', 'slug', 'body', 'category_id', 'user_id'];

    protected $with = ['replies'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)->latest();
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function getPathAttribute()
    {
        return "/question/$this->slug";
    }
}
