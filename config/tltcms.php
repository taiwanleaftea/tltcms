<?php

return [
    /*
     * Homepage description for breadcrumbs and main menu
     *
     * route, title, Json name
     */
    'homeroute' => 'home',

    /*
     * Main menu links
     *
     * name, link, key
     * if is_href = true - link is href
     * if is_href = false - link is route
     */
    'mainmenu' => [
        [
            'name' => 'Name',
            'link' => 'link',
            'key' => 'key',
            'is_href' => false
        ],
    ],

    /*
     * Items quantity in listings
     */
    'items' => 30,
];