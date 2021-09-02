<?php

namespace App\Services\CloudsApi;

use App\Services\UniqueResponse;
use Exception;

class VultrCloudApi extends AbstractProviderCloud
{


    function __construct($account)
    {
        parent::__construct($account);
    }
    public function getInstances($region)
    {
        $instancesFromApi = $this->getFromApi();

        $filterdByRegion = $this->filterByRegion($instancesFromApi, $region);

        $instances = $this->generateResponse($filterdByRegion);

        return  $instances;
    }

    public function addInstances($region, $domain, $name, $number)
    {

        $createdInstances = [];

        $names = $this->generateNames($name, $number);

        foreach ($names as $name) {
            try{
                $currentInstance = $this->createInstance($name, $region);

                // add instance to instance model 
                


                $currentInstance = [ 
                    "completed" => true ,
                    "data" => $currentInstance ,
                    "error" => null 
                ];
            }catch(\Exception $e){
                $currentInstance = [ 
                    "completed" => false ,
                    "data" => null ,
                    "error" => $e->getMessage() 
                ];
            }

            $createdInstances[] = $currentInstance;
        }

        return $createdInstances;
    }

    public function RemoveInstances()
    {
    }

    public function installInstance()
    {
    }

    public function removeInstallation()
    {
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

        $response = curl_exec($instance);

        curl_close($instance);

        return json_decode($response, true)['instances'];
    }

    private function createInstance($name, $region)
    {
        // return [ $this->account->getAuth()->first_key , $this->account->proxy ] ;


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

        if( isset( $response["error"] ) ) throw new Exception( "error creating instance $name [ $curl_response ]" );
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
            array_push($array, $response);
        }
        return $array;
    }
}
