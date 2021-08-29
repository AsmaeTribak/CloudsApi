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
                                <option value="{{$accout->id}}" > {{ $account->name }} </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-4">

                        <label for="formGroupExampleInput" class="form-label">Regions</label>
                        <select class="form-select form-select-sm" id="regionSelector" name="region"
                            aria-label="Example select with button addon">

                            @foreach ($regions as $region)
                                <option> {{ $region }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3 pt-4 mt-2">
                       <button class="btn btn-primary btn-sm" onclick="getInstances()">Get Servers</button>
                    </div>

                </div>
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
    } ) 
}

</script>

@endSection
