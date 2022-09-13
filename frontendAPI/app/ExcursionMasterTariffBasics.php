<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExcursionMasterTariffBasics extends Model
{
    //
    protected $table = 'excursion_master_tariff_basics';
    protected $primarykey = 'entry_id';
    public function tariff()
    {
        return $this->belongsTo(ExcursionMasterTariff::class,'exc_id','entry_id');
    }

}
