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
                    <div class="col-3 pt-4 mt-2">

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="addInstances()">
                        add instances
                      </button>
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
                        <th scope="col">Server name</th>
                        <th scope="col">IP</th>
                        <th scope="col">Region</th>
                        <th scope="col">Domain</th>
                        <th scope="col">Actions</th>

                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>

            </div>

        </div>

    </div>
    <form action="{{ route('addinstance')}}" method="Post">
        @csrf
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Instance</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
                    <div class="modal-body">
                    <label for='name_of_instance'class="form-label">Name</label>
                   <input type='text'class="form-control form-control-sm " name ='instance_name' placeholder="instance name ">
                   <label for='number_of_instance'class="form-label">number</label>
                   <input type='text'class="form-control form-control-sm " name ='instance_number' placeholder="instance number ">
                   <label for='domaine_of_instance'class="form-label">domain</label>
                   <input type='text'class="form-control form-control-sm " name ='instance_domain' placeholder="instance domain ">
       
                    </div>

                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-sm"> Save </button>
            </div>
          </div>
        </div>
      </div>
    </form>
    




@endSection


@section('js')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@php echo "<script> const regions = ".  json_encode($regions)."</script>"; @endphp
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
    
    

    $.post( '/cloudapi/instances' , request , (response) => {
        console.log( response )
        $("#instancesTable > tbody").empty();
        $.each( response.data , (k , instance) => { 

            const btn_delete=`<button 
                                    class="btn btn-danger btn-sm" 
                                    onclick="deleteInstance(this)" 
                                    data-id="${instance.id}"
                                    data-account="${instance.accountId}"> 
                                  <i class="bi bi-trash-fill"></i>
                              </button>`
            const btn_install=`<button 
                                    class="btn btn-primary btn-sm" 
                                    onclick="installInstance(this)"
                                    data-id="${instance.id}"
                                    data-mainip="${instance.mainIp}"
                                    data-name="${instance.name}"
                                    data-account="${instance.accountId}"
                                    data-domain="${instance.domaine == null ? '':instance.domaine}">
                                  <i class="bi bi-save-fill"></i> 
                                </button>`

            $("#instancesTable > tbody").append(
`
        <tr>
                        <th scope="row">aa</th>
                        <td>${instance.name}</td>
                        <td>${instance.mainIp}</td>
                        <td>${regions[instance.region]}</td>
                        <td>${instance.domaine}</td>
                        <td> ${btn_install} ${btn_delete}</td>
                    
                      </tr>
                     `


            )
        } )
    } ) ;
}

function deleteInstance(currentElement){
    // console.log(currentElement)

    // console.log(currentElement.dataset)
    // const instanceId = currentElement.dataset.id;

    let request = {
        account_id : currentElement.dataset.account ,
        id :  currentElement.dataset.id
    }

    console.log( request )

    $.post( '/cloudapi/instances/delete' , request , (response) => {
            console.log(response)
    } );

}
function installInstance(currentElement){
    
    let request = {
        account_id : currentElement.dataset.account ,
        id :  currentElement.dataset.id,
        mainip : currentElement.dataset.mainip,
        name : currentElement.dataset.name,
        domain : currentElement.dataset.domain

    }

    console.log( request )

    $.post( '/cloudapi/instances/install' , request , (response) => {
            console.log(response)
    } );


   
}
</script>
    
@endSection
