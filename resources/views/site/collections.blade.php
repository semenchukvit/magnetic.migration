@extends('layouts.layout')

@section('navbar')
    @include('site.navbar')
@endsection

@section('content')
    <table class="table table-bordered">
        <thead>
        <tr>
            @foreach($columns as $column)
                <th scope="col">{{ $column }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
            @foreach($collections as $collection)
                <tr>
                    <th scope="row">{{ $collection->id }}</th>
                    <td><a href="{{ route('products.show', ['id' => $collection->id]) }}">{{ $collection->title }}</a></td>
                    <td>{{ $collection->body_html }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection