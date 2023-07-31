<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sastra extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['user', 'comment', 'like'];
    protected $hidden = ['is_delete', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class)->with('user');
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }

    public function scopeSearch($query, $q)
    {
        return $query->where(function ($query) use ($q) {
            $query->where('title', 'like', "%{$q}%")
                ->orWhere('penulis', 'like', "%{$q}%")
                ->orWhere('body', 'like', "%{$q}%");
        })->where('is_delete', false);
    }

}
