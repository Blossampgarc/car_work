<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use myPHPnotes\Microsoft\Auth;
use Illuminate\Http\RedirectResponse;

class MicrosoftController extends Controller
{
    public function microsoft_signin(){
    	$tenant = "common";
    	$client_id = "b8ffbde0-8991-49b8-ac4c-2ac73c94feb1";
    	$client_secret = "jkM7Q~1JWQ9D7pBMu0LSqYgIAAIMpnXX8d4ax";
    	$callback = "http://127.0.0.1:8000/callback";
    	$scope = ['User.Read'];
        $microsoft = new Auth($tenant, $client_id, $client_secret, $callback, $scope);
        return new RedirectResponse($microsoft->getAuthUrl());
        // return Redirect::to($microsoft->getAuthUrl());
        // var_dump($microsoft->getAuthUrl());
    }
}
