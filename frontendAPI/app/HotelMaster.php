<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelMaster extends Model
{
    //
    protected $table = "hotel_master";
    public function hotelImage()
    {
       return $this->belongsTo(HotelVendorImageEntries::class,'hotel_id','hotel_id');
        
    }
    public function hotelCity()
    {
       return $this->belongsTo(CityMaster::class,'city_id','city_id');
        
    }
}
