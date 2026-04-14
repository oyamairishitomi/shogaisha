<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $fillable = ['title','body','image_path'];
    public function entries(){
    return $this->hasMany(Entry::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
