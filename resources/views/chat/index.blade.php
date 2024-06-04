@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Chat Rooms</h1>
            <a href="{{ route('chat.create') }}" class="btn btn-primary mb-3">Create New Chat Room</a>
            <div class="list-group">
                @foreach($chatRooms as $room)
                <a href="{{ route('chat.show', $room->roomID) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $room->name }}</h5>
                        @if($room->messages->count())
                        <small>{{ $room->messages->first()->created_at->diffForHumans() }}</small>
                        @endif
                    </div>
                    <p class="mb-1">
                        @if($room->messages->count())
                        <strong>{{ $room->messages->first()->user->displayName }}:</strong> 
                        {{ Str::limit($room->messages->first()->content, 50) }}
                        @else
                        No messages yet.
                        @endif
                    </p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection