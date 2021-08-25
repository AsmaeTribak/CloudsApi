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
        <caption> Provider Table </caption>
        <thead>
            <tr>
                <th scope="col">Provider id </th>
                <th scope="col">Provider name</th>
                <th scope="col">Entities</th>
                <th scope="col">actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($providers as $provider)
            <tr>
                <td> {{ $provider->id_provider }} </td>
                <td> {{ $provider->name }} /  {{ $provider->type }} </td>
                <td>

                    @foreach ( $provider->entities as $entity)
                        <span class="badge bg-primary">{{$entity->name }}
                            <a href='{{ url ("/providers/$provider->id_provider/dettache/$entity->id_entity") }}' class="btn btn-danger px-1 py-0"  > <i class="bi bi-x-lg"></i> </a>
                        </span>
                    @endforeach


                </td>

                <td>

                    <form action='{{ url("/providers/attach/$provider->id_provider") }}' method="POST">
                    @csrf
                    <div class="input-group input-group-sm ">
                        <select class="form-select" id="inputGroupSelect04" name="entityid" aria-label="Example select with button addon">

                        @php
                            $entitiesAttached = $provider->entities->map( function($item, $key) { return  $item->id_entity; })->toArray() ;
                        @endphp

                          @foreach ( \App\Models\Entity::all() as $entity )
                            <option @if( in_array( $entity->id_entity ,  $entitiesAttached ) ) disabled @endif value="{{$entity->id_entity}}"> {{  $entity->name }} </option>
                          @endforeach

                        </select>
                        <button class="btn btn-outline-primary" type="submit">Attach</button>
                      </div>
                    </form>

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

        

        <label for='keys_of_account' class="form-label">number of key</label>
        <div class="input-group input-group-sm ">

            <select class="form-select" name="authType" id="numberKeysSelect" >
                <option value="1key" > One key </option>
                <option value="2key" > Two key </option>
                <option value="4key" > Four key </option>
            </select>

        </div>

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

