@extends('layouts.app')
 
@section('title', 'Show')
 
@section('sidebar')
    @parent
    <div class='m-3'>
        <a class='btn btn-info btn-sm' href="{{ route('pets.index') }}">&#x21b6; Back</a>
    </div>
    <h3 class="text-primary text-center">Show Pet #{{ $id }}</h3>
@endsection
 
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<label for='name'>Name: </label>
<input id='name' type='text' value="{{ $pet['name'] ?? '' }}" disabled>
<label for='status'>Status: </label>
<input id='status' type='text' value="{{ $pet['status'] ?? '' }}" disabled>
@endsection