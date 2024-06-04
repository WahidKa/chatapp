@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Add Participants to {{ $chatRoom->name }}</h1>
            <form action="{{ route('chat.addParticipants', $chatRoom->roomID) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="users">Select Users</label>
                    <select name="users[]" id="users" class="form-control" multiple>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->displayName ?? $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Add Participants</button>
            </form>
        </div>
    </div>
</div>
@endsection