<?php

return array(
	'index' => array(
		'name' => '首页',
		'icon' => 'home',
		'uri' => 'admin/index/main',
		'menu' => array(
		),
	),
	'system' => array(
		'name' => '系统配置',
		'icon' => 'cog',
		'menu' => array(
			array(
				'name' => '系统参数',
				'icon' => 'cog',
				'uri' => 'admin/index/config',
			),
			array(
				'name' => '管理员',
				'icon' => 'user',
				'uri' => 'admin/user/index',
			),
			array(
				'name' => '角色权限',
				'icon' => 'users',
				'uri' => 'admin/auth/index',
			),
//            array(
//                'name' => '短信系统',
//                'icon' => 'envelope',
//                'uri' => 'admin/sms/index',
//            ),
		),
	),
	'syslog' => array(
		'name' => '系统安全',
		'icon' => 'shield',
		'menu' => array(
			array(
				'name' => '操作日志',
				'icon' => 'calendar',
				'uri' => 'admin/index/log',
			),
			array(
				'name' => '攻击日志',
				'icon' => 'calendar-times-o',
				'uri' => 'admin/index/attack',
			),
			array(
				'name' => '禁止访问',
				'icon' => 'close',
				'uri' => 'admin/ip/index',
			),
		),
	),
	'site' => array(
		'name' => '网站管理',
		'icon' => 'cubes',
		'menu' => array(
			array(
				'name' => '栏目管理',
				'icon' => 'navicon',
				'uri' => 'admin/category/index',
			),
            array(
                'name' => '模型管理',
                'icon' => 'database',
                'url' => url('admin/model/index', array('typeid' => 1)),
            ),
			array(
				'name' => '附件管理',
				'icon' => 'folder',
				'uri' => 'admin/attachment/index',
			),
			array(
				'name' => '推送区域',
				'icon' => 'flag',
				'uri' => 'admin/position/index',
			),
			array(
				'name' => '标签管理',
				'icon' => 'tag',
				'uri' => 'admin/tag/index',
			),
			array(
				'name' => '内容内链',
				'icon' => 'retweet',
				'uri' => 'admin/relatedlink/index',
			),
		),
	),
	'content' => array(
		'name' => '内容管理',
		'icon' => 'television',
		'menu' => array(
			array('test'),
		),
	),
	'html' => array(
		'name' => '内容生成',
		'icon' => 'refresh',
		'menu' => array(
			array(
				'name' => '更新URL',
				'icon' => 'refresh',
				'uri' => 'admin/content/updateurl',
			),
			array(
				'name' => '生成选项',
				'icon' => 'refresh',
				'uri' => 'admin/html/index',
			),
			array(
				'name' => '生成SiteMap',
				'icon' => 'sitemap',
				'uri' => 'admin/index/updatemap',
			),
		),
	),
    'member' => array(
        'name' => '会员管理',
        'icon' => 'user',
        'menu' => array(
            array(
                'name' => '会员管理',
                'icon' => 'user',
                'uri' => 'admin/member/index',
            ),
            array(
                'name' => '会员组',
                'icon' => 'users',
                'uri' => 'admin/member/group',
            ),
            array(
                'name' => '短消息',
                'icon' => 'envelope',
                'uri' => 'admin/member/pms',
            ),
            array(
                'name' => '会员参数配置',
                'icon' => 'cog',
                'uri' => 'admin/member/config',
            ),
        ),
    ),
	'weixin' => array(
		'name' => '微信公众号',
		'icon' => 'weixin',
		'menu' => array(
//			array('name' => lang('dr019'), 'url' => url('admin/wx/config'),    'icon' => 'cog'),
//			array('name' => lang('dr020'), 'url' => url('admin/wx/index'),    'icon' => 'weixin'),
//			array('name' => lang('dr021'), 'url' => url('admin/wx/keyword'),    'icon' => 'tag'),
//			array('name' => lang('dr023'), 'url' => url('admin/wx/menu'),    'icon' => 'table'),
//			array('name' => lang('dr024'), 'url' => url('admin/wx/user'),    'icon' => 'user'),
		)
	),
);
