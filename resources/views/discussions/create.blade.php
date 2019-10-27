@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Dashboard</div>

    <div class="card-body">
        <form action="{{route('discussions.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <input id="content" value="{{isset($post)?$post->content:''}}" type="hidden" name="content">
                <trix-editor input="content"></trix-editor>
            </div>

            <div class="form-group">
                <label for="channel">Channel</label>
                <select name="channel" id="channel" class="form-control">
                    <option disabled selected hidden>Click to pick</option>
                    option
                    @foreach($channels as $channel)
                    <option value="{{$channel->id}}">{{$channel->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Create Discusssion</button>
        </form>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/trix.css') }}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('public/js/trix.js') }}"></script>
@endsection