@extends('layouts.main')
@section('content')

    
       
    <table class="table table-bordered border-primary mt-5">
        <thead>
            <tr>
                <th scope="col">Account id </th>
                <th scope="col">Account name</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($accounts as $accounts)
            <tr>
                <td> {{ $accounts->id_accountsz }}</td>
                <td> {{ $accounts->name }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
@endSection

 


   

