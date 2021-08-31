<?php

namespace App\Services\CloudsApi;

class VultrCloudApi extends AbstractProviderCloud {
    

    function __construct($account)
    {
        parent::__construct($account);
    }
    public function getInstances(){
        $instance =curl_init();

        curl_setopt_array($instance, array(
          CURLOPT_URL => 'https://api.vultr.com/v2/instances',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_PROXY =>$this->account->proxy,
        
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$this->account->getAuth()->first_key
          ),
        ));
        
        $response = curl_exec($instance);
        
        curl_close($instance);

        return json_decode( $response , true )['instances'];        
    }

    public function addInstances(){

    }

    public function RemoveInstances(){

    }
    
    public function installInstance(){


    }

    public function removeInstallation(){

    }





}