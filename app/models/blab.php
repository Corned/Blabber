<?php
	class Blab extends BaseModel {
		public $id, $account_id, $username, $body, $deleted;
		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array("validate_body");
		}

		// Hae kaikki blabit
		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Blab ORDER BY Blab.id DESC');
			$query->execute();

			$rows = $query->fetchAll();
			$blabs = array();

			foreach($rows as $row) {
				$blabs[] = new Blab(array(
					'id' => $row['id'],
					"account_id" => $row["account_id"],
					"username" => $row["username"],
					'body' => $row['body']
				));
			}

			return $blabs;
		}


		// Hae kaikki blabit
		public static function get_personalized_blabs($account_id) {
			$query = DB::connection()->prepare('SELECT DISTINCT Blab.id, Blab.account_id, Blab.username, Blab.body FROM Blab, Follow WHERE Follow.account_id = :account_id AND Follow.follower_id = Blab.account_id ORDER BY Blab.id DESC');
			$query->execute(array("account_id" => $account_id));

			$rows = $query->fetchAll();
			$blabs = array();

			foreach($rows as $row) {
				$blabs[] = new Blab(array(
					'id' => $row['id'],
					"account_id" => $row["account_id"],
					"username" => $row["username"],
					'body' => $row['body']
				));
			}

			return $blabs;
		}

		// Hae kaikki blabit
		public static function search($criteria) {
			$query = DB::connection()->prepare('SELECT DISTINCT * FROM Blab WHERE UPPER(Blab.body) LIKE :criteria OR UPPER(Blab.username) LIKE :criteria ORDER BY Blab.id DESC');
			$query->execute(array("criteria" => "%".strtoupper($criteria)."%"));

			$rows = $query->fetchAll();
			$blabs = array();

			foreach($rows as $row) {
				$blabs[] = new Blab(array(
					'id' => $row['id'],
					"account_id" => $row["account_id"],
					"username" => $row["username"],
					'body' => $row['body']
				));
			}

			return $blabs;
		}

		// Hae yksi blab id:n perusteella
		public static function find($id) {
			if (!is_numeric($id)) {
				return null;
			}

			if ($id > 2147483647) {
				// overflow
				return null;
			}

			if ($id < 0) {
				// invalid id
				return null;
			}

			$query = DB::connection()->prepare('SELECT * FROM Blab WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if ($row) {
				$blab = new Blab(array(
					'id' => $row['id'],
					"account_id" => $row["account_id"],
					'username' => $row['username'],
					'body' => $row['body']
				));
				return $blab;
			}

			return null;
		}

		// Hae käyttäjän kaikki blabit käyttäjän id:n perusteella.
		public static function find_by_accountid($account_id) {
			$query = DB::connection()->prepare('SELECT DISTINCT Blab.id, Blab.account_id, Blab.username, Blab.body FROM Blab, Account WHERE Blab.account_id =:account_id ORDER BY Blab.id DESC');
			$query->bindValue(':account_id', $account_id, PDO::PARAM_STR);
			$query->execute();

			$rows = $query->fetchAll();
			$blabs = array();

			foreach($rows as $row) {
				$blabs[] = new Blab(array(
					'id' => $row['id'],
					"account_id" => $row["account_id"],
					"username" => $row["username"],
					'body' => $row['body']
				));
			}

			return $blabs;
		}

		// Hae käyttäjän tykkäykset käyttäjän id:n perusteella.
		public static function find_favourites_by_accountid($account_id) {
			$query = DB::connection()->prepare('SELECT DISTINCT Blab.id, Blab.account_id, Blab.username, Blab.body FROM Blab, Account, Favourite WHERE Blab.id = Favourite.blab_id AND Favourite.account_id = :account_id ORDER BY Blab.id DESC');
			$query->bindValue(':account_id', $account_id, PDO::PARAM_STR);
			$query->execute();

			$rows = $query->fetchAll();
			$blabs = array();

			foreach($rows as $row) {
				$blabs[] = new Blab(array(
					'id' => $row['id'],
					"account_id" => $row["account_id"],
					"username" => $row["username"],
					'body' => $row['body']
				));
			}

			return $blabs;
		}

		// Tarkistaa onko tietty blab tietyn käyttäjän suosikki
		public static function is_favourite($blab_id, $account_id) {
			if ($blab_id > 2147483647) {
				return null;
			}

			$query = DB::connection()->prepare('SELECT Favourite.account_id, Favourite.blab_id FROM Favourite WHERE Favourite.blab_id = :blab_id AND Favourite.account_id = :account_id LIMIT 1');

			$query->bindValue(":account_id", $account_id, PDO::PARAM_INT);
			$query->bindValue(":blab_id", $blab_id, PDO::PARAM_INT);
			$query->execute();
			$row = $query->fetch();

			return !($row == null);
		}

		// Asettaa blabin käyttäjän suosikiksi tai poistaa suosikki "statuksen"
		public static function toggle_favourite($blab_id, $account_id) {
			if ($blab_id > 2147483647) {
				return null;
			}

			$query = DB::connection()->prepare('SELECT Favourite.account_id, Favourite.blab_id FROM Favourite WHERE Favourite.account_id = :account_id AND Favourite.blab_id = :blab_id LIMIT 1');

			$query->bindValue(":account_id", $account_id, PDO::PARAM_INT);
			$query->bindValue(":blab_id", $blab_id, PDO::PARAM_INT);
			$query->execute();
			$row = $query->fetch();

			if ($row == null) {
				// Create favourite
				$query = DB::connection()->prepare('INSERT INTO Favourite(account_id, blab_id) VALUES (:account_id, :blab_id)');
				$query->bindValue(":account_id", $account_id, PDO::PARAM_INT);
				$query->bindValue(":blab_id", $blab_id, PDO::PARAM_INT);
				$query->execute();
				return true;
			} else {
				// Remove favourite
				$query = DB::connection()->prepare('DELETE FROM Favourite WHERE Favourite.account_id = :account_id AND Favourite.blab_id = :blab_id');
				$query->bindValue(":account_id", $account_id, PDO::PARAM_INT);
				$query->bindValue(":blab_id", $blab_id, PDO::PARAM_INT);
				$query->execute();
				return false;
			}
		}

		// Päivittää blabin sisältöä
		public function update() {
			if ($this->id > 2147483647) {
				return null;
			}

			$query = DB::connection()->prepare('UPDATE Blab SET body = :body WHERE id = :id');

			$query->bindValue(':id', $this->id, PDO::PARAM_INT);
			$query->bindValue(':body', $this->body, PDO::PARAM_STR);
			$query->execute();
		}

		// Tallentaa blabin tietokantaan
		public function save($account_id) {
			$query = DB::connection()->prepare('INSERT INTO Blab (account_id, username, body) VALUES (:account_id, :username, :body) RETURNING id');

			$query->bindValue(":account_id", $account_id, PDO::PARAM_INT);
			$query->bindValue(':username', $this->username, PDO::PARAM_STR);
			$query->bindValue(':body', $this->body, PDO::PARAM_STR);
			$query->execute();
			$row = $query->fetch();

			$this->id = $row['id'];
		}

		// Poistaa blabin tietokannasta
		public function destroy() {
			$query = DB::connection()->prepare('DELETE FROM Blab WHERE id = :id');
			$query->bindValue(':id', $this->id, PDO::PARAM_INT);
			$query->execute();

			$query = DB::connection()->prepare('DELETE FROM Favourite WHERE Favourite.blab_id = :id');
			$query->bindValue(':id', $this->id, PDO::PARAM_INT);
			$query->execute();
		}

		public static function destroy_blabs_by_account_id($id) {
			$query = DB::connection()->prepare('DELETE FROM Blab WHERE Blab.account_id = :id');
			$query->bindValue(':id', $id, PDO::PARAM_INT);
			$query->execute();
		}

		public static function destroy_likes_by_account_id($id) {
			$query = DB::connection()->prepare('DELETE FROM Favourite WHERE Favourite.account_id = :id');
			$query->bindValue(':id', $id, PDO::PARAM_INT);
			$query->execute();
		}

		// Validoi blabin sisällön
		public function validate_body() {
			$errs = array();
			if ($this->is_not_null($this->body) == false && $this->validate_string_length_shorter_than($this->body, 1)) {
				// I cannot compare $this->body to null.
				// unexpected T_VARIABLE
				$errs[] = 'Your message must not be empty!';
			}

			if ($this->validate_string_length_longer_than($this->body, 256)) {
				$errs[] = "Your message was longer than 256 characters.";
			}

			return $errs;
		}
	}
