<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income_and_expenditure extends Model
{
    Public function category()
   {
     return $this->belongsTo('App\Category');
   }
}
