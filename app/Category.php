<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function income_and_expenditures(){
        return $this->hasMany('App\Income_and_expenditure');
    }
}
