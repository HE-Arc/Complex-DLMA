<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  public function choices()
  {
    return Choice::findOrFail([$this->choice_1_id, $this->choice_2_id]);
  }

  public function choice($choiceNumber)
  {
    if($choiceNumber == 0)
    {
      return Choice::findOrFail($this->choice_1_id);
    }
    
    return Choice::findOrFail($this->choice_2_id);
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function choice1()
  {
    return $this->belongsTo('App\Choice', 'choice_1_id');
  }

  public function choice2()
  {
    return $this->belongsTo('App\Choice', 'choice_2_id');
  }
}
