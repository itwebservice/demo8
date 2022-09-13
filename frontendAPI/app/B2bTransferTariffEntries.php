<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class B2bTransferTariffEntries extends Model
{
    protected $table = "b2b_transfer_tariff_entries";
    public function cityFrom()
    {
        return $this->hasOne(CityMaster::class,'city_id','pickup_location');
    }    
    public function cityTo()
    {
        return $this->hasOne(CityMaster::class,'city_id','drop_location');
    }    
}
