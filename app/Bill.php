<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    public function bill_detail(){
        return $this->hasMany('App\BillDetail','id_bill','id');
    }

    public function customer(){
        return $this->belongsTo('App\Customer','id_customer','id');
    }

    public function bill_state(){
        return $this->belongsTo('App\BillState','id_state','id');
    }
}
