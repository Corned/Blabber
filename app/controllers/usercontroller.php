<?php
	class UserController extends BaseController {
	    public static function login() {
	    	if (self::get_user_logged_in() !== null) {
	    		Redirect::to("/");
	    	}

	    	View::make("user/login.html");
	    }

		// Post - kirjaudu
	    public static function handle_login() {
	    	$params = $_POST;

	    	$user = User::authenticate($params["username"], $params["password"]);

	    	if (!$user) {
	    		View::make("user/login.html", array("type" => "login-error", "error" => "Invalid username or password."));
	    	} else {
	    		$_SESSION["user"] = $user->id;

	    		Redirect::to("/", array("message" => "Welcome back " . $user->username . "!"));
	    	}
	    }

		// Post - kirjaudu ulos
	    public static function logout() {
	    	$_SESSION["user"] = null;
	    	Redirect::to("/login");
	    }

		// Näytä profiili
	    public static function profile($username) {
			if ($username == null) {
				// to own profile if logged in
				if (parent::get_user_logged_in()) {
					$username = parent::get_user_logged_in()->username;
					Redirect::to("/profile/" . $username);
				} else {
					Redirect::to("/login", array("type" => "login-error", "error" => "Please log in to view your profile."));
				}
			}

			$user = User::find_by_username($username);
			$blabs = Blab::find_by_accountid($user->id);
			$followStatus;
			if (parent::get_user_logged_in() == null) {
				$followStatus = "log in";
			} else {
				$followStatus = User::is_following(parent::get_user_logged_in()->id, $user->id);
			}


			View::make("user/profile.html", array("user" => $user, "blabs" => $blabs, "follows" => $followStatus));
	    }

		// Näytä suosikit
	    public static function favourites($username) {
	    	$user = User::find_by_username($username);
	    	if ($user == null) {
	    		Redirect::to("/", array("error" => "User not found."));
	    	}

	    	$blabs = Blab::find_favourites_by_accountid($user->id);
	    	View::make("user/favourites.html", array("user" => $user, "blabs" => $blabs));
	    }

	    // Follow
	    public static function follow($username) {
			self::check_logged_in();

	    	$userToFollow = User::find_by_username($username);
	    	if ($userToFollow == null) {
	    		Redirect::to("/", array("error" => "User not found."));
	    	}

			$user = self::get_user_logged_in();
	    	$isFollowing = User::toggle_follow($user->id, $userToFollow->id);
	    	$message = "";
	    	if ($isFollowing == true) {
	    		$message = "You are now following " . $username . "!";
	    	} else {
	    		$message = "You are no longer following " . $username . ".";
	    	}

			$followStatus;
			if (parent::get_user_logged_in() == null) {
				$followStatus = "log in";
			} else {
				$followStatus = User::is_following(parent::get_user_logged_in()->id, $userToFollow->id);
			}

	    	Redirect::to("/profile/" . $username, array("message" => $message, "follows" => $followStatus));
	    }
	}
