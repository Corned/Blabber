<?php
	require "app/models/blab.php";
	class BlabController extends BaseController {
		public static function sandbox() {
			Kint::dump("HELLO WORLD!");
		}
	}