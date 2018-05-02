<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewOffer extends Model
{
    protected $table = 'news';

    public function new_detail(){
        return $this->hasMany('App\NewDetail','id_new','id');
    }
}
