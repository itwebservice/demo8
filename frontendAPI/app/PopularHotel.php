<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PopularHotel extends Model
{
    //
    protected $table = "custom_package_hotels";
    public function hotel()
    {
        return $this->belongsTo(HotelMaster::class,'hotel_name','hotel_id');
    }
    public function city()
    {
        return $this->belongsTo(CityMaster::class,'city_name','city_id');

    }
}
