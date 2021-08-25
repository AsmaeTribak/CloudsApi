@extends('layouts.main')
@section('content')

    <div class="row mt-5">

        <div class="col-md-10 offset-1">





            <ul class="list-group">
                @foreach ($providers as $provider)

                    <li class="list-group-item"><a href="{{ url("/accounts/$provider->id_provider") }}">
                            {{ $provider->name }} </a>
                    </li>

                    @endforeach
            </ul>
        </div>
    </div>
@endSection
