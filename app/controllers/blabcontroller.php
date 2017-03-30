<?php
	class BlabController extends BaseController {
		public static function globalFeed() {
			$blabs = Blab::all();
			View::make('user/feed.html', array('blabs' => $blabs));	
		}

		public static function showblab($id) {
			$blabs = Blab::find($id);
			View::make('blab/show.html', array('blab' => $blabs));
		}

		public static function newblab() {
			View::make('blab/new.html');
		}

		public static function editblab($id) {
			View::make('blab/edit.html');
		}
	}