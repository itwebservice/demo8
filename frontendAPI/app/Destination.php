<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{

    protected $table = 'destination_master';
    protected $primaryKey = "dest_id";
    public function packageMaster()
    {
        return $this->hasMany(CustomPackageMaster::class,'package_id');
    }
    public function galleryImages()
    {
        return $this->hasMany(GalleryMaster::class,'dest_id');
    }

}
