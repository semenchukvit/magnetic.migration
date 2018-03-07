@extends('layouts.layout')

@section('navbar')
    @include('site.navbar')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="{{ route('migrate.show') }}">Migrate data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection