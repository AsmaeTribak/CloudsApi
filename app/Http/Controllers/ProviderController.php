<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Provider::all();
        return view('gestion.provider', ['providers' => $providers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $provider=new Provider;
        $provider->name=$request->name;
        $provider->type=$request->authType;

        $saved = $provider->save();
        return $saved ? 
                redirect()->back()->with('success','provider added successfuly'):
                redirect()->back()->withfail('hopelessly');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    // public function edit(Provider $provider)
    public function edit($providerid, $action , $entityid)
    {

        $providers = Provider::find($providerid);

        if( !in_array( $action , [ "dettache" , "attache" ] ) ){
            return redirect()->back()->withFail("action doesn't exist");
        }
           
    
        if($providerid==null){
            return redirect()->back()->withFail("provider  doesn't exist");
        }
        
        if($action=='dettache'){
            $detache=$providers->entities()->detach($entityid);
        }
            
         return $detache ? 
                    redirect()->back()->with('success','entity detach sucefuly'):
                    redirect()->back()->withFail('hopelessly');

    }


    public function attach($providerid,Request $request){

        if(Entity::find($request->entityid) == null ){
            return redirect()->back()->withfail('hopelessly entity id not found');
        }
            
        $provider= Provider::find($providerid);
       
        $save = $provider->entities()->attach([$request->entityid]);
        
        return $save == null ? 
            redirect()->back()->with('success','attaching  successfuly'):
            redirect()->back()->withfail('hopelessly');
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $provider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        //
    }
}
