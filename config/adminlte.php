<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Sistema de Gerenciamento de Automovéis e Pessoas',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<p style=\'font-family:Ubuntu-Regular;font-weight:bold;\'>SIGAPS</p>',

    'logo_mini' => "<img width=66% src='/images/logo_login.png'>",

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => 'POST',

    'login_url' => 'login',

    'register_url' => '',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        [
            'text'        => 'Início',
            'url'         => '/',
            'icon'        => 'home',
        ],
        'MENU',
        [
            'text' => 'Militares',
            'icon' => 'user',
            'icon_color' => 'green',
            'can'       => 'militares-menu',
            'submenu' => [
                [
                    'text' => 'Cadastrar',
                    'url'  => 'militares/cadastro',
                    'icon_color' => 'green',
                    'icon' => 'plus-square',
                    'can'       => 'militares-add',
                ],
                [
                    'text' => 'Listagem',
                    'url'  => 'militares/',
                    'icon_color' => 'green',
                    'icon' => 'list',
                    'can'       => 'militares-list',
                ],
            ],
        ],
        [
            'text' => 'Veículos',
            'icon' => 'car',
            'icon_color' => 'yellow',
            'can'       => 'veiculos-menu',
            'submenu' => [
                [
                    'text' => 'Cadastrar',
                    'url'  => 'veiculos/cadastro',
                    'icon_color' => 'yellow',
                    'icon' => 'plus-square',
                    'can'       => 'veiculos-add',
                ],
                [
                    'text' => 'Listagem',
                    'url'  => 'veiculos/',
                    'icon_color' => 'yellow',
                    'icon' => 'list',
                    'can'       => 'veiculos-list',
                ],
            ],
        ],
        [
            'text' => 'Consultas',
            'icon' => 'search',
            'icon_color' => 'purple',
            'can'       => 'consultas-menu',
            'submenu' => [
                [
                    'text' => 'Horários Pedestres',
                    'url'  => 'consulta/pedestres',
                    'icon_color' => 'purple',
                    'can'       => 'consultas-ped',
                ],
                [
                    'text' => 'Horários Veículos',
                    'url'  => 'consulta/automoveis',
                    'icon_color' => 'purple',
                    'can'       => 'consultas-aut',
                ],
            ],
        ],
        [
            'text' => 'Relatórios',
            'icon' => 'bar-chart',
            'icon_color' => 'blue',
            'can'       => 'relatorios-menu',
            'submenu' => [
                [
                    'text' => 'Entrada e Saída',
                    'url'  => 'relatorios/horarios',
                    'icon_color' => 'blue',
                    'can'       => 'relatorios-hrs',
                ],
                [
                    'text' => 'Militares',
                    'url'  => 'relatorios/militares',
                    'icon_color' => 'blue',
                    'can'       => 'relatorios-mil',
                ],
                [
                    'text' => 'Automovéis',
                    'url'  => 'relatorios/automoveis',
                    'icon_color' => 'blue',
                    'can'       => 'relatorios-aut',
                ],
            ],
        ],
        'ADMINISTRAÇÃO',
        [
            'text'    => 'Configurações',
            'icon'    => 'gears',
            'icon_color' => 'red',
            'submenu' => [
                [
                    'text' => 'OM\'s',
                    'icon_color' => 'red',
                    'icon' => 'gear',
                    'can'       => 'config-om-menu',
                    'submenu' => [
                        [
                            'text' => 'Cadastrar',
                            'url'  => 'configuracoes/OM/cadastrar/',
                            'icon_color' => 'red',
                            'icon' => 'circle-o',
                            'can'       => 'config-om-add',
                        ],
                        [
                            'text' => 'Listagem',
                            'url'  => 'configuracoes/OM/',
                            'icon_color' => 'red',
                            'icon' => 'circle-o',
                            'can'       => 'config-om-list',
                        ],
                    ],
                ],
                [
                    'text'    => 'Usuários do Sistema',
                    'icon_color' => 'red',
                    'icon' => 'gear',
                    'can'       => 'config-usuario-menu',
                    'submenu' => [
                        [
                            'text' => 'Cadastrar',
                            'url'  => 'configuracoes/usuarios/cadastrar/',
                            'icon_color' => 'red',
                            'icon' => 'circle-o',
                            'can'       => 'config-usuario-add',
                        ],
                        [
                            'text' => 'Listagem',
                            'url'  => 'configuracoes/usuarios/',
                            'icon_color' => 'red',
                            'icon' => 'circle-o',
                            'can'       => 'config-usuario-list',
                        ],
                    ],
                ],
                [
                    'text'    => 'Veículos',
                    'icon_color' => 'red',
                    'icon' => 'gear',
                    'can'       => 'config-veiculos-menu',
                    'submenu' => [
                        [
                            'text' => 'Marca',
                            'url'  => 'configuracoes/veiculos/marca/',
                            'icon_color' => 'red',
                            'icon' => 'circle-o',
                            'can'       => 'config-veiculos-marca',
                        ],
                        [
                            'text' => 'Modelo',
                            'url'  => 'configuracoes/veiculos/modelo/',
                            'icon_color' => 'red',
                            'icon' => 'circle-o',
                            'can'       => 'config-veiculos-modelo',
                        ],
                        [
                            'text' => 'Tipo',
                            'url'  => 'configuracoes/veiculos/tipo/',
                            'icon_color' => 'red',
                            'icon' => 'circle-o',
                            'can'       => 'config-veiculos-tipo',
                        ],
                    ],
                ],
                [
                    'text'    => 'Viaturas',
                    'icon_color' => 'red',
                    'icon' => 'gear',
                    'can'       => 'config-vtr-menu',
                    'submenu' => [
                        [
                            'text' => 'Cadastrar',
                            'url'  => 'configuracoes/viaturas/cadastrar/',
                            'icon_color' => 'red',
                            'icon' => 'circle-o',
                            'can'       => 'config-vtr-add',
                        ],
                        [
                            'text' => 'Listagem',
                            'url'  => 'configuracoes/viaturas/',
                            'icon_color' => 'red',
                            'icon' => 'circle-o',
                            'can'       => 'config-vtr-list',
                        ],
                    ],
                ],
                [
                    'text' => 'Registrar Horário',
                    'url'  => 'configuracoes/horarios/',
                    'icon_color' => 'red',
                    'icon' => 'gear',
                    'can'       => 'config-horarios',
                ],
                [
                    'text' => 'Trocar Crachá',
                    'url'  => 'configuracoes/cracha/trocar',
                    'icon_color' => 'red',
                    'icon' => 'gear',
                    'can'       => 'config-trocar-cracha',
                ],
                [
                    'text' => 'Postos/Graduações',
                    'url'  => 'configuracoes/postos/',
                    'icon_color' => 'red',
                    'icon' => 'gear',
                    'can'       => 'config-postos',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => false,
        'chartjs'    => false,
    ],
];
