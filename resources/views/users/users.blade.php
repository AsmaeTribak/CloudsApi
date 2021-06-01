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
                                        <button class="btn btn-primary btn-sm">Update Role</button>
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


@endSection
