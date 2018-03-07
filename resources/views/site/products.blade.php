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
            @foreach($products as $product)
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->body_html }}</td>
                    <td>{{ $product->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('collections.show') }}">back</a>
@endsection