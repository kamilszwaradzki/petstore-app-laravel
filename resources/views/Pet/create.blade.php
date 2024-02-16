@extends('layouts.app')

@section('title', 'Create')

@section('sidebar')
    @parent
    <div class='m-3'>
        <a class='btn btn-info btn-sm' href="{{ route('pets.index') }}">&#x21b6; Back</a>
    </div>
    <h3 class="text-primary text-center">Create Pet</h3>
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
@if (session('successful'))
    <div class="alert alert-success">{{ session('successful') }}</div>
@endif
<form method="POST" action="{{ route('pets.store') }}">
    @csrf
<label for="name">Name</label>

<input name="name"
    type="text"
    class="@error('name') is-invalid @enderror"
    value="{{ old('name') }}">

@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<label for="status">Status</label>

<input name="status"
    type="text"
    class="@error('status') is-invalid @enderror"
    value="{{ old('status') }}">

@error('status')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<input type='submit' value="Send">
</form>
@endsection