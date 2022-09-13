<?php

namespace App\Http\Controllers;

use App\AppSetting;
use App\B2bTransferMaster;
use App\b2cSetting;
use App\b2cTestimonial;
use App\CustomPackageMaster;
use App\Destination;
use App\ExcursionMasterTariff;
use App\ExcursionMasterImages;
use App\ExcursionMasterTariffBasics;
use App\GalleryMaster;
use App\HotelMaster;
use App\PopularHotel;
use Illuminate\Http\Request;

class DataController extends Controller
{
    //
    public function banner()
    {
        if(!empty(b2cSetting::first()))
        {
        $banner = json_decode(b2cSetting::first()->banner_images);
        }
        else
        {
            $banner = null;
        }
        return response($banner,200);
    }
    public function testimonial()
    {
        $testimonial = b2cTestimonial::all();
       
        return response($testimonial,200);
    }
    public function gallery()
    {
        $gallery = json_decode(b2cSetting::first()->gallery);
        return response($gallery,200);
    }
    public function footerHolidays()
    {
        $footer = json_decode(b2cSetting::first()->footer_holidays);
       if(empty($footer))
       {
        return response([],200);
       }
        $packageData = CustomPackageMaster::with('destination')->get();
        $allData = array();
        foreach($packageData as $data)
        {
            foreach($footer as $f)
            {
                    if($f->package_id == $data->package_id)
                    {
                        array_push($allData,$data);
                    }
            }
        }
        return response($allData,200);
    }
    public function destination()
    {
        $packageData = CustomPackageMaster::with('destination.galleryImages','images')->get();
        $setData = b2cSetting::first();
        $popularDest = json_decode($setData->popular_dest);
        $verifyDest = array();
        if(empty($popularDest))
        {
         return response([],200);
        }
        $popularDestData = array();
        foreach($popularDest as $destination)
        {
          foreach($packageData as $data)
          {
              if($destination->package_id == $data->package_id)
              {

                     $temp = $data->destination;
                    if(!in_array($temp->dest_id,$verifyDest))
                    {
                     array_push($verifyDest,$temp->dest_id);
                     array_push($popularDestData,$temp);
                    }
              } 
          }
        }
        //dd($popularDestData);
        return response($popularDestData,200);
    }
    public function popularPackage()
    {
    
      $packageData = CustomPackageMaster::with('destination.galleryImages','images','tariff')->get();
      
      $setData = b2cSetting::first();
      $popularDest = json_decode($setData->popular_dest);
        
      if(empty($popularDest))
      {
       return response([],200);
      }
      $popularDestData = array();
      foreach($popularDest as $destination)
      {
        foreach($packageData as $data)
        {
            if($destination->package_id == $data->package_id)
            {
                $data->main_img_url = $destination->url;
                    array_push($popularDestData,$data);
            }


        }
      }
    
      return response($popularDestData,200);
    }
    public function activities()
    {
        $setData = b2cSetting::first();
        $popularAct = json_decode($setData->popular_activities);
        if(empty($popularAct))
        {
         return response([],200);
        }
        $activities = ExcursionMasterTariff::all();
        $selectedActivities = array();
        foreach($activities as $main)
        {
         foreach($popularAct as $act)
             {
           
                    if($act->exc_id == $main->entry_id)
                    {
                        $basic = ExcursionMasterTariffBasics::where('exc_id',$main->entry_id)->first();
                        $images = ExcursionMasterImages::where('exc_id',$main->entry_id)->get();
                            $main->basics = $basic;
                            $main->images = $images;
                            array_push($selectedActivities,$main);
                    }

            }
        }
       // dd($selectedActivities);
        return response($selectedActivities,200);
    }
    public function general()
    {
       $general = AppSetting::first(['setting_id', 'app_version', 'app_email_id', 'currency', 'app_contact_no', 'app_landline_no','app_address', 'app_website', 'app_name', 'country']);
       return response($general,200);     
    }
    public function social()
    {
        $social = json_decode(b2cSetting::first()->social_media)[0];
        
        return response([$social],200);
    }
    public function associationLogos()
    {
        $b2c = json_decode(b2cSetting::first(['assoc_logos'])->assoc_logos);
        $dir = 'https://itourscloud.com/destination_gallery/association-logo/';
        $logoArray = array();
        $count =55;
        for($i = 1; $i<=$count; $i++){
          if(in_array($i,$b2c))
          {
              $image_path = $dir.$i.'.png';
                array_push($logoArray,$image_path);
          }
        }
        return response($logoArray,200);
    }
    public function popularHotel()
    {
        $popularHotels =HotelMaster::with(['hotelImage','hotelCity'])->get();
        $b2chotels = json_decode(b2cSetting::first()->popular_hotels);
        
        if(empty($b2chotels))
        {
         return response([],200);
        }
        $selectedHotel = array();
        foreach($popularHotels as $hotel)
        {
            foreach($b2chotels as $b2chotel)
            {
                    if($b2chotel->hotel_id == $hotel->hotel_id)
                    {
                            array_push($selectedHotel,$hotel);
                    }
            }
        }
     
        return response($selectedHotel,200);
    }
    public function transport()
    {
        $transport = B2bTransferMaster::with(['tariff.tariffEntry.cityFrom','tariff.tariffEntry.cityTo'])->get();
        //dd($transport);
        return response($transport,200);
    }
}
