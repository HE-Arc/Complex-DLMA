<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Reprents a db's comment and provides a method to access its owner.
 */
class Comment extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
