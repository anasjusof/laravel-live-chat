@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper">
                
                @foreach($users as $user)
                <ul class="user" id="{{ $user->id }}">
                    <span class="pending">1</span>

                    <div class="media">
                        <div class="media-left">
                            <img src="{{ $user->avatar }}" alt="" class="media-object">
                        </div>

                        <div class="media-body">
                            <p class="name">{{ $user->name }}</p>
                            <p class="email">{{ $user->email }}</p>
                        </div>
                    </div>
                </ul>
                @endforeach
                
            </div>
        </div>

        <div class="col-md-8" id="messages">
            
        </div>

        
    </div>
</div>
@endsection
