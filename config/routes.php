<?php

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });


  $routes->get('/', function() {
    BlabController::globalFeed();
  });

  $routes->get('/feed', function() {
    BlabController::globalFeed();
  });

  /*$routes->get('/feed', function() {
    BlabController::userFeed();
  });
  */

  $routes->get('/blab/new', function() {
    BlabController::newblab();
  });

  $routes->get('/blab/edit/:id', function($id) {
    BlabController::editblab($id);
  });

  $routes->get('/blab/:id', function($id) {
    BlabController::showblab($id);
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