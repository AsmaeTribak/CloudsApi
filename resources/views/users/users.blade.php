@if (Session::has('success'))
    <script type="text/javascript">
        swal({
            title: 'Success!',
            text: "{{ Session::get('success') }}",
            timer: 5000,
            type: 'success'
        }).then((value) => {
            //location.reload();
        }).catch(swal.noop);

    </script>
@endif





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
                        <th scope="col">is Activate</th>
                        @if (in_array(Auth::user()->role, ['leader', 'admin']))
                            <th scope="col">Actions</th>
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
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckCheckedDisabled" @if ($user->email_verified_at != null) checked @endif disabled>
                                </div>

                            </td>
                            @if (in_array(Auth::user()->role, ['leader', 'admin']))
                                <td>
                                    @if (Auth::user()->role == 'admin')
                                        <button class="btn btn-primary btn-sm">Update Role</button>
                                    @endif
                                    <button class="btn btn-primary btn-sm">desactive User</button>
                                    <a href="{{ url('/users/reset/password/' . $user->id_user) }}"
                                        class="btn btn-primary btn-sm">Reset password</a>

                                </td>
                            @endif
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>


@endSection
