@extends('layouts.main')


@section('content')


    <div class="row mt-5">

        <div class="col-md-10 offset-1">

            <a href="{{ url('/register') }}" class="btn btn-primary btn-sm float-end mt-3">add user</a>
            <h1 class="text-center"> User Management </h1>

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
                        <th scope="col">Reference User</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        @if (in_array(Auth::user()->role, ['leader', 'admin']))
                            <th scope="col">Actions</th>
                        @endif

                        @if (in_array(Auth::user()->role, ['admin']))
                            <th scope="col"> Delete</th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @foreach ($usersOfCurrentEntity as $user)


                        <tr>
                            <th scope="row">{{ $user->ref_user }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }} </td>
                            <td>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckCheckedDisabled" @if ($user->is_active) checked @endif
                                        disabled>
                                </div>

                            </td>
                            @if (in_array(Auth::user()->role, ['leader', 'admin']))
                                <td>
                                    @if (Auth::user()->role == 'admin')
                                        <button type="button" class="btn btn-primary btn-sm" 
                                            data-id="{{ $user->id_user }}" data-name="{{ $user->name }}" data-role="{{$user->role}}"
                                            onclick="btnShowModal(this)">
                                            Update Role </button>
                                    @endif
                                    @if (!in_array($user->role, ['leader', 'admin']))
                                        @if ($user->is_active)
                                            <a href="{{ url('/users/desactivate/' . $user->id_user) }}"
                                                class="btn btn-primary btn-sm">desactive</a>
                                        @else
                                            <a href="{{ url('/users/activate/' . $user->id_user) }}"
                                                class="btn btn-primary btn-sm">active</a>

                                        @endif
                                    @endif

                                    <a href="{{ url('/users/reset/password/' . $user->id_user) }}"
                                        class="btn btn-primary btn-sm">Reset password</a>

                                </td>
                                @if (in_array(Auth::user()->role, ['admin']))
                                    <td>
                                        <a href="{{ url('/users/activate/' . $user->id_user) }}"
                                            class="btn btn-primary btn-sm close">&times;</a>
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
    <!-- Modal -->
    <form action="{{ route('updateuser') }}" method="post">
        @csrf
        <div class="modal fade" id="changer_rool_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update user role</h5>
                    </div>
                    <div class="modal-body">


                        <input type="hidden" id="hidden_user_id" name="id_user" >

                        <div class="mb-3">
                            <label for="name_user_id" class="form-label"> name</label>
                            <input type="text" class="form-control form-control-sm form-controld-readonly " readonly
                                id="name_user_id" placeholder="user name">
                        </div>

                        <div class="mb-3">
                            <label for="role_user_id" class="form-label">role</label>
                            <select class="form-select form-select-sm " id="role_user_id" name="role">
                                <option value="agent">Agent</option>
                                <option value="leader">Leader</option>
                            </select>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="myModal.hide()">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save User</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endSection


@section('js')
    <script>
        // var modalToggle = document.getElementById('changer_rool_user') // relatedTarget

        // var myModal = new bootstrap.Modal(document.getElementById('changer_rool_user'), {
        //   keyboard: false
        // })

        let myModal;


        window.onload = function() {
            myModal = new bootstrap.Modal(document.getElementById('changer_rool_user'), {
                keyboard: false
            })
        }


        function btnShowModal(element) {


            console.log( element.dataset )
            document.querySelector('#hidden_user_id').value=element.dataset.id
            document.querySelector('#name_user_id').value=element.dataset.name
            document.querySelector('#role_user_id').value=element.dataset.role
            // name_user_id
            // role_user_id


            // console.log("show modal")
            myModal.show()
        }

    </script>

@endSection
