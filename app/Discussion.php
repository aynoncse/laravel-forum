<?php

namespace LaravelForum;
use LaravelForum\Notifications\ReplyMarkedAsBestReply;

class Discussion extends Model
{
	public function author(){
		return $this->belongsTo(User::class, 'user_id');
	}

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
    	return 'slug';
    }

    // public function getBestReply()
    // {
    // 	return Reply::find($this->reply_id);
    // }

    public function bestReply()
    {
    	return $this->belongsTo(Reply::class, 'reply_id');
    }

    public function scopeFilterByChannels($builder){
        if (request()->query('channel')) {            
            // filter
            $channel = Channel::where('slug', request()->query('channel'))->first();

            if ($channel) {
                return $builder->where('channel_id', $channel->id);
            }
        }

        return $builder;
    }

    public function replies(){
    	return $this->hasMany(Reply::class);
    }
    public function markAsBestReply(Reply $reply){
    	$this->update([
    		'reply_id' => $reply->id
    	]);

        if ($reply->owner->id != $this->author->id) {
            $reply->owner->notify(new ReplyMarkedAsBestReply($reply->discussion));
        }
    }
}
