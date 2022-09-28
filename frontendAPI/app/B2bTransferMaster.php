<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class B2bTransferMaster extends Model
{
    protected $table = "b2b_transfer_master";
   

    public function tariff()
    {
        return $this->hasMany(B2bTransferTariff::class,'vehicle_id','entry_id');
    }
}
