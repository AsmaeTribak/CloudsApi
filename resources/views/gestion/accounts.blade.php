@extends('layouts.main')
@section('content')

    <div class="row mt-5">

        <div class="col-md-10 offset-1">

            <button class="btn btn-primary btn-sm float-end mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">add
                account</button>
            <h1 class="text-center"> Account Management Of {{ ucwords(strtolower($provider->name )) }} </h1>

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
                <caption> table of accounts </caption>
                <thead>
                    <tr>
                        <th scope="col">Account name</th>
                        <th scope="col">Account proxy</th>

                        @switch($provider->type)

                            @case('1key')
                                <th scope="col">First key</th>
                            @break

                            @case('2key')
                                <th scope="col">First key</th>
                                <th scope="col">Second key</th>
                            @break

                            @case('4key')
                                <th scope="col">First key</th>
                                <th scope="col">Second key</th>
                                <th scope="col">thierd key</th>
                                <th scope="col">Four key</th>
                    
                            @break

                        @endswitch

                        <th scope="col"> provider name</th>
                        <th scope="col"> sshkey</th>
                        <th scope="col"> delete</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($accounts as $account)
                        <tr>
                            <td> {{ $account->name }}</td>
                            <td>
                                @if ($account->proxy == null)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red"
                                        class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                                    </svg>
                                @else
                                    {{ $account->proxy }}
                                @endif
                            </td>

                            @switch($provider->type)

                                @case('1key')
                                    <td> {{ $account->getAuth()->first_key }}</td>
                                @break

                                @case('2key')
                                    <td> {{ $account->getAuth()->first_key }}</td>
                                    <td> {{ $account->getAuth()->second_key }}</td>
                                @break

                                @case('4key')
                                    <td> {{ $account->getAuth()->first_key }}</td>
                                    <td> {{ $account->getAuth()->second_key }}</td>
                                    <td> {{ $account->getAuth()->third_key }}</td>
                                    <td> {{ $account->getAuth()->fourth_key }}</td>
                                @break

                            @endswitch


                            <td>

                                {{ $account->provider->name }}
                            </td>
                            <td>

                                @if ($account->sshkey == null)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red"
                                        class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                                    </svg>

                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green"
                                        class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/accounts/delete/' . $account->id_account) }}"
                                    class="btn btn-danger btn-sm close">
                                    <i class="bi bi-trash-fill"></i></a>
                            </td>

                        </tr>
                    @endforeach
            </table>

            <!-- Modal -->
            <form action="{{ url("/accounts/$provider->id_provider") }}" method="Post">
                @csrf

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for='name_of_account' class="form-label"> name</label>
                                <input type='text' class="form-control form-control-sm" name="name"
                                    placeholder=" account name">
                                <label for='proxy_of_account' class="form-label">proxy</label>
                                <input type='text' class="form-control form-control-sm " name='proxy' placeholder="proxy ">

                                @switch($provider->type)
                                    @case('1key')

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label for='keys_of_account' class="form-label">First key</label>
                                                <input type="text" class="form-control form-control-sm" name="keys[firstKey]" placeholder="1th key" >
                                            </div>
                                        </div>

                                        @break

                                    @case('2key')

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label for='keys_of_account' class="form-label">First key</label>
                                                <input type="text" class="form-control form-control-sm" name="keys[firstKey]" placeholder="1th key" >
                                            </div>
                                            <div class="col-6">
                                                <label for='keys_of_account' class="form-label">Second key</label>
                                                <input type="text" class="form-control form-control-sm" name="keys[secondKey]" placeholder="2ed key" >
                                            </div>
                                        </div>

                                        @break

                                    @case('4key')

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label for='keys_of_account' class="form-label">First key</label>
                                                <input type="text" class="form-control form-control-sm" name="keys[firstKey]" placeholder="1th key" >
                                            </div>
                                            <div class="col-6">
                                                <label for='keys_of_account' class="form-label">Second key</label>
                                                <input type="text" class="form-control form-control-sm" name="keys[secondKey]" placeholder="2ed key" >
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label for='keys_of_account' class="form-label">Thread key</label>
                                                <input type="text" class="form-control form-control-sm" name="keys[threadKey]" placeholder="3th key">
                                            </div>
                                            <div class="col-6">
                                                <label for='keys_of_account' class="form-label">Fourth key</label>
                                                <input type="text" class="form-control form-control-sm"  name="keys[fourthKey]" placeholder="4th key" >
                                            </div>
                                        </div>

                                        @break

                                @endswitch
                                                            




                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm"> Save </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </tbody>
        @endSection

