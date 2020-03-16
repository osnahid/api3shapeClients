<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    protected $table = 'companies';
    use SoftDeletes;

    public function materials()
    {
        return $this->hasMany('App\Material');
    }

    public function softwares()
    {
        return $this->hasMany('App\Software');
    }
}
