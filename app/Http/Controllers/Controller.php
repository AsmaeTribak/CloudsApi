<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
  public function test()
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.vultr.com/v2/plans',
      // CURLOPT_URL => 'https://api.vultr.com/v2/instances',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_PROXY => 'dcdc79b36d:Bgv2tnZQ@198.23.174.62:8000',

      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer MDSL63OP7H5NUGOZFJWIIVE5HC6TFSJLVX2Q	'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }
}
