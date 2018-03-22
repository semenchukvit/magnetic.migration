@extends('layouts.layout')

@section('navbar')
    @include('site.navbar')
@endsection

@section('content')

    @if (session('message_success'))
        <div class="alert alert-success">
            {{ session('message_success') }}
        </div>
    @endif

    @if (session('message_danger'))
        <div class="alert alert-danger">
            {{ session('message_danger') }}
        </div>
    @endif

    <h3>Enter data for migration</h3>
    <form method="post" action="{{ route('migrate.create') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="login">Name of Store</label>
            <input type="text" class="form-control" id="login" name="login" value="{{old('login')}}" placeholder="">
        </div>
        <div class="form-group">
            <label for="key">API key</label>
            <input type="text" class="form-control" id="key" name="key" value="{{old('key')}}" placeholder="">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" placeholder="">
        </div>
        <button type="submit" class="btn btn-primary">Migrate</button>
    </form>
@endsection