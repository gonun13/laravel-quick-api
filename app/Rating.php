<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    protected $fillable = ['review_id', 'culture', 'management', 'work_live_balance', 'career_development'];

    /**
     * rating belongs to only one review
     */
    public function rating()
    {
      return $this->belongsTo(Rating::class);
    }
}
