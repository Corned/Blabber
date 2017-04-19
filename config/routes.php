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

    $routes->post("/blab/favourite", function() {
            //$message = "wrong naswer";
        //echo "<script type='text/javascript'>alert('$message');</script>";
        BlabController::favourite();
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

    $routes->get('/profile/:username', function($username) {
        UserController::profile($username);
    });

    $routes->get('/profile/', function() {
        UserController::profile(null);
    });

    $routes->get('/profile/:username/favourites', function($username) {
        UserController::favourites($username);
    });



    $routes->get('/(:any)', function() {
        Redirect::to("/feed");
    });

    $routes->get('/(:any)', function() {
        Redirect::to("/feed");
    });
