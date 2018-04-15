<?php
use yii\helpers\Html;
use app\assets\MobileAsset;
use app\helper\Functions;
MobileAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/frontend/img/h2t.png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-1862775857754774",
            enable_page_level_ads: true
        });
    </script>
    <style>
        /*Footer*/
        footer .footer-nav {
            color: <?php echo MAIN_COLOR2;?>;
        }
        footer .footer-nav ul li a{
            color: <?php echo MAIN_COLOR2;?>;
        }

        footer .footer-info {
            background: linear-gradient(to right, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
            color: #ffffff;
            padding-top: 20px;
            position: relative;
        }
        /*Header*/
        header .search-block input[type=text] {
            border-radius: 12px;
            border: none;
            background-color: <?php echo MAIN_COLOR2;?>;
            padding: 5px 7px;
            width: 350px;
        }
        header .user-social li a {
            color: <?php echo MAIN_COLOR;?>;
            line-height: 24px;
            padding-left: 10px;
            padding-right: 10px;
        }
        header {
            background: linear-gradient(to right, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
        }
        /*Home*/
        .tab-list-home li {
            font-size: 11px;
            font-family: 'Averta Bold';
            border-right: <?php echo MAIN_COLOR;?> 1px solid;
            display: inline-block;
        }
        .category-block h4 a strong{
			color: #5f5f5f;
			font-size: 16px;
		}
        .category-block h4 a {
            /* line-height: 30px; */
            font-size: 12px;
            float: left;
            color: <?php echo MAIN_COLOR;?>;
        }
        .video-block h4 a {
            line-height: 30px;
            font-size: 12px;
            float: right;
            color: <?php echo MAIN_COLOR;?>;
        }
        /*News*/
        #comment-block .comment-list-block .comment-user-name strong {
            color: <?php echo MAIN_COLOR2;?>;
        }
        /*Profile*/
        #profile-menu-left ul li.active i {
            color: <?php echo MAIN_COLOR2;?>;
        }
        .register-block i{
            font-size: 24px;
            color: <?php echo MAIN_COLOR;?>;
            margin: 5px 3px;
        }
        .profile-tab li.active,.profile-tab li:hover {
            border-color: <?php echo MAIN_COLOR;?>;
        }
        .profile-tab li span{
            height: 28px;
            width: 28px;
            line-height: 28px;
            border-radius: 50%;
            background-color: <?php echo MAIN_COLOR;?>;
            display: inline-block;
            color: #ffffff;
        }
        .profile-tab li:nth-child(2) span{
            background-color: <?php echo MAIN_COLOR2;?>;
        }
        .profile-tab li:nth-child(3) span{
            background-color: <?php echo MAIN_COLOR;?>;
        }
        /*Style*/
        .text-gradiant {
            /*text gradiant*/
            background: -webkit-linear-gradient(left, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        h3 i{
            margin-top: 5px;
            color: <?php echo MAIN_COLOR2;?>;
        }
        .border-gradiant {
            /*border gradiant cube*/
            border: 1px solid transparent;
            -moz-border-image: -moz-linear-gradient(left, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
            -webkit-border-image: -webkit-linear-gradient(left, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
            border-image: linear-gradient(to right, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
            border-image-slice: 1;
        }
        .border-gradiant-round::after {
            position: absolute;
            top: -1px; bottom: -1px;
            left: -1px; right: -1px;
            background: linear-gradient(to right, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
            content: '';
            z-index: -1;
        }
        .pagination li.active a,.pagination li a:hover {
            color: <?php echo MAIN_COLOR2;?>;

        }
        .btn-more {
            display: block;
            line-height: 34px;
            border: 1px solid <?php echo MAIN_COLOR2;?>;
            border-radius: 8px;
            cursor: pointer;
            color: <?php echo MAIN_COLOR2;?>;
            font-weight: bold;
        }
        header .search-input input[type=text]{
            border-radius: 12px;
            border: none;
            background-color: <?php echo MAIN_COLOR2;?>;
            padding: 5px 7px;
        }
        .main-color {
            color: <?php echo MAIN_COLOR;?>;
        }
        .news-detail-info .news-detail-author {
            color: #ed2e7d;
        }
        .news-detail-time {
            font-size: 12px;
            color: #777;
            margin: 0 6px;
        }
    </style>
</head>
<body>
<script type="application/javascript" src="http://adnetwork.adasiaholdings.com/ac?out=js&nwid=2060&siteid=220538&pgname=vn_hoahoctro.vn_outstream&fmtid=44269&tgt=[sas_target]&visit=m&tmstp=[timestamp]&clcturl=[countgo]"></script>
<?php $this->beginBody() ?>
<header>
    <div id="fb-root"></div>

    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <ul class="list-unstyled logo-tag text-center">
            <li><a href="/"><img class="logo" src="/frontend/img/logo-mobile.png"></a></li>
        </ul>
        <form action="/tim-kiem" method="get" id="formSearchHead">
            <div class="search-block pull-right">
                <a onclick="$('#input-search').toggle();">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </div>
            <div class="input-group search-input" style="display: none;margin-bottom: 10px;" id="input-search">
                <input type="text" class="form-control" placeholder="Nhập nội dung cần tìm kiếm..." name="keyword">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Tìm kiếm</button>
                    </span>
            </div>
        </form>
    </div>
    <nav>
        <div class="container">

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav text-uppercase text-center">
                    <?php foreach($this->params['headerMenu'] as $k => $c){?>
                        <li>
                            <a href="/danh-muc/<?=$c['slug'] ?>">
                                <i class="<?=$c['icon'] ?>" aria-hidden="true"></i>
                                <span><?=$c['name'] ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="/clip">
<!--                            <i class="fa fa-film" aria-hidden="true"></i>-->
                            <span>Clip - Ảnh hay</span>
                        </a>
                    </li>
                    <?php foreach($this->params['extraMenu'] as $k => $c){?>
                        <li>
                            <a href="/danh-muc/<?=$c['slug'] ?>">
                                <i class="<?=$c['icon'] ?>" aria-hidden="true"></i>
                                <span><?=$c['name'] ?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
<!--            <div class="no-collapse ">-->
<!--                <ul class="nav navbar-nav text-uppercase text-center">-->
<!--                    --><?php //foreach($this->params['headerMenu'] as $k => $c){?>
<!--                        <li>-->
<!--                            <a href="/danh-muc/--><?//=$c['slug'] ?><!--">-->
<!--                                <i class="--><?//=$c['icon'] ?><!--" aria-hidden="true"></i>-->
<!--                                <span>--><?//=Functions::replace_second_space($c['name']) ?><!--</span>-->
<!--                            </a>-->
<!--                        </li>-->
<!--                    --><?php //} ?>
<!--                    <li>-->
<!--                        <a href="/clip">-->
<!--                            <i class="fa fa-film" aria-hidden="true"></i>-->
<!--                            <span>Clip hay</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    --><?php //foreach($this->params['extraMenu'] as $k => $c){?>
<!--                        <li>-->
<!--                            <a href="/danh-muc/--><?//=$c['slug'] ?><!--">-->
<!--                                <i class="--><?//=$c['icon'] ?><!--" aria-hidden="true"></i>-->
<!--                                <span>--><?//=Functions::replace_second_space($c['name']) ?><!--</span>-->
<!--                            </a>-->
<!--                        </li>-->
<!--                    --><?php //} ?>
<!--                </ul>-->
<!--            </div>-->
        </div>
    </nav>
</header>
<main>
	<?= $content ?>
</main>
<footer>
    <div class="footer-info">
        <div class="container">
            <img src="/frontend/img/logo-mobile.png">
            <p>Cơ quan chủ quản: Trung ương Đoàn Thanh Niên Cộng sản Hồ Chí Minh<br>
                Số giấy phép: 165/GP-BTTTT, cấp ngày 16/08/2011<br>
                Tổng biên tập: Nguyễn Huy Lộc. Tòa soạn: Ô D29 Phạm Văn Bạch, Quận Cầu Giấy, Hà Nội<br>
                Điện thoại: (04) 62 735 735 (168) - Email: banbientap@hoahoctro.vn<br>
				Liên Hệ Quảng Cáo<br>
				Email: quangcao@thieunien.vn<br>
				Hotline :024 62 811 008<br>
                ® Ghi rõ nguồn "Hoa Học Trò" khi bạn phát hành lại thông tin từ website này<br>
                Các trang ngoài sẽ được mở ra ở cửa sổ mới. Hoa Học Trò không chịu trách nhiệm nội dung các trang ngoài</p>
            <div class="clearfix"></div>
        </div>
    </div>
</footer>
<!-- Modal -->
<div class="modal fade" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal_1_title"></h4>
      </div>
      <div class="modal-body" id="modal_1_body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<div class="btn btn-app visible-xs" >
     <?php if (Functions::isIphone()) { ?>
        <a href="https://itunes.apple.com/us/app/h2t-hoa-hoc-tro-online/id1296127514?ls=1&mt=8"><img src="/frontend/img/itune.png"></a>
    
    <?php }?>
    <?php if (Functions::isAndroid()) { ?>
        <a href="https://play.google.com/store/apps/details?id=com.vietdroid.apps.h2tonline"><img src="/frontend/img/gplay.png"></a>
    <?php }?>
    
    <span><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<style type="text/css">
    .btn-app {
        position: fixed;
        bottom: 30px;
        background-color: #ed2e7d;
        border: solid 1px #fff;
        color: #fff;
        font-weight: bold;
        border-radius: 30px;
        width: 60%;
        left: 20%;
        line-height: 25px;
        padding-left: 20px;
        text-align: left;
    }
    .btn-app a{
        color: #fff;
    }
    .btn-app img {
    	width: 80%
    }
    .btn-app span {
        position: absolute;
        right: 20px;
        z-index: 10;
        top: 15px
    }
</style>


<?php $this->endBody() ?>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '924720127671404',
            xfbml      : true,
            version    : 'v2.7'
        });
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52373313-2', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
<?php $this->endPage() ?>

<script type="text/javascript">
    $('.btn-app span').on('click',function(){
        $('.btn-app').addClass('hidden').removeClass('visible-xs');
    });

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    // var show = getCookie('show');
    // console.log(show);
    // if((show != 1) && detail) {
    //     $('#showModalDownload').modal();
    //     setCookie('show',1,1);
    // }
</script>