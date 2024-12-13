<?php

return [
    /*
     * Homepage description for breadcrumbs and main menu
     *
     * route, title, Json name
     */
    'homeroute' => 'home',

    /*
     * Main menu and submenu links
     *
     * name, link, key
     * if is_href = true - link is href
     * if is_href = false - link is route
     */
    'mainmenu' => [
        [
            /*
            'name' => 'Name',
            'link' => 'link',
            'key' => 'key',
            'is_href' => false
            */
        ],
    ],

    'submenu' => [
        [
            /*
            'key' => 'key', // Main menu key
            'model' => Model::class,
            'name' => // Name parameter from model, i.e. $model->name
            'route' => 'route.name'
            'parameter' => 'slug', // Route parameter from model, i.e. $model->slug
            */
        ],
    ],

    /*
     * Items quantity in listings
     */
    'items' => 30,
];