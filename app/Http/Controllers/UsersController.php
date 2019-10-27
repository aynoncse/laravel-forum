<?php

namespace LaravelForum\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function notifications($value='')
    {
    	// Mark all as read

    	auth()->user()->unreadNotifications->markAsRead();

    	// Display all notifications

    	//dd(auth()->user()->notifications->first()->data['discussion']['slug']);

    	return view('users.notifications', [
    		'notifications' => auth()->user()->notifications()->paginate(5)
    	]);
    }
}
