<?php

  require "app/models/blab.php";

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
      //echo "Tämä on etusivu!";
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      //View::make("helloworld.html");
      $b = new Blab(array(
          'body' => ""
        ));

      Kint::dump($b->errors());
      Kint::dump($b->body);
    }

    public static function login() {
      View::make("plans/login.html");
    }

    public static function newblab() {
      View::make("blab/new.html");
    }

    public static function editblab() {
      View::make("blab/edit.html");
    }

    public static function feed() {
      View::make("user/feed.html");
    }

    public static function notifications() {
      View::make("user/notifications.html");
    }

    public static function profile() {
      View::make("user/profile.html");
    }

    public static function settings() {
      View::make("user/settings.html");
    }

  }
