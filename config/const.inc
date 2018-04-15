<?php

define("MEDIA_SERVER", 'http://cdn.hoahoctro.vn');
define("SESSION_TYPE" , "file");
define("MEMCACHE_SESSION_HOST", '127.0.0.1');
define("MEMCACHE_SESSION_PORT", 11211);

define("SOLR_SEARCH", true);
define("SOLR_SERVER_HOSTNAME", 'localhost');
define("SOLR_SERVER_PORT", 8983);

define("IMAGE_POST_MAX_SIZE", 5);
define("FILE_POST_MAX_SIZE", 7);
define("ADMIN_ROW_PER_PAGE", 20);
define("SEARCH_ROW_PER_PAGE", 20);
define("RELATED_COUNT_ITEM", 5);

define("STATUS_DELETED", -9);
define("STATUS_ACTIVE", 1);
define("STATUS_INACTIVE", 0);

define("NEWS_STATUS_CANCELED", -2);
define("NEWS_STATUS_PENDDING_REVIEW", -1);
define("NEWS_STATUS_DRAFT", 0);
define("NEWS_STATUS_APPROVED", 1);
define("NEWS_STATUS_PUBLISHED", 2);


define("ROLE_ADMIN", 1);
define("ROLE_USER", 2); //user thường
define("ROLE_CONTRIBUTOR", 3); //Trưởng ban biên tập, xuất bản
define("ROLE_EDITOR", 4); //Biên tập biên
define("ROLE_AUTHOR", 5); //Phóng viên
define("ROLE_SUBSCRIBER", 6); //Cộng tác viên

define("ACTIVITY_TYPE_CREATE", "C");
define("ACTIVITY_TYPE_UPDATE", "U");
define("ACTIVITY_TYPE_DELETE", "D");


define("ADS_TYPE_BANNER", 0);
define("ADS_TYPE_HTML", 1);

define("ADS_SHOW_TYPE_SINGLE", 0);
define("ADS_SHOW_TYPE_SLIDE", 1);

define("MAIN_COLOR", '#ed2e7d');
define("MAIN_COLOR2", '#ed2e7d');
