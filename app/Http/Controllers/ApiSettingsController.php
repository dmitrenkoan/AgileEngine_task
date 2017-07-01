<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiSetting;

class ApiSettingsController extends Controller
{
    // decode the key and a secret which save in request header and check it with the value from database
    static public function checkAuth($authHeader) {
        $arHeader = explode(":" ,base64_decode($authHeader));

        $checkResult = ApiSetting::where('key' , $arHeader[0])
            ->where('secret', $arHeader[1])
            ->first();
        if(!empty($checkResult->id)) {
            return true;
        }
        else {
            return false;
        }
    }
}
