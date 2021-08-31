<?php 

namespace App\Services\CloudsApi;

use App\Services\Interfaces\ICloudManager;
use App\Services\Interfaces\IInstallCloud;
use App\Models\Account;


abstract class AbstractProviderCloud implements ICloudManager , IInstallCloud {

    protected $account;


    function __construct($account){
        $this->account = $account;
    }
    

    
}