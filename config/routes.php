<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });


  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/feed', function() {
    HelloWorldController::feed();
  });

  $routes->get('/notifications', function() {
    HelloWorldController::notifications();
  });

  $routes->get('/profile', function() {
    HelloWorldController::profile();
  });

  $routes->get('/settings', function() {
    HelloWorldController::settings();
  });
