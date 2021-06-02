<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = Entity::paginate(5);

        // return $usersOfCurrentEntity;

        return view('vieww.entity', ['entities' => $entities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $entity = new Entity;

        $entity->ref_entity=$request->ref_entity;
        $entity->name=$request->name;
        $saved = $entity->save();

        // return [ $entity , $request->all() ];

        if( $saved)
        return redirect()->back()->with('success','entity added successfuly');
        else
        return redirect()->back()->withfail('hopelessly' );
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $entitychanges= Entity::find($request->id_entity);
      $entitychanges->name = $request->name;
      $entitychanges->ref_entity = $request->ref_entity;

        // return $entitychanges;
        $saved = $entitychanges->update();
        if($saved)
        return redirect()->back()->with('success','entity update successfuly');
        else 
        return redirect()->back()->withfail('hopelessly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entity=Entity::find($id);

     
        $delete= $entity->delete();
        
        
        return $delete ? 
            redirect()->back()->with('success','entity delete successfuly'):
            redirect()->back()->withfail('hopelessly');

    }
}
