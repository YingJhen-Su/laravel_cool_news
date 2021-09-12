<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [''];

    protected $appends = ['short_content'];

    public function getShortContentAttribute() {
      return mb_substr($this->content, 0, 200, "utf-8")."......";
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    public function tags()
    {
      return $this->belongsToMany(Tag::class, 'news_tag');
    }
}