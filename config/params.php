<?php

return [
    'adminEmail' => 'admin@example.com',
    'role_name' => [
        ROLE_ADMIN => 'Admin',
        ROLE_CONTRIBUTOR => 'Contributor',
        ROLE_EDITOR => 'Editor',
        ROLE_AUTHOR => 'Author',
        ROLE_SUBSCRIBER => 'Subscriber',
        ROLE_USER => 'User',
    ],
    'news_types' => [
        0 => 'Bài viết thường',
        1 => 'Infographic', 
        2 => 'Video', 
        3 => 'Bài viết trực tiếp',
        5 => 'Bài viết so sánh',
    ],
    'block_list' => [
        0 => 'Không',
        1 => 'Một bài lớn 2 bài con bên phải 4 bài trượt bên dưới.',
        2 => '6 Bài hai hàng', 
        3 => 'Hai lớn 2 bên 4 tiêu đề phía dưới mỗi bên', 
        4 => 'Bốn bài dàn hàng ngang',
        5 => '3 bài dàn hàng ngang, 6 bài chạy slide bên dưới.',
        6 => 'cột cao 4 bài',
    ],
    'actions' => [
        101 => 'Đăng bài',
        102 => 'Sửa bài',
        103 => 'Xoá bài',
        104 => 'Ghi note bài viết',
        105 => 'Chuyển trạng thái nháp',
        106 => 'Gửi biên tập',
        107 => 'Gửi xuất bản',
        108 => 'Xuất bản bài',
        109 => 'Thêm nội dung bài trực tiếp',
        110 => 'Trả lại bài',
        
        201 => 'Tạo chuyên mục',
        202 => 'Sửa chuyên mục',
        203 => 'Xoá chuyên mục',
        
        301 => 'Tạo tag',
        302 => 'Sửa tag',
        303 => 'Xoá tag',
        
        401 => 'Tạo user',
        402 => 'Sửa user',
        403 => 'Xoá user',
        
        501 => 'Tạo chủ đề',
        502 => 'Sửa chủ đề',
        503 => 'Xoá chủ đề',
        504 => 'Yêu cầu nhận chủ đề',
        505 => 'Đồng ý yêu cầu nhận chủ đề',
        506 => 'Từ chối yêu cầu nhận chủ đề',
        507 => 'Bỏ nhận chủ đề',
        
        601 => 'Duyệt comment',
        602 => 'Bỏ duyệt comment',
        603 => 'Xoá comment',
        
        701 => 'Tạo quảng cáo',
        702 => 'Sửa quảng cáo',
        703 => 'Xóa quảng cáo',
        
        801 => 'Tạo sự kiện',
        802 => 'Sửa sự kiện',
        803 => 'Xóa sự kiện',
        
        903 => 'Xóa bài gửi',
        
        
        
    ],
    'log_reference_type' => [
        'news' => 'Tin tức',
        'category' => 'Chuyên mục',
        'subject' => 'Chủ đề',
        'comment' => 'Bình luận',
        'tag' => 'Tag',
        'user' => 'User',
        'ads' => 'Quảng cáo',
        'event' => 'Sự kiện',
        'user_post' => 'Bài gửi',
    ],
    'category_position' => [
        0 => 'Không',
        101 => 'Bên trái -  vị trí 1',
        102 => 'Bên trái -  vị trí 2',
        103 => 'Bên trái -  vị trí 3',
        104 => 'Bên trái -  vị trí 4',
        105 => 'Bên trái -  vị trí 5',
        106 => 'Bên trái -  vị trí 6',
        107 => 'Bên trái -  vị trí 7',
        108 => 'Bên trái -  vị trí 8',
        109 => 'Bên trái -  vị trí 9',
        110 => 'Bên trái -  vị trí 10',
        111 => 'Bên trái -  vị trí 11',
        112 => 'Bên trái -  vị trí 12',
        113 => 'Bên trái -  vị trí 13',
        114 => 'Bên trái -  vị trí 14',
        115 => 'Bên trái -  vị trí 15',
        
        201 => 'Bên phải -  vị trí 1',
        202 => 'Bên phải -  vị trí 2',
        203 => 'Bên phải -  vị trí 3',
        204 => 'Bên phải -  vị trí 4',
        205 => 'Bên phải -  vị trí 5',
        206 => 'Bên phải -  vị trí 6',
        207 => 'Bên phải -  vị trí 7',
        208 => 'Bên phải -  vị trí 8',
        209 => 'Bên phải -  vị trí 9',
        210 => 'Bên phải -  vị trí 10',
        211 => 'Bên phải -  vị trí 11',
        212 => 'Bên phải -  vị trí 12',
        213 => 'Bên phải -  vị trí 13',
        214 => 'Bên phải -  vị trí 14',
        215 => 'Bên phải -  vị trí 15',
    ],
    'ads_type' => [
        ADS_TYPE_BANNER => 'Banner',
        ADS_TYPE_HTML => 'HTML',
    ],
    'ads_show_type' => [
        ADS_SHOW_TYPE_SINGLE => 'Quảng cáo đơn',
        ADS_SHOW_TYPE_SLIDE => 'Slide',
    ],
    'header_config' => [
        'logo_header' => [
            'name' => 'Logo header',
            'type' => 'text_image',
        ],
        'search_position' => [
            'name' => 'Vị trí ô tìm kiếm',
            'type' => 'select',
            'options' => [
                'left' => 'Trái',
                'center' => 'Giữa',
                'right' => 'Phải',
            ],
        ],
//        'tag_position' => [
//            'name' => 'Vị trí thẻ tag',
//            'type' => 'select',
//            'options' => [
//                'left' => 'Trái',
//                'center' => 'Giữa',
//                'right' => 'Phải',
//            ],
//        ],
        'user_position' => [
            'name' => 'Vị trí người dùng',
            'type' => 'select',
            'options' => [
                'up' => 'Trên',
                'down' => 'Dưới',
            ],
        ],
    ],
    'footer_config' => [
        'logo_footer' => [
            'name' => 'Logo footer',
            'type' => 'text_image',
        ],
        'info_ads_position' => [
            'name' => 'Vị trí công ty và quảng cáo',
            'type' => 'select',
            'options' => [
                'c-a' => 'Thông tin công ty trái - Thông tin quảng cáo phải',
                'a-c' => 'Thông tin công ty phải - Thông tin quảng cáo trái',
            ],
        ],
        'info_content' => [
            'name' => 'Nội dung thông tin công ty',
            'type' => 'text',
        ],
        'ads_content' => [
            'name' => 'Nội dung thông tin quảng cáo',
            'type' => 'text',
        ],
        'note_position' => [
            'name' => 'Vị trí lưu ý',
            'type' => 'select',
            'options' => [
                'left' => 'Trái',
                'center' => 'Giữa',
                'right' => 'Phải',
            ],
        ],
        'note_content' => [
            'name' => 'Nội dung lưu ý',
            'type' => 'text',
        ],
    ],
];
