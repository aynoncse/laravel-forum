<div class="card-header">
	<div class="d-flex justify-content-between">
		<div>
			<img src="{{Gravatar::src($discussion->author->email)}}" height="40" width="40" class="rounded-circle" alt="">
			<strong class="text-secondary">{{$discussion->author->name}}</strong>
		</div>
		<div>
			<a href="{{route('discussions.show', $discussion->slug)}}" class="btn btn-sm btn-success">View</a>
		</div>
	</div>
</div>