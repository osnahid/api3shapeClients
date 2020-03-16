<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;


class Account extends Model
{
    protected $table = 'accounts';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function actions()
    {
        return $this->hasMany('App\Action');
    }
}

