<?php

namespace App\Http\Controllers;

use App\DeviceFinder;
use App\Device;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function updateStatus(Request $request)
    {
        $oFinder = new DeviceFinder();
        $oDevice = new Device();
        $oData = $oFinder->scan();
        $oDevice->cid = $oData->cid;
        $oDevice->mid = $oData->cid;
        $oDevice->mac = $oData->mac;
        $oDevice->name = $oData->name;
        $oDevice->pair();

        $aData = $request->all();
        if (isset($aData['powerToggle'])) {
            dd($aData);
            if ($aData['powerToggle'] == 'on') {
                $oDevice->on();
            }
        } else {
            $oDevice->off();
            return;
        }

        if (isset($aData['temp'])) {
            $oDevice->setTemp($aData['temp']);
        }
    }
}
