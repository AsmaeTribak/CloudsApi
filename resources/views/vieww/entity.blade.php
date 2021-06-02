@extends('layouts.main')


@section('content')

<div class="row mt-5">

    <div class="col-md-10 offset-1">

        <button class="btn btn-primary btn-sm float-end mt-3"   data-bs-toggle="modal" data-bs-target="#exampleModal" >add Entity</button>
        <h1 class="text-center"> Entity Management </h1>
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
                    <th scope="col">Reference Entity</th>
                    <th scope="col">Entity name</th>
                    <th scope="col">Entity id </th>
                    <th scope="col"> actions</th>

                </tr>
            </thead>
            <tbody>

                    @foreach ($entities as $entity)


                        <tr>
                            <th scope="row">{{ $entity->ref_entity }}</th>
                            <td>{{ $entity->name }}</td>
                            <td>{{ $entity->id_entity }}</td>
                            <td> <button class="btn btn-primary btn-sm"
                                data-id="{{ $entity->id_entity }}"
                                data-ref="{{ $entity->ref_entity }}"
                                data-name="{{ $entity->name }}"
                                onclick="btnShowModal(this)">update entity</button>                            </td>

                            
                        
                        </tr>
                    @endforeach

                </tbody>
        </table>
        

<!-- Modal -->
<form action="{{ route('addentity')}} " method="Post">
    @csrf

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Entity</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <label for='name_of_entity' class="form-label"> name</label>
        <input type='text'  class="form-control form-control-sm" name ="name" placeholder="entity name">
        <label for='reference_of_entity'class="form-label">Reference</label>
        <input type='text'class="form-control form-control-sm " name ='ref_entity' placeholder="reference ">
       

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</form>
<form action="{{ route('updateentity')}}" method="POST">
    @csrf

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Entity</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        
        <div class="modal-body">

        <input type='hidden'class="form-control form-control-sm " id="entity_id_input" name ='id_entity'>
        <label for='entity_name_input' class="form-label"> name</label>
        <input type='text'  class="form-control form-control-sm" id="entity_name_input" name ="name" placeholder="entity name">
        <label for='entity_ref_input'class="form-label">Reference</label>
        <input type='text'class="form-control form-control-sm " id="entity_ref_input" name ='ref_entity' placeholder="entity reference ">

        

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</form>

@endSection


@section('js')
    <script>


        let myModal;


        window.onload = function() {
            myModal = new bootstrap.Modal(document.getElementById('updateModal'), {
                keyboard: false
            })
        }


        function btnShowModal(element) {


            // console.log( element.dataset )

            document.querySelector('#entity_id_input').value=element.dataset.id
            document.querySelector('#entity_name_input').value=element.dataset.name
            document.querySelector('#entity_ref_input').value=element.dataset.ref

            myModal.show()
        }

    </script>

@endSection
                


