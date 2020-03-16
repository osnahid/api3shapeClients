<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    protected $table = 'customers';
    use SoftDeletes;


    protected $with = ['actions', 'employees'];

    public function employees()
    {
        return $this->hasMany('App\Employe');
    }

    public function actions()
    {
        return $this->hasMany('App\Action');
    }
}
