<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewDetail extends Model
{
    protected $table = 'new_detail';

    public function new_offer(){
        return $this->belongsTo('App\NewOffer','id_new','id');
    }

    public function product(){
        return $this->belongsTo('App\Product','id_product','id');
    }
}
