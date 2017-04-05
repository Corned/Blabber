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

		public static function destroy($id) {
			$blab = Blab::find($id);
		}


		// Post - Create new blab
		public static function store() {
			$params = $_POST;
			$attributes = array(
				'body' => $params['body'],
				'deleted' => FALSE
			);

			$blab = new Blab($attributes);
			$errs = $blab->errors();

			if (count($errs) == 0) {
				$blab->save();
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
	}