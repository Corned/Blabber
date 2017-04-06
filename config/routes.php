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

    $routes->get('/blab/show/:id', function($id) {
        BlabController::show($id);
    });

    $routes->get("/blab/delete/:id", function($id) {
        BlabController::delete($id);
    });

    // Blab Posts
    $routes->post('/blab/new', function() {
        BlabController::store();
    });

    $routes->post('/blab/edit', function() {
        BlabController::update();
    });

    $routes->post('/blab/delete', function() {
        BlabController::destroy();
    });


    // ...
    $routes->get('/login', function() {
        UserController::login();
    });

    $routes->post("/login", function() {
        UserController::handle_login();
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
