<?php
	class BlabController extends BaseController {
		// Lomakkeen esittely
		public static function globalFeed() {
			$blabs = Blab::all(array());

			View::make('user/feed.html', array(
				"feedType" => "global",
				"blabs" => $blabs
			));
		}


		public static function personalizedFeed() {
			$blabs = Blab::all(array());

			View::make('user/feed.html', array(
				"feedType" => "personalized",
				"blabs" => $blabs
			));
		}

		// Luomislomakkeen esittely
		public static function create() {
			self::check_logged_in();

			View::make('blab/new.html');
		}

		// Näyttämislomakkeen esittely
		public static function show($id) {
			self::check_logged_in();
			$user = self::get_user_logged_in();

			$blab = Blab::find($id);
			if ($blab == null) {
				Redirect::to("/", array("error" => "Blab not found."));
			}

			$isFavourite = Blab::is_favourite($blab->id, $user->id);
			View::make('blab/show.html', array('blab' => $blab, "liked" => $isFavourite, "isOwner" => ($user->id == $blab->account_id)));
		}
		// Muokkauslomakkeen esittely
		public static function edit($id) {
			self::check_logged_in();

			$blab = Blab::find($id);
			if ($blab != null && self::authorize_access($blab->account_id)) {
				View::make('blab/edit.html', array('blab' => $blab));
			}
			Redirect::to("/", array("error" => "Unauthorized access."));
		}

		// Poistamislomakkeen esittely
		public static function delete($id) {
			self::check_logged_in();

			$blab = Blab::find($id);
			if ($blab != null && self::authorize_access($blab->account_id)) {
				View::make('blab/delete.html', array('blab' => $blab));
			}
			Redirect::to("/", array("error" => "Unauthorized access."));
		}


		// Post - Create new blab
		public static function store() {
			self::check_logged_in();

			if (parent::get_user_logged_in() == null) {
				Redirect::to("/login");
			}

			$params = $_POST;
			$attributes = array(
				'username' => parent::get_user_logged_in()->username,
				'body' => $params['body'],
				'deleted' => FALSE
			);

			$blab = new Blab($attributes);
			$errs = $blab->errors();

			if (count($errs) == 0) {
				$blab->save(parent::get_user_logged_in()->id);
				Redirect::to("/blab/" . $blab->id, array("message" => "Your blab was published successfully!"));
			} else {
				View::make('/blab/new.html', array("errors" => $errs, "attributes" => $attributes));
			}
		}

		// Post - Tykkää blabista
		public static function favourite() {
			self::check_logged_in();

			$params = $_POST;
			$isFavourite = Blab::toggle_favourite($params["blab_id"], $_SESSION["user"]);
			$message = "";
			if ($isFavourite == true) {
				$message = "You liked this blab!";
			} else {
				$message = "You no longer like this blab.. :(";
			}

			Redirect::to("/blab/" . $params["blab_id"], array("message" => $message, "liked" => $isFavourite));
		}

		// Post - Päivitä blab
		public static function update() {
			self::check_logged_in();

			$params = $_POST;
			$attributes = array(
				"id" => $params["id"],
				"body" => $params["newbody"]
			);

			$blab = new Blab($attributes);
			$errs = $blab->errors();

			if (count($errs) == 0) {
				$blab->update($blab->id, $blab->body);
				Redirect::to('/blab/' . $blab->id, array('message' => 'You edited your blab successfully!'));
			} else {
				$oldblab = new Blab(array(
					"id" => $params["id"],
					"body" => $params["oldbody"]
				));
				View::make("blab/edit.html", array("errors" => $errs, "blab" => $oldblab));
			}
		}

		// Post - poista blab
		public static function destroy() {
			self::check_logged_in();

			$params = $_POST;
			$blab = new Blab(array("id" => $params["id"]));
			$blab->destroy();
			Redirect::to("/feed", array("message" => "Your blab was deleted successfully!"));
		}
	}
