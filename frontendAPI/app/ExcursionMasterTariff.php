<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ExcursionMasterTariff extends Model
{
    //
    protected $table = 'excursion_master_tariff';
    protected $primarykey = 'entry_id';
    public function excursionMasterTariffBasics()
    {
        return $this->hasOne(ExcursionMasterTariffBasics::class,'exc_id','entry_id');
    }
  
}
