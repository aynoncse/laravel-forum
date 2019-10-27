@extends('layouts.app')

@section('content')

<div class="card">
	@include('partials.discussion-header')

	<div class="card-body">
		<div class="text-center">
			<strong>
				{{$discussion->title}}
			</strong>
		</div>

		<hr>

		{!!$discussion->content!!}

		@if ($discussion->bestReply)
		<div class="card bg-success text-white">
			@if ($discussion->bestReply)
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<div>
						<img src="{{Gravatar::src($discussion->bestReply->owner->email)}}" height="40" width="40" class="rounded-circle mr-2" alt="">
						<strong class="text-light">{{$discussion->bestReply->owner->name}}</strong>
					</div>
					<div>
						<strong class="text-light text-uppercase">Best Reply</strong>
					</div>
				</div>
			</div>
			<div class="card-body">
				{!!$discussion->bestReply->content!!}
			</div>
			@endif
		</div>
		@endif
	</div>
</div>

@foreach ($discussion->replies()->paginate(3) as $reply)
<div class="card my-5">
	<div class="card-header">
		<div class="d-flex justify-content-between">
			<div>
				<img src="{{Gravatar::src($reply->owner->email)}}" height="40" width="40" class="rounded-circle" alt="">
				<strong class="text-primary">{{$reply->owner->name}}</strong>
			</div>
			<div>
				@auth
				@if (auth()->user()->id == $discussion->user_id)
				<form action="{{ route('discussions.best-reply', ['discussion'=>$discussion->slug, 'reply'=>$reply->id]) }}" method="POST">
					@csrf
					<button type="submit" class="btn btn-primary bnt-sm">Mark as best reply</button>
				</form>
				@endif					
				@endauth
			</div>
		</div>
	</div>
	<div class="card-body">
		{!!$reply->content!!}
	</div>
</div>
@endforeach

{{$discussion->replies()->paginate(3)->links()}}

<div class="card my-5">
	<div class="card-header">
		Add Reply
	</div>
	<div class="card-body">
		@auth
		<form action="{{route('replies.store', $discussion->slug)}}" method="POST">
			@csrf
			<div class="form-group">
				<input id="content" value="{{isset($post)?$post->content:''}}" type="hidden" name="content">
				<trix-editor input="content"></trix-editor>
			</div>
			<button type="submit" class="btn btn-success btn-sm">Add Reply</button>
		</form>
		@else
		<a href="{{route('login')}}" class="btn btn-info text-white">Sign in to add a reply</a>
		@endauth
	</div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/trix.css') }}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('public/js/trix.js') }}"></script>
@endsection