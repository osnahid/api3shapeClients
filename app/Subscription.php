<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Subscription extends Model
{

    protected $table = 'subscriptions';
    use SoftDeletes;



    public function actions()
    {
        return $this->hasMany(App\Action::class);
    }
}
