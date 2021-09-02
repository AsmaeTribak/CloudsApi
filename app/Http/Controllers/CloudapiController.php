<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FourKeys;
use App\Models\OneKey;
use App\Models\Provider;
use App\Models\TwoKeys;
use App\Services\CloudManager;
use App\SSHkey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CloudapiController extends Controller
{
  public function region()
  {
    $accounts = Account::all();

    $regions = $array = array(
      "ams" => "NL Amsterdam",
      "atl" => "US Atlanta",
      "cdg" => "FR Paris",
      "dfw" => "US Dallas",
      "ewr" => "US New Jersey",
      "icn" => "KR Seoul",
      "lax" => "US Los Angeles",
      "lhr" => "GB London",
      "mia" => "US Miami",
      "nrt" => "JP Tokyo",
      "ord" => "US Chicago",
      "sea" => "US Seattle",
      "sgp" => "SG Singapore",
      "sjc" => "US Silicon",
      "syd" => "AU Sydney",
      "yto" => "CA Toronto",
    );
    return view('gestion.cloudapi', ['regions' => $regions, 'accounts' => $accounts]);
  }

  public function getInstances(Request $request)
  {

    $account = Account::find($request->account);
    $region = $request->region;

    $test = new CloudManager($account);

    return $test->getInstances($region);
  }

  public function addInstance(Request $request)
  {

    $account = Account::find($request->account);
    $region = $request->region;
    $domain = $request->instance_domain;
    $name = $request->instance_name;
    $number = $request->instance_number;
    
    $manager = new CloudManager($account);

    $instancesAdded = $manager->addInstances($region, $domain, $name, $number);

    return $instancesAdded;
  }
}
