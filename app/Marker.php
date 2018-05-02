<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $table = 'markers';

    public function bill(){
        return $this->hasMany('App\Bill','id_marker','id');
    }

    public function region(){
        return $this->belongsTo('App\Region','id_region','id');
    }

    public function province(){
        return $this->belongsTo('App\Province','id_province','id');
    }

    public function district(){
        return $this->belongsTo('App\District','id_district','id');
    }
}