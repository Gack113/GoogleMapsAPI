<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    public function region(){
        return $this->belongTo('App\Region','id_region','id');
    }

    public function province(){
        return $this->belongTo('App\Province','id_province','id');
    }

    public function marker(){
        return $this->hasMany('App\Marker','id_district','id');
    }

}