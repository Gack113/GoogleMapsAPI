<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'type_users';

    public function user(){
        return $this->hasMany('App\User','type','id');
    }
}
