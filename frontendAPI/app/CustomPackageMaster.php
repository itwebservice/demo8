<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomPackageMaster extends Model
{
    protected $table = "custom_package_master";
    protected $primaryKey = "package_id";
    public function destination()
    {
       return $this->belongsTo(Destination::class,'dest_id');
    }
    public function images()
    {
        return $this->hasMany(CustomPackageImages::class,'package_id');
    }
    public function tariff()
    {
        return $this->hasOne(CustomPackageTariff::class,'package_id');
    }
}
