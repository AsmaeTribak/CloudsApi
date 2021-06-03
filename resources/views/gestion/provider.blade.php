@extends('layouts.main')
@section('content')
<div class="row mt-5">

    <div class="col-md-10 offset-1">

        <button class="btn btn-primary btn-sm float-end mt-3"   data-bs-toggle="modal" data-bs-target="#exampleModal" >add Provider</button>
        <h1 class="text-center"> Provider Management </h1>
        @if (Session::has('fail'))
        <div class="alert alert-danger">
            {{ Session::get('fail') }}
        </div>
        @endif
        @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
   
    <table class="table table-bordered border-primary mt-5">
        <thead>
            <tr>
                <th scope="col">Provider id </th>
                <th scope="col">Provider name</th>
                <th scope="col">entities</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($providers as $provider)
            <tr>
                <td> {{ $provider->id_provider }}</td>
                <td> {{ $provider->name }}</td>
                <td> 
                    
                    @foreach ( $provider->entities as $entity)
                     <span class="badge bg-primary">{{$entity->name }}
                        <button class="btn btn-danger px-1 py-0" style="height:20px;" >x</button>    
                    </span>
                    @endforeach
                    
                </td>
                </tr>
        @endforeach

    </tbody>
</table>
</div>
<form action="{{ route('addprovider')}} " method="Post">
    @csrf

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Provider</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <label for='name_of_provider' class="form-label"> name</label>
        <input type='text'  class="form-control form-control-sm" name ="name" placeholder="provider name">
        <label for='id_of_entity'class="form-label"> provider id</label>
        <input type='text'class="form-control form-control-sm " name ='id_provider' placeholder="id ">
       

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm">Save </button>
        </div>
      </div>
    </div>
  </div>
</form>
 

@endSection
   

