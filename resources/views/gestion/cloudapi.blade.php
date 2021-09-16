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
                                <option value="{{ $account->id_account }}"> {{ $account->name }} </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-4">

                        <label for="formGroupExampleInput" class="form-label">Regions</label>
                        <select class="form-select form-select-sm" id="regionSelector" name="region"
                            aria-label="Example select with button addon">

                            @foreach ($regions as $slug => $region)
                                <option value="{{ $slug }}"> {{ $region }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3 pt-4 mt-2">
                        <button class="btn btn-primary btn-sm" onclick="getInstances()">Get Servers</button>
                    </div>



                </div>
            </div>

            <div class="col-6 mt-2 ">

                <button type="button" class="btn btn-primary btn-sm mt-4 float-end" data-bs-toggle="modal"
                    data-bs-target="#exampleModal" onclick="addInstances()">
                    add instances
                </button>
            </div>

        </div>

        <div class="row mt-5">

            <div class="col-12">
                <form id="multiple_instance">
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

                            <tr>
                                <th scope="col"> <input class="form-check-input" onchange="selectAll(this)" type="checkbox">
                                </th>
                                <th scope="col"> <button type="button" class="btn btn-primary btn-sm"
                                        onclick="installMultiple()"> Install </button> </th>
                                <th scope="col" colspan="5"> <button type="button" class="btn btn-danger btn-sm"
                                        onclick="deleteMultiple()">Delete</button> </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </form>
            </div>

        </div>

    </div>
    <form action="{{ route('addinstance') }}" method="Post">
        @csrf

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Instance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-6">
                                <label for="formGroupExampleInput" class="form-label">Accounts</label>
                                <select class="form-select form-select-sm" id="accountSelector" name="account"
                                    aria-label="Example select with button addon">

                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id_account }}"> {{ $account->name }} </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-6">

                                <label for="formGroupExampleInput" class="form-label">Regions</label>
                                <select class="form-select form-select-sm" id="regionSelector" name="region"
                                    aria-label="Example select with button addon">

                                    @foreach ($regions as $slug => $region)
                                        <option value="{{ $slug }}"> {{ $region }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label for='name_of_instance' class="form-label">Name</label>
                                <input type='text' class="form-control form-control-sm " name='instance_name'
                                    placeholder="instance name ">
                            </div>
                            <div class="col-6">
                                <label for='number_of_instance' class="form-label">Number</label>
                                <input type='text' class="form-control form-control-sm " name='instance_number'
                                    placeholder="instance number ">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for='domaine_of_instance' class="form-label">Domain</label>
                                <input type='text' class="form-control form-control-sm " name='instance_domain'
                                    placeholder="instance domain ">
                            </div>

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
    @php
    echo "
        <script>
            const regions = ".  json_encode($regions)."
        </script>";
    @endphp
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        function getInstances() {

            const request = {
                account: document.querySelector("#accountSelector").value,
                region: document.querySelector("#regionSelector").value
            }



            $.post('/cloudapi/instances', request, (response) => {
                console.log(response)
                $("#instancesTable > tbody").empty();
                $.each(response.data, (k, instance) => {

                    const checkBoxInstance = `<input 
                class="form-check-input" 
                name="instances" type="checkbox"
                value="${instance.id}_${instance.mainIp}_${instance.name}_${instance.accountId
                    }_${instance.domaine == null ? '':instance.domaine}_${instance.is_installed}">`

                    const btn_delete = `<button 
                                        type="button"
                                    class="btn btn-danger btn-sm" 
                                    onclick="deleteInstance(this)" 
                                    data-id="${instance.id}"
                                    data-account="${instance.accountId}"> 
                                  <i class="bi bi-trash-fill"></i>
                              </button>`
                    const btn_install = (instance.is_installed == 0) ? `<button
                                    type="button" 
                                    class="btn btn-primary btn-sm" 
                                    onclick="installInstance(this)"
                                    data-id="${instance.id}"
                                    data-mainip="${instance.mainIp}"
                                    data-name="${instance.name}"
                                    data-account="${instance.accountId}"
                                    data-domain="${instance.domaine == null ? '':instance.domaine}">
                                  <i class="bi bi-save-fill"></i> 
                                </button>` : `<i class="bi bi-check-circle-fill text-success"></i>`

                    $("#instancesTable > tbody").append(
                        `
        <tr>
                        <th scope="row">${checkBoxInstance}</th>
                        <td>${instance.name}</td>
                        <td>${instance.mainIp}</td>
                        <td>${regions[instance.region]}</td>
                        <td>${instance.domaine}</td>
                        <td> ${btn_install} ${btn_delete}</td>
                    
                      </tr>
                     `


                    )
                })
            });
        }

        function deleteInstance(currentElement) {

            deleteInstance( currentElement.dataset.account , currentElement.dataset.id );
            
        }

        function deleteInstance( account_id , instance_id ){
            
            let request = {
                account_id: account_id,
                id: instance_id
            }

            // console.log(request)

            $.post('/cloudapi/instances/delete', request, (response) => {
                console.log(response)
            });

        }


        function installInstance(currentElement) {

            sendInstallation(
                currentElement.dataset.account,
                currentElement.dataset.id,
                currentElement.dataset.mainip,
                currentElement.dataset.name,
                currentElement.dataset.domain);

        }

        function sendInstallation(account_id, instance_id, mainip, name, domain) {
            const request = {
                account_id: account_id,
                id: instance_id,
                mainip: mainip,
                name: name,
                domain: domain
            }

            console.log(request)

            $.post('/cloudapi/instances/install', request, (response) => {
                console.log(response)
            });

        }


        function selectAll(elemnt) {

            const table = document.querySelector("#instancesTable > tbody")

            $.each($(table).children(), (k, v) => {
                $(v).find('input[type="checkbox"]')[0].checked = elemnt.checked;
            })

        }

        async function installMultiple() {

            let form = $("#multiple_instance").serializeFormJSON();

            let instances = []

            if (typeof form.instances == "string") instances = [form.instances]
            else if (form.instances == undefined) instances = []
            else instances = form.instances

            let i = instances.length

            while (i-- > 0) {

                let instance = instances[i].split("_")

                if (instance[5] == "0") {

                    const instance_id = instance[0];
                    const mainip = instance[1];
                    const name = instance[2];
                    const account_id = instance[3];
                    const domain = instance[4];

                    sendInstallation(account_id, instance_id, mainip, name, domain)
                }

                await timeout(1000)
            }

        }


        async function deleteMultiple() {

            let form = $("#multiple_instance").serializeFormJSON();

            let instances = []

            if (typeof form.instances == "string") instances = [form.instances]
            else if (form.instances == undefined) instances = []
            else instances = form.instances

            let i = instances.length

            while (i-- > 0) {

                let instance = instances[i].split("_")

                const instance_id = instance[0];
                const account_id = instance[3];

                // console.log(instance)
                deleteInstance( account_id , instance_id );

                await timeout(1000)
            }

        }

        (function($) {
            $.fn.serializeFormJSON = function() {

                var o = {};
                var a = this.serializeArray();
                $.each(a, function() {
                    if (o[this.name]) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };
        })(jQuery);

        const timeout = millis => new Promise(resolve => setTimeout(resolve, millis))
    </script>

@endSection
