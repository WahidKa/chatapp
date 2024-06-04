@extends('layouts.app')

@section('content')
<div class="container-fluid h-100 d-flex flex-column">
    <div class="row flex-grow-1 justify-content-center">
        <div class="col-md-8 d-flex flex-column h-100">
            <div class="flex-grow-1 overflow-auto" id="messageContainer">
                <h1 class="text-center">{{ $chatRoom->name }}</h1>
                <a href="{{ route('chat.addParticipantsForm', $chatRoom->roomID) }}" class="btn btn-secondary mb-3">Add Participants</a>
                <ul id="messages" class="list-unstyled">
                    @foreach($messages as $message)
                    <li class="mb-2">
                        <div class="d-flex flex-column @if($message->user->id == Auth::id()) align-items-end @else align-items-start @endif">
                            <div class="px-3 py-2 @if($message->user->id == Auth::id()) bg-primary text-white @else bg-secondary text-white @endif" style="max-width: 60%; border-radius: 20px;">
                                <strong>{{ $message->user->displayName }}:</strong> {{ $message->content }}
                                @if($message->file_path)
                                    <br>
                                    <a href="{{ Storage::url($message->file_path) }}" target="_blank" class="text-white">View File</a>
                                @endif
                            </div>
                            <div class="small text-muted" style="font-size: 0.8rem;">{{ $message->created_at->format('Y-m-d H:i:s') }}</div> <!-- Full date and time -->
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group" id="messageForm">
                <form action="{{ route('chat.sendMessage', $chatRoom->roomID) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column">
                    @csrf
                    <div class="input-group mb-2">
                        <textarea name="content" rows="1" class="form-control" placeholder="Type your message..." style="resize: none;"></textarea>
                    </div>
                    <div class="input-group mb-2">
                        <input type="file" name="file" class="form-control mt-2">
                    </div>
                    <div class="input-group">
                        <button type="submit" class="btn btn-primary w-100">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .container-fluid {
        padding: 0;
        height: 100vh;
    }

    .row {
        height: 100%;
        margin: 0;
    }

    .col-md-8 {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    #messageContainer {
        flex-grow: 1;
        overflow-y: auto;
        margin-bottom: 70px; /* Adjust this based on the height of the form */
    }

    #messageForm {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        padding: 10px;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }

    .input-group textarea {
        resize: none;
        border-radius: 0;
    }

    .input-group input[type="file"] {
        border-radius: 0;
    }

    .input-group .btn {
        border-radius: 0;
        
    }

    .input-group {
        margin-bottom: 10px;
    }
</style>
@endsection