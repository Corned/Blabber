<?php

    $routes->get('/hiekkalaatikko', function() {
        HelloWorldController::sandbox();
    });

    $routes->get('/feed', function() {
        BlabController::globalFeed();
        //BlabController::userFeed();
    });

    /*$routes->get('/feed', function() {

    });
    */

    // Blab Gets
    $routes->get('/blab/', function() {
        Redirect::to('');
    });

    $routes->get('/blab/new', function() {
        BlabController::create();
    });

    $routes->get('/blab/edit/:id', function($id) {
        BlabController::edit($id);
    });

    $routes->get('/blab/:id', function($id) {
        BlabController::show($id);
    });

    // Blab Posts
    $routes->post('/blab/new', function() {
        BlabController::store();
    });



    // stuff
    $routes->get('/notifications', function() {
        HelloWorldController::notifications();
    });

    $routes->get('/profile', function() {
        HelloWorldController::profile();
    });

    $routes->get('/settings', function() {
        HelloWorldController::settings();
    });


    

    $routes->get('/(:any)', function() {
        BlabController::globalFeed();
    });
