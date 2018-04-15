<?php

return [
    'zzz' => 'site/test',
    'login' => 'site/login',
    'about' => 'site/about',
    'clear' => 'site/clear',
    'ajax-show-more-news' => 'ajax',
    'ajax-send-comment' => 'ajax/comment',
    'ajax-show-more-video' => 'ajax/video',
    'ajax-show-more-event' => 'ajax/event',
    'ajax-load-news-live' => 'ajax/live',
    'ajax-show-more-search' => 'ajax/search',
    'ajax-show-more-comment' => 'ajax/comments',
    'ajax-show-more-item' => 'ajax/item',
    'danh-muc/<slug:[0-9-a-zA-Z]+>' => 'category',
    'danh-muc/<slug:[0-9-a-zA-Z]+>/<slug_child:[0-9-a-zA-Z]+>' => 'category',
    'tag/<slug:[0-9-a-zA-Z]+>' => 'tag',
    'tin-tuc/<category_id:[0-9]+>/<slug:[0-9-a-zA-Z]+>' => 'news',
    'tin-tuc/<slug:[0-9-a-zA-Z]+>' => 'news',
    'video/<slug:[0-9-a-zA-Z]+>' => 'video/detail',
    'clip' => 'video',
    'clip/<slug:[0-9-a-zA-Z]+>' => 'video/detail',
    'thong-tin-ca-nhan' => 'user/profile',
    'thong-tin-dang-nhap' => 'user/account',
    'dang-nhap' => 'user/login',
    'thoat' => 'user/logout',
    'dang-ky' => 'user/register',
    'su-kien/<slug:[0-9-a-zA-Z]+>' => 'event',
    'su-kien/<event_id:[0-9]+>/<slug:[0-9-a-zA-Z]+>' => 'event/detail',
    'tim-kiem' => 'search',
	'gui-bai-viet' => 'news/post_submit',
	
	'rss/<category_id:[0-9]+>/<slug:[0-9-a-zA-Z]+>.rss' => 'rss/list',
	
	
	[
        'pattern' => 'quang-cao-tren-bao-hoa-hoc-tro',
        'route' => 'news/index',
        'defaults' => ['slug' => 'quang-cao-tren-bao-hoa-hoc-tro'],
    ],
];