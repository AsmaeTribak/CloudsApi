<?php

namespace App\Services\Interfaces;

interface ICloudManager {

    public function getInstances($region);

    public function addInstances($region ,$domain,$name,$number);

    public function RemoveInstances($instanceid);


}