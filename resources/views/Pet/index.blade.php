@extends('layouts.app')
 
@section('title', 'Index')
 
@section('sidebar')
    @parent
 
    <h3 class="text-primary text-center">Index View</h3>
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
<div class='m-3'>
    <a class='btn btn-info btn-sm' href="{{ route('pets.create') }}">&#x2795; Add new Pet</a>
</div>
<div class="container mt-5">
    <div class="row">
        @foreach ($pets as $pet)
        <div class="col-sm">
            <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ $pet['name'] ?? '' }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $pet['status'] ?? '' }}</p>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm">
                        <a href="{{ route('pets.show', $pet['id']) }}" class="btn btn-warning btn-sm">Show</a>
                    </div>
                    <div class="col-sm">
                        <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-primary btn-sm">Edit</a>
                    </div>
                    <div class="col-sm">
                        <form action="{{ route('pets.delete', $pet['id']) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection