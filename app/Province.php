<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    public function region(){
        return $this->belongTo('App\Region','id_region','id');
    }

    public function district(){
        return $this->hasMany('App\District','id_province','id');
    }

    public function marker(){
        return $this->hasMany('App\Marker','id_province','id');
    }

}