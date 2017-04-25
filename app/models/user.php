<?php
	class User extends BaseModel {
		public $id, $username, $password, $description;
		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array("validate_username", "validate_password", "validate_description");
		}

		// Autentikoi käyttäjän
		public static function authenticate($username, $password) {
			$query = DB::connection()->prepare("SELECT * FROM Account WHERE username = :username AND password = :password LIMIT 1");

			$query->bindValue(":username", $username, PDO::PARAM_STR);
			$query->bindValue(":password", $password, PDO::PARAM_STR);
			$query->execute();
			$row = $query->fetch();

			if ($row) {
				$user = new User(array(
					"id" => $row["id"],
					"username" => $row["username"],
					"password" => $row["password"]
				));
				return $user;
			}

			return null;
		}

		//
		public static function is_username_available($username) {
			$query = DB::connection()->prepare("SELECT * FROM Account WHERE username = :username");
			$query->execute(array("username" => $username));
			$row = $query->fetch();

			return $row == null;
		}

		//
		public function save() {
			$query = DB::connection()->prepare("INSERT INTO Account (username, password, description) VALUES (:username, :password, :description) RETURNING id");
			$query->execute(array("username" => $this->username, "password" => $this->password, "description" => $this->description));
			$row = $query->fetch();
			$this->id = $row["id"];
		}

		// Hakee käyttäjän tietokannasta id:n avulla
		public static function find($id) {
			$query = DB::connection()->prepare("SELECT * FROM Account WHERE id = :id LIMIT 1");

			$query->bindValue(":id", $id, PDO::PARAM_INT);
			$query->execute();
			$row = $query->fetch();

			if ($row) {
				$user = new User(array(
					"id" => $row["id"],
					"username" => $row["username"],
					"password" => $row["password"],
					"description" => $row["description"]
				));
				return $user;
			}

			return null;
		}

		// Päivittää käyttäjän kuvauksen
		public function update() {
			$query = DB::connection()->prepare("UPDATE Account SET description = :description WHERE id = :id");

			$query->bindValue(":id", $this->id, PDO::PARAM_INT);
			$query->bindValue(":description", $this->description, PDO::PARAM_STR);
			$query->execute();
		}

		// Hae tietyt käyttäjät
		public static function search($criteria) {
			$query = DB::connection()->prepare("SELECT DISTINCT Account.id, Account.username, Account.description FROM Account WHERE UPPER(Account.username) LIKE :criteria");
			$query->execute(array("criteria" => "%".strtoupper($criteria)."%"));

			$rows = $query->fetchAll();
			$users = array();

			foreach($rows as $row) {
				$users[] = new User(array(
					"id" => $row["id"],
					"username" => $row["username"],
					"description" => $row["description"]
				));
			}

			return $users;
		}

		// Hakee käyttäjän tietokannasta käyttäjänimen avulla
		public static function find_by_username($username) {
			$query = DB::connection()->prepare("SELECT Account.id, Account.username, Account.password, Account.description FROM Account WHERE username = :username LIMIT 1");

			$query->bindValue(":username", $username, PDO::PARAM_STR);
			$query->execute();
			$row = $query->fetch();

			if ($row) {
				$user = new User(array(
					"id" => $row["id"],
					"username" => $row["username"],
					"password" => $row["password"],
					"description" => $row["description"]
				));
				return $user;
			}

			return null;
		}

		// Tarkistaa seuraatko tiettyä käyttäjää
		public static function is_following($account_id, $follower_id) {
			if ($account_id == $follower_id) {
				return "self";
			}

			$query = DB::connection()->prepare("SELECT Follow.account_id, Follow.follower_id FROM Follow WHERE Follow.account_id = :account_id AND Follow.follower_id = :follower_id LIMIT 1");
			$query->execute(array("account_id" => $account_id, "follower_id" => $follower_id));
			$row = $query->fetch();

			if ($row == null) {
				return "false";
			} else {
				return "true";
			}
		}

		// Seuraa tai poistaa seurauksen
		public static function toggle_follow($account_id, $follower_id) {
			$query = DB::connection()->prepare("SELECT Follow.account_id, Follow.follower_id FROM Follow WHERE Follow.account_id = :account_id AND Follow.follower_id = :follower_id LIMIT 1");
			$query->execute(array("account_id" => $account_id, "follower_id" => $follower_id));
			$row = $query->fetch();

			if ($row == null) {
				// Start follow
				$query = DB::connection()->prepare("INSERT INTO Follow(account_id, follower_id) VALUES (:account_id, :follower_id)");
				$query->execute(array("account_id" => $account_id, "follower_id" => $follower_id));
				return true;
			} else {
				// stop follow
				$query = DB::connection()->prepare("DELETE FROM Follow WHERE Follow.account_id = :account_id AND Follow.follower_id = :follower_id");
				$query->execute(array("account_id" => $account_id, "follower_id" => $follower_id));
				return false;
			}
		}

		// Hae seurattavat
		public static function get_followers($account_id) {
			$query = DB::connection()->prepare("SELECT Account.id, Account.username, Account.description FROM Account, Follow WHERE Follow.follower_id = :account_id AND Follow.account_id = Account.id");
			$query->execute(array("account_id" => $account_id));

			$rows = $query->fetchAll();
			$users = array();

			foreach($rows as $row) {
				$users[] = new User(array(
					"id" => $row["id"],
					"username" => $row["username"],
					"description" => $row["description"]
				));
			}

			return $users;
		}

		// Hae seuraajat
		public static function get_following($account_id) {
			$query = DB::connection()->prepare("SELECT Account.id, Account.username, Account.description FROM Account, Follow WHERE Follow.account_id = :account_id AND Follow.follower_id = Account.id");
			$query->execute(array("account_id" => $account_id));

			$rows = $query->fetchAll();
			$users = array();

			foreach($rows as $row) {
				$users[] = new User(array(
					"id" => $row["id"],
					"username" => $row["username"],
					"description" => $row["description"]
				));
			}

			return $users;
		}

		// Validoi käyttäjänimen
		public function validate_username() {
			$errs = array();
			if ($this->is_not_null($this->username) == false && $this->validate_string_length_shorter_than($this->username, 3)) {
				// I cannot compare $this->body to null.
				// unexpected T_VARIABLE
				$errs[] = "Your username must be at least three characters long!\n";
			}

			if ($this->validate_string_length_longer_than($this->username, 20)) {
				$errs[] = "Your username must be shorter than 20 characters.";
			}
			if (preg_match("/[\"^£$%&*()}{@#~?><>,|?_+-]/ ", $this->username) == true) {
				$errs[] = "Your username must not contain any special characters.";
			}

			return $errs;
		}

		// Validoi salasanan.
		public function validate_password() {
			$errs = array();
			if ($this->is_not_null($this->password) == false && $this->validate_string_length_shorter_than($this->password, 6)) {
				// I cannot compare $this->body to null.
				// unexpected T_VARIABLE
				$errs[] = "Your password must be at least six characters long!\n";
			}

			if ($this->validate_string_length_longer_than($this->password, 32)) {
				$errs[] = "Your password must be shorter than 32 characters.";
			}

			return $errs;
		}

		// Validoi salasanan.
		public function validate_description() {
			$errs = array();
			if (isset($this->description) && $this->validate_string_length_longer_than($this->description, 256)) {
				$errs[] = "Your description must be shorter than 256 characters.";
			}

			return $errs;
		}
	}
