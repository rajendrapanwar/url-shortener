<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'slug'];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function shortUrls()
    {
        return $this->hasMany(ShortUrl::class);
    }
}
