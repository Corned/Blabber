<?php
	class BlabController extends BaseController {
		// Lomakkeen esittely
		public static function globalFeed() {
			$blabs = Blab::all();
			View::make('user/feed.html', array('blabs' => $blabs));	
		}

		// Lomakkeen esittely
		public static function create() {
			View::make('blab/new.html');
		}

		// Lomakkeen esittely
		public static function show($id) {
			$blab = Blab::find($id);
			View::make('blab/show.html', array('blab' => $blab));
		}

		// Lomakkeen esittely
		public static function edit($id) {
			$blab = Blab::find($id);
			View::make('blab/edit.html', array('blab' => $blab));
		}

		// Lomakkeen esittely
		public static function delete($id) {
			$blab = Blab::find($id);
			View::make('blab/delete.html', array('blab' => $blab));
		}


		// Post - Create new blab
		public static function store() {
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
				Kint::dump(parent::get_user_logged_in()->id);
				Redirect::to("/blab/show/" . $blab->id, array("message" => "Your blab was published successfully!"));
			} else {
				View::make('/blab/new.html', array("errors" => $errs, "attributes" => $attributes));
			}
		}


		public static function update() {
			$params = $_POST;
			$attributes = array(
				"id" => $params["id"],
				"body" => $params["newbody"],
				"deleted" => FALSE
			);

			$blab = new Blab($attributes);
			$errs = $blab->errors();

			if (count($errs) == 0) {
				$blab->update($blab->id, $blab->body);
				Redirect::to('/blab/show/' . $blab->id, array('message' => 'You edited your blab successfully!'));
			} else {
				View::make("blab/edit.html", array("errors" => $errors, "attributes" => $attributes));
			}
		}

		public static function destroy() {
			$params = $_POST;
			$blab = new Blab(array("id" => $params["id"]));
			$blab->destroy();
			Redirect::to("/feed", array("message" => "Blab was deleted successfully!"));
		}
	}