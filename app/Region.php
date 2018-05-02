<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';

    public function province(){
        return $this->hasMany('App\Province','id_region','id');
    }

    public function district(){
        return $this->hasMany('App\District','id_region','id');
    }

    public function marker(){
        return $this->hasMany('App\Marker','id_region','id');
    }
}