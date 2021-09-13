<?php

namespace App\Services\CloudsApi;

use App\Services\UniqueResponse;
use App\Models\Instance;
use Exception;

class VultrCloudApi extends AbstractProviderCloud
{


    function __construct($account)
    {
        parent::__construct($account);
    }
    public function getInstances($region)
    {   
        try{

            $instancesFromApi = $this->getFromApi();

        }catch( \Exception $e ){
            return [ 
                "completed" => false ,
                "data" => null ,
                "error" => $e->getMessage() 
            ];
        }
        

        $filterdByRegion = $this->filterByRegion($instancesFromApi, $region);

        $instances = $this->generateResponse($filterdByRegion);

        return  [ 
            "completed" => true ,
            "data" => $instances ,
            "error" => null 
        ];

        
    }

    public function addInstances($region, $domain, $name, $number)
    {

        $createdInstances = [];

        $names = $this->generateNames($name, $number);

        foreach ($names as $name) {
            try{
                $currentInstance = $this->createInstance($name, $region);

                // add instance to instance model 
                $instance=new Instance();
                $instance->instance_id=$currentInstance["id"];
                $instance->instance_name=$currentInstance['label'];
                $instance->domain=$domain;
                $instance->save();

                $currentInstance = [ 
                    "completed" => true ,
                    "data" => $currentInstance ,
                    "error" => null     
                ];

            }catch(\Exception $e){
                $currentInstance = [ 
                    "completed" => false ,
                    "data" => [] ,
                    "error" => $e->getMessage() 
                ];
            }

            $createdInstances[] = $currentInstance;
        }

        return $createdInstances;
    }

    public function RemoveInstances($instanceid){
        
        try{
            $removed = $this->deleteInstanceApi( $instanceid );
            $this->removeInstallation();
            return [
                "completed" => true ,
                "data" => $removed ,
                "error" => null 
            ];
        }catch(\Exception $e){
            return [ 
                "completed" => false ,
                "data" => [] ,
                "error" => $e->getMessage() 
            ];
        }
    }
    

    public function installInstance()
    {
        return ["asma2 xdida "];
    }

    public function removeInstallation()
    {
        // TODO: remove installation from other application by api
    }



    // -----------------------------

    private function getFromApi()
    {

        $instance = curl_init();

        curl_setopt_array($instance, array(
            CURLOPT_URL => 'https://api.vultr.com/v2/instances',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_PROXY => $this->account->proxy,

            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->account->getAuth()->first_key
            ),
        ));

        $curl_response = curl_exec($instance);

        curl_close($instance);

        $response = $response = json_decode( $curl_response , true) ;
        if ( !isset( $response["instances"] ) ) 
            throw new Exception( "error in loading of instances [ $curl_response ]" );
        
        return $response['instances'];
    }

    private function createInstance($name, $region)
    {
        
        $body = [
            "region" => $region ,
            "plan" => "vc2-1c-1gb",
            "label" => $name,
            "os_id"=>167,
            "backups"=> "disabled"
        ];

        $body = json_encode( $body  );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.vultr.com/v2/instances',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_PROXY => $this->account->proxy,
            CURLOPT_POSTFIELDS => $body ,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->account->getAuth()->first_key,
                'Content-Type: application/json'
            ),
        ));

        $curl_response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($curl_response, true);

        if( isset( $response["error"] ) ) 
            throw new Exception( "error creating instance $name [ $curl_response ]" );
        
        return $response["instance"];

    }

    private function deleteInstanceApi($instanceid){
        $instance = curl_init();

        curl_setopt_array($instance, array(
            CURLOPT_URL => "https://api.vultr.com/v2/instances/$instanceid",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_PROXY => $this->account->proxy,

            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->account->getAuth()->first_key
            ),
        ));

        $curl_response = curl_exec($instance);

        curl_close($instance);

        $response = $response = json_decode( $curl_response , true) ;
        if ( isset( $response["error"] ) ) 
            throw new Exception( "error in deleting instance [ $curl_response ]" );
        
        return $response;


    }

    private function filterByRegion($instances, $region)
    {

        // return $instances;
        $filter = array_filter($instances, function ($instance) use ($region) {
            return $instance['region'] == $region;
        });
        return $filter;
    }
    private function generateResponse($instances)
    {

        $array = array();
        foreach ($instances as $instance) {

            $response = new UniqueResponse();
            $response->id = $instance["id"];
            $response->name = $instance['label'];
            $response->region = $instance['region'];
            $response->mainIp = $instance['main_ip'];
            $response->accountId = $this->account->id_account;
            // get record instance from database
          $record = Instance::where('instance_id' ,$instance["id"])->first();

            if( $record != null )
            $response->domaine = $record->domain; 


            array_push($array, $response);
        }
        return $array;
    }
}
