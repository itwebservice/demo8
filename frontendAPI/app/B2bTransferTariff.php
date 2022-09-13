<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class B2bTransferTariff extends Model
{
    protected $table = "b2b_transfer_tariff";
   
    public function tariffEntry()
    {
        return $this->hasOne(B2bTransferTariffEntries::class,'tariff_id','tariff_id');
    }
}
