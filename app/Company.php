<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    protected $table = 'companies';

    protected $with = ['materiels', 'softwares'];

    use SoftDeletes;

    public function materiels()
    {
        return $this->hasMany('App\Materiel');
    }

    public function softwares()
    {
        return $this->hasMany('App\Software');
    }
}
