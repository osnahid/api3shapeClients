<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Materiel extends Model
{

    protected $table = 'materiels';
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
