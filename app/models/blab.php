<?php
	class Blab extends BaseModel {
		public $id, $body, $deleted;
		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Blab ORDER BY Blab.id DESC');
			$query->execute();

			$rows = $query->fetchAll();
			$blabs = array();

			foreach($rows as $row) {
				$blabs[] = new Blab(array(
					'id' => $row['id'],
					'body' => $row['body'],
					'deleted' => $row['deleted']
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
					'body' => $row['body'],
					'deleted' => $row['deleted']
				));
				return $blab;
			}

			return null;
		}


		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Blab (body, deleted) VALUES (:body, :deleted) RETURNING id');

			$query->bindValue(':body', $this->body, PDO::PARAM_STR);
			$query->bindValue(':deleted', $this->deleted, PDO::PARAM_BOOL);
			$query->execute();

			$row = $query->fetch();

			$this->id = $row['id'];
		}
	}