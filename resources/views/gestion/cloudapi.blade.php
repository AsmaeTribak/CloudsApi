@extends('layouts.main')


@section('content')

    <div class="col-md-10 offset-1">



        <div class="row mt-5">

            <div class="col-6">

                <div class="row">
                    <div class="col-5">
                        <label for="formGroupExampleInput" class="form-label">Accounts</label>
                        <select class="form-select form-select-sm" id="accountSelector" name="account"
                            aria-label="Example select with button addon">

                            @foreach ($accounts as $account)
                                <option value="{{$account->id_account}}" > {{ $account->name }} </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-4">

                        <label for="formGroupExampleInput" class="form-label">Regions</label>
                        <select class="form-select form-select-sm" id="regionSelector" name="region"
                            aria-label="Example select with button addon">

                            @foreach ($regions as $slug => $region)
                                <option value="{{ $slug }}" > {{ $region }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3 pt-4 mt-2">
                       <button class="btn btn-primary btn-sm" onclick="getInstances()">Get Servers</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-12">

                <table class="table table-success table-striped " id="instancesTable">
                    <thead>
                      <tr>
                        <th scope="col">ID of instance</th>
                        <th scope="col">label</th>
                        <th scope="col">IP</th>
                        <th scope="col">Region</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>

            </div>

        </div>

    </div>


@endSection


@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function getInstances(){

    const request = {
        account : document.querySelector("#accountSelector").value ,
        region  : document.querySelector("#regionSelector").value
    }
    
    

    $.post( '/cloudapi/instances' , request , (data) => {
        console.log( data )
//         $.each( data , (k , v) => {
//             $("#instancesTable > tbody").append(
// `
//         <tr>
//                         <th scope="row">${v.id}</th>
//                         <td>${v.label}</td>
//                         <td>${v.main_ip}</td>
//                         <td>${v.region}</td>
//                       </tr>
//                      `
//             )
//         } )
    } ) 
}

</script>

@endSection
