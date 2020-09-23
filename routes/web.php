<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/user', ['uses' => 'Admin\UserController@index', 'as' => 'user']);
    Route::get('/user-edit/{id}', ['uses' => 'Admin\UserController@edit', 'as' => 'user.edit']);
    Route::post('/update-user/{id}', ['uses' => 'Admin\UserController@updateUser', 'as' => 'user.update']);
});



Route::get('/', function () {
    $projects = [
        [
            'title' => 'TheNinth',
            'year' => '2020',
            'image' => 'theNinth.png',
            'description' => 'An online comics / manga reading website also allows you to upload your own story.'
        ],
        [
            'title' => 'Capfrance',
            'year' => '2019',
            'image' => 'capfrance.png',
            'description' => 'Cap France is the leading operator of holiday villages for associative tourism in France.'
        ],
        [
            'title' => 'Interface Concept',
            'year' => '2016',
            'image' => 'interfaceConcept.png',
            'description' => 'INTERFACE CONCEPT is a leader in design and manufacturing of high-performance embedded boards and systems, aimed at ground, naval, air and industrial applications.'
        ],
        [
            'title' => 'WeAreBaddies',
            'year' => '2017',
            'image' => 'wearebaddies.png',
            'description' => 'Released in 2017, We Are Baddies is a subversive ready to wear clothing brand which cerebrates the French’s know how.'
        ],
        [
            'title' => 'Ceiliv TV',
            'year' => '2015',
            'image' => 'ceilivtv.png',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit.'
        ],
        [
            'title' => 'HydroFibi',
            'year' => '2018',
            'image' => 'hydrofibi.png',
            'description' => 'Marc Thomas, former high-level athlete and holder of a STAPS pro license, uses his many years of professional experience as a teacher of aquatic...'
        ],
        [
            'title' => 'NDG',
            'year' => '2017',
            'image' => 'ndg.png',
            'description' => 'N.D.G - for nid de guêpes*, meaning " the wasp nest " - designs and produces collections meshing both american workwear culture and french high-end sensibilities.'
        ],
        [
            'title' => 'Guichard',
            'year' => '2017',
            'image' => 'guichard.png',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit.'
        ],
        [
            'title' => 'Guichard Planning',
            'year' => '2017',
            'image' => 'guichardplanning.png',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit.'
        ]
    ];

    return view('project', ['projects' => $projects]);
});

Route::get('/tools', function () {
    return view('tool');
});

Route::get('/skills', function () {
    return view('skill');
});
