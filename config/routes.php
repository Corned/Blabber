<?php

    $routes->get('/hiekkalaatikko', function() {
        HelloWorldController::sandbox();
    });

    $routes->get('/feed', function() {
        BlabController::globalFeed();
        //BlabController::userFeed();
    });



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

    /*$routes->get('/blab/delete/:id', function($id) {
        BlabController::edit($id);
    });*/

    $routes->get('/blab/:id', function($id) {
        BlabController::show($id);
    });

    // Blab Posts
    $routes->post('/blab/new', function() {
        BlabController::store();
    });

    $routes->post('/blab/edit', function() {
        BlabController::update();
    });

    /*$routes->post('/blab/delete', function() {
        BlabController::store();
    });*/



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
