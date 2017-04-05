<?php
	class Blab extends BaseModel {
		public $id, $body, $deleted;
		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array("validate_body");
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

		public static function update($id, $body) {
			$query = DB::connection()->prepare('UPDATE Blab SET body = :body WHERE id = :id');

			$query->bindValue(':id', $id, PDO::PARAM_INT);
			$query->bindValue(':body', $body, PDO::PARAM_STR);
			$query->execute();
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Blab (body, deleted) VALUES (:body, :deleted) RETURNING id');

			$query->bindValue(':body', $this->body, PDO::PARAM_STR);
			$query->bindValue(':deleted', $this->deleted, PDO::PARAM_BOOL);
			$query->execute();

			$row = $query->fetch();

			$this->id = $row['id'];
		}

		// Validate
		public function validate_body() {
			$errs = array();
			if ($this->is_not_null($this->body) == false && $this->validate_string_length($this->body, 0) == false) { 
				// I cannot compare $this->body to null.
				// unexpected T_VARIABLE
				$errs[] = 'Your message must not be empty!';
			}

			return $errs;
		}
	}

