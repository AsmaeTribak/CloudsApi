<?php

namespace App\Services\Interfaces;

interface IInstallCloud {


    public function installInstance($instanceid,$mainip,$name,$domaine);

    public function removeInstallation();

}