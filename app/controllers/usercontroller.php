<?php
	class UserController extends BaseController {
	    public static function login() {
	    	View::make("user/login.html");
	    }

	    public static function handle_login() {
	    	$params = $_POST;

	    	$user = User::authenticate($params["username"], $params["password"]);

	    	if (!$user) {
	    		View::make("user/login.html", array("error" => "Invalid username or password"));
	    	} else {
	    		$_SESSION["user"] = $user->id;

	    		Redirect::to("/", array("message" => "Welcome back " . $user->username . "!"));
	    	}
	    }
	}