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

	    // Post - Rekisteröidy
	    public static function handle_registration() {
	    	$params = $_POST;
	    	// check for username availability

	    	if (User::is_username_available($params["username"]) == false) {
	    		Redirect::to("/login", array("type" => "register-error", "error" => "Username already taken. :("));
	    	}

	    	$attributes = array(
	    		"username" => $params["username"],
	    		"password" => $params["password"]
	    	);

	    	$user = new User($attributes);
	    	$errs = $user->errors();

	    	if (count($errs) == 0) {
	    		// success
	    		$user->save();
	    		$_SESSION["user"] = $user->id;
	    		Redirect::to("/", array("message" => "Welcome to Blabber " . $user->username . "!"));
	    	}

	    	Redirect::to("/login", array("type" => "register-error", "error" => $errs));
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
			if ($user == null) {
				Redirect::to("/globalfeed", array("error" => "User not found."));
			}

			$blabs;
			$following;
			$followers;
			$favouriteBlabs;
			$followStatus;

 			$blabs = Blab::find_by_accountid($user->id);
			$following = User::get_following($user->id);
			$followers = User::get_followers($user->id);
			$favouriteBlabs = Blab::find_favourites_by_accountid($user->id);

			if (parent::get_user_logged_in() == null) {
				$followStatus = "log in";
			} else {
				$followStatus = User::is_following(parent::get_user_logged_in()->id, $user->id);
			}

			View::make("user/profile.html", array(
				"user" => $user,
				"blabs" => $blabs,
				"blabCount" => count($blabs),
				"following" => $following,
				"followingCount" => count($following),
				"followers" => $followers,
				"followersCount" => count($followers),
				"favouriteBlabs" => $favouriteBlabs,
				"favouriteBlabCount" => count($favouriteBlabs),
				"follows" => $followStatus
			));
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
