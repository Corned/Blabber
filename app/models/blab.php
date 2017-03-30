<?php
	class Blab extends BaseModel {
		public $id, $body;
		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Blab');
			$query->execute();

			$rows = $query->fetchAll();
			$blabs = array();

			foreach($rows as $row) {
				$blabs[] = new Blab(array(
					'id' => $row['id'],
					'body' => $row['body']
				));
			}

			return $blabs;
		}

		public static function find($id) {
			$query = DB::connection()->prepare('SELECT * FROM Blab WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if ($row) {
				$blab = new Blab(array(
					'id' => $row['id'],
					'body' => $row['body']
				));
				return $blab;
			}

			return null;
		}
	}