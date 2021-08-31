<?php

namespace App\Services;

use App\Models\Account;
use App\Services\CloudsApi\AbstractProviderCloud;
use App\Services\CloudsApi\VultrCloudApi;


class CloudManager {


    private $cloudProvider;

    function __construct( Account $account)
    {   
        switch( $account->provider->name ){

            case 'vultr' : 
                $this->cloudProvider = new VultrCloudApi($account);
                break;

            default:
                throw new \Exception('there is no provider have this name' . $account->provider->name );
            break;
        }   
    }


    function getInstances( string $region ){
        
        return $this->cloudProvider->getInstances();





    }


}