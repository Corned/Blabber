<?php
	class BlabController extends BaseController {
		// Get
		public static function globalFeed() {
			$blabs = Blab::all();
			View::make('user/feed.html', array('blabs' => $blabs));	
		}

		public static function create() {
			View::make('blab/new.html');
		}

		public static function show($id) {
			$blab = Blab::find($id);
			View::make('blab/show.html', array('blab' => $blab));
		}

		public static function edit($id) {
			$blab = Blab::find($id);
			View::make('blab/edit.html', array('blab' => $blab));
		}

		public static function update() {
			$params = $_POST;
			Blab::update($params["id"], $params["newbody"]);
			Redirect::to('/blab/' . $params["id"], array('message' => 'Blab Updated!'));
		}

		// Post
		public static function store() {
			$params = $_POST;
			$blab = new Blab(array(
				'body' => $params['body'],
				'deleted' => FALSE
			));

			$blab->save();
			Redirect::to('/blab/' . $blab->id, array('message' => 'New Blab Sent!'));
		}
	}