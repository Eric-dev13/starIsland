<?php
//  fichier de config de l'app

session_start();


const CONFIG=[
    'db'=>[
        'HOST'=>'localhost',
        'PORT'=>'3306',
        'NAME'=>'dece5725_eric_starIsland',
        'USER'=>'dece5725_cezdigitevogue',
        'PWD'=>'Cezevogue1986@'

    ],
    'app'=>[
        'name'=>'starIsland',
        'projecturl'=>'http://eric.cezdigit.com/'
    ]

];

const BASE_PATH='/';

// localhost
// const CONFIG=[
//     'db'=>[
//         'HOST'=>'localhost',
//         'PORT'=>'3306',
//         'NAME'=>'star_island',
//         'USER'=>'root',
//         'PWD'=>''
//     ],
//     'app'=>[
//         'name'=>'starIsland',
//         'projecturl'=>'http://localhost/starIsland'
//     ]
// ];

// const BASE_PATH='/starIsland/';

