<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Hem',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Home route of current frontcontroller'
        ],

        // This is a menu item
        'questions' => [
            'text'  =>'Frågor',
            'url'   => $this->di->get('url')->create('questions/list'),
            'title' => 'Svar och frågor',
        ],

        // This is a menu item
        'tags' => [
            'text'  =>'Taggar',
            'url'   => $this->di->get('url')->create('tags/list'),
            'title' => 'Taggar'
        ],

        // This is a menu item
        'users' => [
            'text'  =>'Användare',
            'url'   => $this->di->get('url')->create('user/list'),
            'title' => 'Användare som finns på sidan'
        ],

        // This is a menu item
        'about' => [
            'text'  =>'Om',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'Om sidan och skaparen av den'
        ],

        // This is a menu item
        'login' => [
            'class' => 'login',
            'text'  =>'Logga in',
            'url'   => $this->di->get('url')->create('login'),
            'title' => 'Logga in på sidan'
        ],

        // This is a menu item
        'register' => [
            'class' => 'register',
            'text'  =>'Registrera',
            'url'   => $this->di->get('url')->create('register'),
            'title' => 'Registrera ny användare på sidan'
        ],
    ],
 


    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];


// This is a menu item
        // 'test'  => [
        //     'text'  => 'Submenu',
        //     'url'   => $this->di->get('url')->create('submenu'),
        //     'title' => 'Submenu with url as internal route within this frontcontroller',

        //     // Here we add the submenu, with some menu items, as part of a existing menu item
        //     'submenu' => [

        //         'items' => [

        //             // This is a menu item of the submenu
        //             'item 0'  => [
        //                 'text'  => 'Item 0',
        //                 'url'   => $this->di->get('url')->create('submenu/item-0'),
        //                 'title' => 'Url as internal route within this frontcontroller'
        //             ],

        //             // This is a menu item of the submenu
        //             'item 2'  => [
        //                 'text'  => '/humans.txt',
        //                 'url'   => $this->di->get('url')->asset('/humans.txt'),
        //                 'title' => 'Url to sitespecific asset',
        //                 'class' => 'italic'
        //             ],

        //             // This is a menu item of the submenu
        //             'item 3'  => [
        //                 'text'  => 'humans.txt',
        //                 'url'   => $this->di->get('url')->asset('humans.txt'),
        //                 'title' => 'Url to asset relative to frontcontroller',
        //             ],
        //         ],
        //     ],
        // 
        //],
