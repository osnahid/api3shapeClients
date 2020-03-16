<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Software extends Model
{
    protected $table = 'softwares';
    use SoftDeletes;

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function actions()
    {
        return $this->hasMany(App\Action::class);
    }
}
