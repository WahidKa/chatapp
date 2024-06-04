@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Create New Chat Room</h1>
            <form action="{{ route('chat.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Chat Room Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection