<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Action extends Model
{
    protected $table = 'actions';

    use SoftDeletes;

    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id');
    }

    public function material()
    {
        return $this->belongsTo('App\Material', 'material_id');
    }

    public function software()
    {
        return $this->belongsTo('App\Software', 'software_id');
    }

    public function subscription()
    {
        return $this->belongsTo('App\Subscription', 'subscription_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }


}
