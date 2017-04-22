<?php
    $routes->get('/hiekkalaatikko', function() {
        HelloWorldController::sandbox();
    });

    $routes->get('/blab/', function() {
        Redirect::to('');
    });

    // Feed
    $routes->get('/globalfeed', function() {
        BlabController::globalFeed();
    });

    $routes->get('/feed', function() {
        BlabController::personalizedFeed();
    });

    // New Blab
    $routes->get('/blab/new/', function() {
        BlabController::create();
    });

    $routes->post('/blab/new/', function() {
        BlabController::store();
    });

    // Show Blab
    $routes->get('/blab/:id/', function($id) {
        BlabController::show($id);
    });

    // Edit Blab
    $routes->get('/blab/:id/edit/', function($id) {
        BlabController::edit($id);
    });

    $routes->post('/blab/edit/', function() {
        BlabController::update();
    });

    // Delete Blab
    $routes->get("/blab/:id/delete/", function($id) {
        BlabController::delete($id);
    });

    $routes->post('/blab/delete/', function() {
        BlabController::destroy();
    });

    // Favourite Blab
    $routes->post("/blab/favourite/", function() {
        BlabController::favourite();
    });

    // Profile
    $routes->get('/profile/:username/', function($username) {
        UserController::profile($username);
    });

    $routes->get('/profile/', function() {
        UserController::profile(null);
    });

    // Follow
    $routes->post("/profile/:username/follow", function($username) {
        UserController::follow($username);
    });

    // Login
    $routes->get('/login/', function() {
        UserController::login();
    });

    $routes->post("/login/", function() {
        UserController::handle_login();
    });

    // Logout
    $routes->post("/logout/", function() {
        UserController::logout();
    });

    $routes->get('/profile/:username/favourites/', function($username) {
        UserController::favourites($username);
    });



    $routes->get('/(:any)', function() {
        Redirect::to("/globalfeed");
    });
