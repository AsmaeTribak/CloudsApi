<?php

namespace App\Services\Interfaces;

interface ICloudManager {

    public function getInstances();

    public function addInstances();

    public function RemoveInstances();


}