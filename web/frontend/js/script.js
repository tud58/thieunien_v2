var loading = false;
function show_more_news() {
    if (loading) {
        return false;
    }
    var is_next = $("#is_next").val();
    if (is_next == 0) {
        return false;
    }
    loading = true;
    //$('#loading-layer').html('<img src="/frontend/img/ajax-loader.gif" style="width: 16px;height: 16px" hspace="5"/>');
    var anchor_index = parseInt($("#anchor_index").val()) + 1;
    var category_id = parseInt($("#category_id").val());
    var tag_id = parseInt($("#tag_id").val());
    var type = $("#type").val();
    var newsIds = $('.out-id').map(function () {
        return parseInt($(this).attr('data-news-id'));
    }).get();
//    console.log(newsIds);
    var data = {'category_id': category_id, 'tag_id': tag_id, 'type': type, 'anchor_index': anchor_index,newsIds:newsIds
    };
    $.ajax({
        url: "/ajax-show-more-news",
        data: data,
        type: "POST",
        success: function (msg) {
            //$('#loading-layer').html('Xem thêm');
            $("#list_items").append(msg);
            $("#anchor_index").val(anchor_index);
            loading = false;
        }
    });
    return false;
}
function show_more_item() {
    return;
    console.log('showmore');
    if (loading) {
        return false;
    }
    var is_next = $("#is_next").val();
    if (is_next == 0) {
        return false;
    }
    loading = true;
    //$('#loading-layer').html('<img src="/frontend/img/ajax-loader.gif" style="width: 16px;height: 16px" hspace="5"/>');
    var anchor_index = parseInt($("#anchor_index").val()) + 1;
    var category_id = parseInt($("#category_id").val());
    var tag_id = parseInt($("#tag_id").val());
    var news_id = parseInt($("#news_id").val());

    var data = {'category_id': category_id, 'tag_id': tag_id, 'news_id': news_id, 'anchor_index': anchor_index
    };
    console.log(data);

    console.log(document.getElementById("category_id"));
    $.ajax({
        url: "/ajax-show-more-item",
        data: data,
        type: "POST",
        success: function (msg) {
            //$('#loading-layer').html('Xem thêm');
            $("#more-news").append(msg);
            $("#anchor_index").val(anchor_index);
            loading = false;
        }
    });
    return false;
}
function show_more_video() {
    if (loading) {
        return false;
    }
    var is_next = $("#is_next").val();
    if (is_next == 0) {
        return false;
    }
    loading = true;
    //$('#loading-layer').html('<img src="/frontend/img/ajax-loader.gif" style="width: 16px;height: 16px" hspace="5"/>');
    var anchor_index = parseInt($("#anchor_index").val()) + 1;
    var video_id = parseInt($("#video_id").val());

    var data = {'video_id': video_id, 'anchor_index': anchor_index
    };
    $.ajax({
        url: "/ajax-show-more-video",
        data: data,
        type: "POST",
        success: function (msg) {
            //$('#loading-layer').html('Xem thêm');
            $("#list_items").append(msg);
            $("#anchor_index").val(anchor_index);
            loading = false;
        }
    });
    return false;
}
function show_more_event() {
    if (loading) {
        return false;
    }
    var is_next = $("#is_next").val();
    if (is_next == 0) {
        return false;
    }
    loading = true;
    //$('#loading-layer').html('<img src="/frontend/img/ajax-loader.gif" style="width: 16px;height: 16px" hspace="5"/>');
    var anchor_index = parseInt($("#anchor_index").val()) + 1;
    var event_id = parseInt($("#event_id").val());
    var news_id = parseInt($("#news_id").val());

    var data = {'event_id': event_id, 'news_id': news_id, 'anchor_index': anchor_index
    };
    $.ajax({
        url: "/ajax-show-more-event",
        data: data,
        type: "POST",
        success: function (msg) {
            //$('#loading-layer').html('Xem thêm');
            $("#list_items").append(msg);
            $("#anchor_index").val(anchor_index);
            loading = false;
        }
    });
    return false;
}
function show_more_comment() {
    if (loading) {
        return false;
    }
    var next_comment = $("#next_comment").val();
    var news_id = parseInt($("#news_id").val());
    if (next_comment == 0 || !news_id) {
        return false;
    }
    loading = true;
    $('#loading-layer').html('<img src="/frontend/img/ajax-loader.gif" style="width: 16px;height: 16px" hspace="5"/>');
    var index_comment = parseInt($("#index_comment").val()) + 1;

    var data = {'news_id': news_id, 'index_comment': index_comment
    };
    $.ajax({
        url: "/ajax-show-more-comment",
        data: data,
        type: "POST",
        success: function (msg) {
            $('#loading-layer').html('Xem thêm bình luận khác');
            $("#list_comments").append(msg);
            $("#index_comment").val(index_comment);
            loading = false;
        }
    });
    return false;
}
function show_more_search() {
    if (loading) {
        return false;
    }
    var is_next = $("#is_next").val();
    if (is_next == 0) {
        return false;
    }
    loading = true;
    //$('#loading-layer').html('<img src="/frontend/img/ajax-loader.gif" style="width: 16px;height: 16px" hspace="5"/>');
    var anchor_index = parseInt($("#anchor_index").val()) + 1;
    var keyword = $("#keyword").val();

    var data = {'keyword': keyword, 'anchor_index': anchor_index
    };
    $.ajax({
        url: "/ajax-show-more-search",
        data: data,
        type: "POST",
        success: function (msg) {
            //$('#loading-layer').html('Xem thêm');
            $("#list_items").append(msg);
            $("#anchor_index").val(anchor_index);
            loading = false;
        }
    });
    return false;
}
function send_comment(comment_id) {
    if (loading) {
        return false;
    }
    loading = true;
    var message = $("#message").val();
    var news_id = parseInt($("#news_id").val());

    var data = {'message': message, 'news_id': news_id, 'comment_id': comment_id
    };
    $.ajax({
        url: "/ajax-send-comment",
        data: data,
        type: "POST",
        success: function (msg) {
            showModal('Thông báo', msg);
            $("#message").val('');
            loading = false;
        }
    });
    return false;
}
function loadNews() {
    if (loading) {
        return false;
    }
    loading = true;
    var news_id = parseInt($("#news_id").val());
    var live_index = parseInt($("#live_index").val());
    var data = {'news_id': news_id, 'live_index': live_index
    };
    $.ajax({
        url: "/ajax-load-news-live",
        data: data,
        type: "POST",
        success: function (msg) {
            $("#news-live").prepend(msg);
            loading = false;
        }
    });
    return false;
}
function infinity(page) {
    $(window).scroll(function () {
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 500) {
            if (page == "video")
                show_more_video();
            else if (page == "category")
                show_more_news();
            else if (page == "search")
                show_more_search();
            else if (page == "event")
                show_more_event();
            else if (page == "item")
                show_more_item();
        }
    });
}
$(document).ready(function () {
    var setting = { items: 4,
        loop: true,
        nav: true,
        navText: ['<i class="fa fa-long-arrow-left"  aria-hidden="true"></i>', '<i class="fa fa-long-arrow-right"  aria-hidden="true"></i>'],
        autoplayTimeout: 3000,
        dots: false,
        margin: 10,
        autoplay: true,
        responsive: {
            767: {
                mergeFit: true
            },
            1024: {
                mergeFit: false
            },
            480: {
                mergeFit: true
            },
            320: {
                mergeFit: true
            }
        }
    }
    //$("#group-news-slide").owlCarousel(setting);
    setting['pagination'] = false;
    setting['navigation'] = true;
    $(".owl-carousel.home").owlCarousel(setting);

    setting['items'] = 6;
    $(".owl-carousel.video").owlCarousel(setting);

    setting['items'] = 3;
    setting['dots'] = false;
    $(".owl-carousel.daily-hot").owlCarousel(setting);

    setting['items'] = 4;
    setting['dots'] = false;
    $(".owl-carousel.category").owlCarousel(setting);
    //$(".owl-carousel.home").each(function(index, crousel) {
    //    crousel.owlCarousel({
    //        items:4,
    //        loop:true,
    //        nav:true,
    //        navText:['<img src="img/prev.png">','<img src="img/next.png">'],
    //        autoplayTimeout:3000,
    //        dots:true,
    //        margin:10,
    //        autoplay:true,
    //        responsive:{
    //            767:{
    //                mergeFit:true
    //            },
    //            1024:{
    //                mergeFit:false
    //            },
    //            480:{
    //                mergeFit:true
    //            },
    //            320:{
    //                mergeFit:true
    //            }
    //        }
    //    });
    //});

    $("#focus-week ul.tabs-header li a").click(function () {
        $(this).parent().parent().find('a').attr('class', '').find('span').hide();
        $(this).attr('class', 'border-gradiant-round border-radius-12').find('span').show();
    });
    $("#news-hot-event .news-hot-video-event ul.tabs-header li a").click(function () {
        $(this).parent().parent().find('a').attr('class', '').find('span').hide();
        $(this).attr('class', 'border-gradiant-round border-radius-12').find('span').show();
    });
    $('video').click(function () {
        this.paused ? this.play() : this.pause();
    });
    $(".input-search-head").is(":focus");

    //dunghq - adv
    /*   var elementHeader = $("main").offset().top;
     // on page load:
     var xHeader = $(window).scrollTop();
     if (xHeader >= elementHeader){
     $('.scroll').addClass('on-scroll');
     $('.scroll .scroll-container').addClass('container');
     } else {
     $('.scroll').removeClass('on-scroll');
     $('.scroll .scroll-container').removeClass('container');
     }
     // on scroll:
     $(window).scroll(function(){
     var yHeader = $(window).scrollTop();
     console.log(yHeader + ' ' + elementHeader);
     if (yHeader >= elementHeader){
     $('.scroll').addClass('on-scroll');
     $('.scroll .scroll-container').addClass('container ');
     } else {
     $('.scroll').removeClass('on-scroll');
     $('.scroll .scroll-container').removeClass('container');
     }
     }); */

    // $(".img-compare").twentytwenty();
    // $(".img-compare").slider({
    //     showInstruction: false
    // });
});
$(document).keypress(function (e) {
    if (e.which == 13) {
        if ($("#input-search-head").is(":focus"))
            $("#formSearchHead").submit();
    }
});

function showModal(title, body) {
    $('#modal_1_title').html(title);
    $('#modal_1_body').html(body);
    $('#modal_1').modal('toggle');
}


/* var wsUri = "ws://123.31.47.6:1221";
 websocket = new WebSocket(wsUri);
 websocket.onopen = function(evt) { onOpen(evt) };

 function onOpen(evt)
 {
 console.log('open');
 } */

//var wsUri = "ws://echo.websocket.org/";
//     var wsUri = "ws://127.0.0.1:1221";
/*     var wsUri = "ws://123.31.47.6:1221";
 var output;
 var numberConnection = 2;
 var websocket = [];
 function init()
 {
 //output = document.getElementById("output");


 console.log(numberConnection);
 for(let i = 0; i < numberConnection; i++){
 testWebSocket(i);
 }
 }

 function testWebSocket(i)
 {
 websocket[i] = new WebSocket(wsUri);
 websocket[i].onopen = function(evt) { onOpen(i, evt) };
 websocket[i].onclose = function(evt) { onClose(i, evt) };
 websocket[i].onmessage = function(evt) { onMessage(i, evt) };
 websocket[i].onerror = function(evt) { onError(i, evt) };
 }

 function onOpen(i, evt)
 {
 writeToScreen(i, "CONNECTED");
 doSend(i, '{"cmdId":6900}'); //init cmd
 }

 function onClose(i, evt)
 {
 writeToScreen(i, "DISCONNECTED");
 }

 function onMessage(i, evt)
 {
 writeToScreen(i, '<span style="color: blue;">RESPONSE: ' + evt.data+'</span>');
 //websocket[i].close();
 }

 function onError(i, evt)
 {
 writeToScreen(i, '<span style="color: red;">ERROR:</span> ' + evt.data);
 console.log('evt_' + i);
 console.log(evt);
 }

 function doSend(i, message)
 {
 writeToScreen(i, "SENT: " + message);
 websocket[i].send(message);
 }

 function writeToScreen(i, message)
 {
 console.log(i + '-' + message.substr(0, 20));
 //output.innerHTML = i + '_' + message + '<br/>' + output.innerHTML;
 }


 window.addEventListener("load", function(){
 console.log('zz');
 setTimeout(function(){

 init();
 }, 1000);
 }, false);
 */