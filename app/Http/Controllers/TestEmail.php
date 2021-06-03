<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class TestEmail extends Controller
{
    //


    public function index(){

        $data = array('name'=>"Virat Gandhi");
   
        // Mail::send(['text'=>'mail'], $data, function($message) {
        Mail::send('mail' , $data, function($message) {
           $message->to('AsmaaeTest@gmail.com', 'Tutorials Point')->subject
              ('Laravel Basic Testing Mail');
           $message->from('AsmaaeTest@gmail.com','Virat Gandhi');
        });
        return "Basic Email Sent. Check your inbox.";



    }
    // public Function teest(
    //   $entity->providers()->





    // )



}
