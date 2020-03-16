<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employe extends Model
{
    protected $table = 'employes';
    use SoftDeletes;


    public function customer()
    {
        return $this->hasOne('App\Customer', 'customer_id');
    }
}
