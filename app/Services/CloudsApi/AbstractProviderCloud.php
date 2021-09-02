<?php

namespace App\Services\CloudsApi;

use App\Services\Interfaces\ICloudManager;
use App\Services\Interfaces\IInstallCloud;
use App\Models\Account;


abstract class AbstractProviderCloud implements ICloudManager, IInstallCloud
{

    protected $account;


    function __construct($account)
    {
        $this->account = $account;
    }



    protected function generateNames($name, $number_instances)
    {

        preg_match('/([a-zA-Z]{5})([0-9]{3})/m', $name, $matches);

        $base_name  = $matches[1];
        $startfrom = (int) $matches[2];
        $list_names = [];

        for ($i =  $startfrom; $i < $startfrom + $number_instances; $i++)
            $list_names[] =   $base_name . str_pad($i, 3, '0', STR_PAD_LEFT);


        return $list_names;
    }
}
