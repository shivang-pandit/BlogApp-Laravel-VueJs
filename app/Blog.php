<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'post', 'description', 'slug', 'image', 'meta_description','user_id','image'];

    public function setTitleAttribute($title)
    {       
        $this->attributes['title'] = $title;        
        $this->attributes['slug'] = Str::slug($title,'~').'~'.time();        
    }

    public function categories(){
        return $this->belongsToMany('App\Category','blog_categories', 'blog_id', 'category_id')->withTimestamps();
    }

    public function tags(){
        return $this->belongsToMany('App\Tag','blog_tags', 'blog_id', 'tag_id')->withTimestamps();
    }

    public function user(){
        return $this->belongsTo('App\User')->select('id','full_name');
    }
}
