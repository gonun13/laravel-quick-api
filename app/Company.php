<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'slug', 'city', 'country', 'industry'];

    /**
     * company can have many reviews
     */
    public function reviews()
    {
      return $this->hasMany(Review::class);
    }
}
