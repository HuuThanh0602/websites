<?php
return [
    'module' => [
        [
            'title' => 'Dashboard',
            'icon' => 'fa fa-database',
            'name' => ['dashboard'],
            'route' => 'dashboard/index',
            'class' => 'special'
        ],
        [
            'title' => 'Revenue Report',
            'icon' => 'fa fa-money',
            'name' => ['report'],
            'subModule' => [
                [
                    'title' => 'By Time',
                    'route' => 'report/time'
                ],
                [
                    'title' => 'By Product',
                    'route' => 'report/product'
                ],
                [
                    'title' => 'By Source',
                    'route' => 'report/customer'
                ],
            ]
        ],
        [
            'title' => 'Products',
            'icon' => 'fa fa-cube',
            'name' => ['product','attribute'],
            'subModule' => [
                [
                    'title' => 'Categories',
                    'route' => 'product/catalogue/index'
                ],
                [
                    'title' => 'Products',
                    'route' => 'product/index'
                ],
                [
                    'title' => 'Attribute Types',
                    'route' => 'attribute/catalogue/index'
                ],
                [
                    'title' => 'Attributes',
                    'route' => 'attribute/index'
                ],

            ]
        ],
        [
            'title' => 'Orders',
            'icon' => 'fa fa-shopping-bag',
            'name' => ['order'],
            'subModule' => [
                [
                    'title' => 'Orders',
                    'route' => 'order/index'
                ],
            ]
        ],
        [
            'title' => 'Customer Groups',
            'icon' => 'fa fa-user',
            'name' => ['customer'],
            'subModule' => [
                [
                    'title' => 'Groups',
                    'route' => asset('customer/catalogue/index')
                ],
                [
                    'title' => 'Customers',
                    'route' => 'customer/index'
                ],
            ]
        ],
        [
            'title' => 'Marketing',
            'icon' => 'fa fa-money',
            'name' => ['promotion', 'source'],
            'subModule' => [
                [
                    'title' => 'Promotions',
                    'route' => 'promotion/index'
                ],
                [
                    'title' => 'Sources',
                    'route' => 'source/index'
                ],
            ]
        ],
        [
            'title' => 'Posts',
            'icon' => 'fa fa-file',
            'name' => ['post'],
            'subModule' => [
                [
                    'title' => 'Categories',
                    'route' => 'post/catalogue/index'
                ],
                [
                    'title' => 'Posts',
                    'route' => 'post/index'
                ]
            ]
        ],
        [
            'title' => 'Comments',
            'icon' => 'fa fa-comment',
            'name' => ['reviews'],
            'subModule' => [
                [
                    'title' => 'Comments',
                    'route' => 'review/index'
                ]
            ]
        ],
        [
            'title' => 'Users',
            'icon' => 'fa fa-user',
            'name' => ['user','permission'],
            'subModule' => [
                [
                    'title' => 'Groups',
                    'route' => 'user/catalogue/index'
                ],
                [
                    'title' => 'Users',
                    'route' => 'user/index'
                ],
                [
                    'title' => 'Permissions',
                    'route' => 'permission/index'
                ]
            ]
        ],
        [
            'title' => 'Banner & Slide',
            'icon' => 'fa fa-picture-o',
            'name' => ['slide'],
            'subModule' => [
                [
                    'title' => 'Slide Settings',
                    'route' => 'slide/index'
                ],
            ]
        ],
        [
            'title' => 'Menu',
            'icon' => 'fa fa-bars',
            'name' => ['menu'],
            'subModule' => [
                [
                    'title' => 'Settings',
                    'route' => 'menu/index'
                ],
            ]
        ],
        [
            'title' => 'Settings',
            'icon' => 'fa fa-file',
            'name' => ['language', 'generate', 'system', 'widget'],
            'subModule' => [
                [
                    'title' => 'Languages',
                    'route' => 'language/index'
                ],
                [
                    'title' => 'System',
                    'route' => 'system/index'
                ],
                [
                    'title' => 'Widgets',
                    'route' => 'widget/index'
                ],
                
            ]
        ]
    ],
];
