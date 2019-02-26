<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable = ['company_id', 'user', 'title', 'pro', 'contra', 'suggestions'];

    /**
     * review belongs to only one user
     */
    public function userReview()
    {
      return $this->belongsTo(User::class);
    }

    /**
     * review belongs to only one company
     */
    public function companyReview()
    {
      return $this->belongsTo(Company::class);
    }

    /**
     * review has only one rating
     */
    public function rating()
    {
      return $this->hasOne(Rating::class);
    }
}
