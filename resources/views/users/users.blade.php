@extends('layouts.main')


@section('content') 


<div class="row mt-5">

    <div class="col-md-10 offset-1">
  
        <a href="{{ url('/register') }}" class="btn btn-primary btn-sm float-end mt-3">add user</a>
        <h1 class="text-center"> User Management </h1>


        <table class="table table-bordered border-primary mt-5">
            <thead>
            <tr>
                <th scope="col">Reference User</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">is Activate</th>
                @if( in_array( Auth::user()->role , [ "leader" , "admin" ]  ) )
                <th scope="col">Actions</th>
                @endif
                </tr>
            </thead>
            <tbody>

            @foreach ($usersOfCurrentEntity as $user)
               
          
            <tr> 
                <th scope="row">{{$user->ref_user}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role}} </td>
                <td> 

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckCheckedDisabled" @if( $user->email_verified_at != null ) checked @endif disabled>
                    </div>

                </td>
                @if( in_array( Auth::user()->role , [ "leader" , "admin" ]  )  )
                <td>
                    @if( Auth::user()->role == "admin" )
                    <button class="btn btn-primary btn-sm"  >Update Role</button>
                    @endif
                    <button class="btn btn-primary btn-sm">desactive User</button>
                </td>
                @endif
            </tr>
            @endforeach

            </tbody>
        </table>

    </div>
</div>


@endSection