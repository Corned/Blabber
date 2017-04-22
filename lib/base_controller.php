<?php

    class BaseController{

        public static function get_user_logged_in(){
        // Toteuta kirjautuneen käyttäjän haku tähän
            if (isset($_SESSION["user"])) {
                $user_id = $_SESSION["user"];
                return User::find($user_id);
            }
            
            return null;
        }

        public static function check_logged_in(){
            // Toteuta kirjautumisen tarkistus tähän.
            if (!isset($_SESSION["user"])) {
                Redirect::to("/login", array("type" => "login-error", "error" => "Please log in."));
            }
        }

        public static function authorize_access($account_id) {
            return $account_id == self::get_user_logged_in()->id;
        }

    }
