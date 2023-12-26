<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerMobil;


class MobilConfigController extends Controller
{

    function get_banner_mobil()
    {
        $banner = BannerMobil::select("url")->where("estado", 1)->orderby("orden", "asc")->get();
        return $banner;
    }

}
