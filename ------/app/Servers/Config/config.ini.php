<?php

return array(
    'DOMAIN'                  => 'cmiddle.app:8080',

    'SITE_ADMINLOG'           => true,   //后台操作日志开关
	'SITE_BDPING'             => false,  //百度Ping推送
	'SYS_ILLEGAL_CHAR'        => false,  //禁止非法字符提交
	'SYS_MEMBER'              => false,  //禁止使用会员功能
	'SYS_ATTACK_LOG'          => true,   //系统攻击日志开关
	'SYS_ATTACK_MAIL'         => false,  //是否发送邮件通知管理员
	'SITE_ADMIN_CODE'         => false,  //后台登录验证码开关
	'SITE_ADMIN_PAGESIZE'     => '8',  //后台数据分页条数
	'SITE_SYSMAIL'            => '',  //用来接收网站的一些系统邮件
	'SYS_GEE_CAPTCHA_ID'      => '053960849a89ff17c0e0858a821f3686',  //极验验证ID
	'SYS_GEE_PRIVATE_KEY'     => '54140d3df408cef8be1904c2aa7fed8c',  //极验验证KEY

	'SITE_MAP_UPDATE'         => '30',  //更新周期，单位为分钟搜索引擎将遵照此周期访问该页面，使页面上的新闻更及时地出现在百度新闻中
	'SITE_MAP_TIME'           => '10',  //天之内
	'SITE_MAP_NUM'            => '30',  //条数据
	'SITE_MAP_AUTO'           => false,  //自动生成开关，开启之后系统更新内容时XML会自动更新
	'SITE_SEARCH_PAGE'        => '2',  //搜索列表页显示数量
	'SITE_SEARCH_DATA_CACHE'  => '',  //搜索结果缓存时间，单位秒
	'SITE_SEARCH_URLRULE'     => '',  //内容搜索URL规则
	'SITE_SEARCH_TYPE'        => '1',  //搜索类型，1：普通搜索，2：Sphinx
	'SITE_SEARCH_INDEX_CACHE' => '',  //搜索索引缓存时间，单位小时
	'SITE_SEARCH_KW_FIELDS'   => 'title,keywords,description',  //参数kw匹配字段，如title,keywords
	'SITE_SEARCH_KW_OR'       => true,  //针对多个字段匹配，默认AND条件筛选
	'SITE_SEARCH_SPHINX_HOST' => '',  //Sphinx服务器地址
	'SITE_SEARCH_SPHINX_PORT' => '',  //Sphinx服务器端口号
	'SITE_SEARCH_SPHINX_NAME' => '',  //Sphinx索引名称，默认title
	'SITE_KEYWORD_NUMS'       => '',  //关键词页面的信息数量
	'SITE_TAG_LINK'           => false,  //是否自动将TAG链接作为文档内链
	'SITE_KEYWORD_CACHE'      => '',  //关键词页面的信息缓存时间，单位小时
	'SITE_TAG_PAGE'           => '',  //TAG列表页显示数量
	'SITE_TAG_CACHE'          => '',  //TAG列表缓存时间，单位小时
	'SITE_TAG_URLRULE'        => '',  //TAG列表URL规则
	'SITE_TAG_URL'            => '',  //TAG的URL规则

    'SYS_EDITOR'              => 'ueditor',  //系统编辑器设置，默认kindeditor（自定义编辑器直接填写目录名称，如ueditor）
    'SYS_CAPTCHA_MODE'        => '0',  //验证码输出模式：0,普通模式；1,兼容模式，若验证码显示不正常可在此调整输出模式

    'SITE_EXTEND_ID'          => '0',  //
    'SITE_LANGUAGE'           => 'zh-cn',  //
    'SITE_TIMEZONE'           => '8',  //
    'SITE_THEME'              => 'new',  //
    'SITE_NAME'               => 'finecms',  //
    'SITE_TITLE'              => 'finecms',  //
    'SITE_KEYWORDS'           => 'finecms',  //
    'SITE_DESCRIPTION'        => 'finecms',  //
    'SITE_BOTTOM_INFO'        => '&lt;p&gt;finecms&lt;/p&gt;',  //
    'SITE_WATERMARK'          => '0',  //
    'SITE_WATERMARK_ALPHA'    => '',  //
    'SITE_WATERMARK_TEXT'     => '',  //
    'SITE_WATERMARK_SIZE'     => '',  //
    'SITE_WATERMARK_IMAGE'    => '',  //
    'SITE_WATERMARK_POS'      => '',  //
    'SITE_THUMB_TYPE'         => '0',  //
    'SITE_THUMB_WIDTH'        => '',  //
    'SITE_THUMB_HEIGHT'       => '',  //
    'SITE_TIME_FORMAT'        => 'Y-m-d',  //
    'SITE_MOBILE'             => '',  //
    'SITE_MURL'               => '',  //
    'SITE_ICP'                => 'ICP备案序号',  //
    'SITE_JS'                 => '',  //
);