@extends('layouts.main')
@section('content')

    
       
    <table class="table table-bordered border-primary mt-5">
        <thead>
            <tr>
                <th scope="col">Account name</th>
                <th scope="col">Account proxy</th>
                <th scope="col"> provider name</th>
                <th scope="col"> sshkey</th>



            </tr>
        </thead>
        <tbody>

            @foreach ($accounts as $account)
            <tr>
                <td> {{ $account->name }}</td>
                <td>  @if ($account->proxy == null)
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"  fill="red" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                      </svg>
                    @else 
                    {{ $account->proxy }}
                    @endif
                </td>
                <td> 
                    
                    {{$account->provider->name}}
                </td>
                <td> 

                @if ($account->sshkey == null)
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"  fill="red" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                  </svg>
              
                @else 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </svg>
            @endif
        </td>

            </tr>
        @endforeach
    </table>

<!-- Modal -->
<form action="{{ route('addaccount')}} " method="Post">
    @csrf

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <label for='name_of_entity' class="form-label"> name</label>
        <input type='text'  class="form-control form-control-sm" name ="name" placeholder="account name">
        <label for='reference_of_entity'class="form-label">proxy</label>
        <input type='text'class="form-control form-control-sm " name ='proxy' placeholder="proxy">
       

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm"> Save </button>
        </div>
      </div>
    </div>
  </div>
</form>
    </tbody>
@endSection

 

@section('js')
    <script>


        let myModal;

        function btnShowModal(element) {


            // console.log( element.dataset )

            document.querySelector('#account_name_input').value=element.dataset.name
            document.querySelector('#account_proxy_input').value=element.dataset.ref

            myModal.show()
        }

    </script>

@endSection
                



   

