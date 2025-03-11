<?php
return [
    'module' => [
        [
            'title' => '仪表板',
            'icon' => 'fa fa-database',
            'name' => ['dashboard'],
            'route' => 'dashboard/index',
            'class' => 'special'
        ],
        [
            'title' => '收入报告',
            'icon' => 'fa fa-money',
            'name' => ['report'],
            'subModule' => [
                [
                    'title' => '按时间',
                    'route' => 'report/time'
                ],
                [
                    'title' => '按产品',
                    'route' => 'report/product'
                ],
                [
                    'title' => '按来源',
                    'route' => 'report/customer'
                ],
            ]
        ],
        [
            'title' => '产品',
            'icon' => 'fa fa-cube',
            'name' => ['product','attribute'],
            'subModule' => [
                [
                    'title' => '类别',
                    'route' => 'product/catalogue/index'
                ],
                [
                    'title' => '产品',
                    'route' => 'product/index'
                ],
                [
                    'title' => '属性类型',
                    'route' => 'attribute/catalogue/index'
                ],
                [
                    'title' => '属性',
                    'route' => 'attribute/index'
                ],
            ]
        ],
        [
            'title' => '订单',
            'icon' => 'fa fa-shopping-bag',
            'name' => ['order'],
            'subModule' => [
                [
                    'title' => '订单',
                    'route' => 'order/index'
                ],
            ]
        ],
        [
            'title' => '客户群',
            'icon' => 'fa fa-user',
            'name' => ['customer'],
            'subModule' => [
                [
                    'title' => '群组',
                    'route' => asset('customer/catalogue/index')
                ],
                [
                    'title' => '客户',
                    'route' => 'customer/index'
                ],
            ]
        ],
        [
            'title' => '营销',
            'icon' => 'fa fa-money',
            'name' => ['promotion', 'source'],
            'subModule' => [
                [
                    'title' => '促销',
                    'route' => 'promotion/index'
                ],
                [
                    'title' => '来源',
                    'route' => 'source/index'
                ],
            ]
        ],
        [
            'title' => '文章',
            'icon' => 'fa fa-file',
            'name' => ['post'],
            'subModule' => [
                [
                    'title' => '类别',
                    'route' => 'post/catalogue/index'
                ],
                [
                    'title' => '文章',
                    'route' => 'post/index'
                ]
            ]
        ],
        [
            'title' => '评论',
            'icon' => 'fa fa-comment',
            'name' => ['reviews'],
            'subModule' => [
                [
                    'title' => '评论',
                    'route' => 'review/index'
                ]
            ]
        ],
        [
            'title' => '用户',
            'icon' => 'fa fa-user',
            'name' => ['user','permission'],
            'subModule' => [
                [
                    'title' => '群组',
                    'route' => 'user/catalogue/index'
                ],
                [
                    'title' => '用户',
                    'route' => 'user/index'
                ],
                [
                    'title' => '权限',
                    'route' => 'permission/index'
                ]
            ]
        ],
        [
            'title' => '横幅和幻灯片',
            'icon' => 'fa fa-picture-o',
            'name' => ['slide'],
            'subModule' => [
                [
                    'title' => '幻灯片设置',
                    'route' => 'slide/index'
                ],
            ]
        ],
        [
            'title' => '菜单',
            'icon' => 'fa fa-bars',
            'name' => ['menu'],
            'subModule' => [
                [
                    'title' => '菜单设置',
                    'route' => 'menu/index'
                ],
            ]
        ],
        [
            'title' => '通用设置',
            'icon' => 'fa fa-file',
            'name' => ['language', 'generate', 'system', 'widget'],
            'subModule' => [
                [
                    'title' => '语言',
                    'route' => 'language/index'
                ],
                [
                    'title' => '系统',
                    'route' => 'system/index'
                ],
                [
                    'title' => '小工具',
                    'route' => 'widget/index'
                ],
                
            ]
        ]
    ],
];
