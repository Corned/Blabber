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

	    public static function profile($username) {
			self::check_logged_in();
			
			if ($username == null) {
				// to own profile if logged in
				if (parent::get_user_logged_in()) {
					$username = parent::get_user_logged_in()->username;
					Redirect::to("/profile/" . $username);
				} else {
					Redirect::to("/login");
				}
			}

			$user = User::find_by_username($username);
			$blabs = Blab::find_by_accountid($user->id);

			View::make("user/profile.html", array("user" => $user, "blabs" => $blabs));
	    }

	    public static function favourites($username) {
			self::check_logged_in();
			
	    	$user = User::find_by_username($username);
	    	if ($user == null) {
	    		Redirect::to("/", array("error" => "User not found..?"));
	    	}

	    	$blabs = Blab::find_favourites_by_accountid($user->id);
	    	View::make("user/favourites.html", array("user" => $user, "blabs" => $blabs));
	    }
	}