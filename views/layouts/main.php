<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\helper\Functions;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<!-- Google Tag Manager -->
<!--<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-ND5G27C');</script>-->
<!-- End Google Tag Manager -->
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/frontend/img/h2t.png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

	<meta property="fb:app_id" content="924720127671404" />
	<meta property="og:url" content="<?=Yii::$app->request->hostInfo  . Yii::$app->request->url?>" />
	<meta property="og:locale" content="vi_VN" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?= Html::encode($this->title) ?>" />

	<meta property="og:site_name" content="Hoa Hoc Tro Magazine" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="H2T - Hoa Hoc Tro Magazine" />
	<meta name="twitter:creator" content="@hoahoctro_vn" />
	<meta property="og:description" content="<?= isset($this->params['meta_description'])?$this->params['meta_description']:'Tờ báo dành cho thế hệ học trò mới'?>" />
	<meta property="og:image" content="<?= isset($this->params['meta_image'])?$this->params['meta_image']:'http://thieunien.abc/frontend/img/logo-share.png'?>" />
	<meta property="fb:pages" content="935497643253702" />
	<meta name="eclick_verify" content="dFBVX1YXLRcYGVlEagsDCAsEJhceBk0dKw=="/>
    <?php $this->head() ?>

    <link href="/frontend/css/header.css?t=<?=time()?>" rel="stylesheet">
    <link href="/frontend/css/home.css?t=<?=time()?>" rel="stylesheet">
    <link href="/frontend/css/news.css?t=<?=time()?>" rel="stylesheet">
    <link href="/frontend/css/style.css?t=<?=time()?>" rel="stylesheet">


    <style>
        .footer-content {
            border-top: 15px solid <?php echo MAIN_COLOR;?>;
            padding-top: 10px;
            padding-left: 0;
            padding-right: 0;
        }



        .footer-set-homepage i {
            color: <?php echo MAIN_COLOR;?>;
        }

        footer .price {
            border-radius: 20px;
            color: <?= MAIN_COLOR ?> !important;
            font-size: 14px;
            border: 1px solid <?= MAIN_COLOR ?>;
            padding: 5px 10px;
            text-transform: uppercase;
        }
/*
        footer .footer-info {
            background: linear-gradient(to right, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
            color: #ffffff;
            padding-top: 20px;
            position: relative;
        }
*/

        header .nav li a strong {
            border-bottom: 2px solid <?php echo MAIN_COLOR;?>;
        }

        header nav {
            background: linear-gradient(to right, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
        }

        header .navbar-nav li .dropdown-menu {
            background-color:<?php echo MAIN_COLOR;?>;
            border:none;
            margin-left: 25px;
        }

        .text-gradiant {
            /*text gradiant*/
            background: -webkit-linear-gradient(left, <?php echo MAIN_COLOR2;?>, <?php echo MAIN_COLOR;?>);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        #profile-menu-left ul li.active i {
            color: <?php echo MAIN_COLOR2;?>;
        }

        h3 i{
            margin-top: 5px;
            color: <?php echo MAIN_COLOR2;?>;
        }
        .search-block a {
            color: <?php echo MAIN_COLOR2;?>;
        }
        .footer-nav h4 a{
            color: <?php echo MAIN_COLOR2;?>;
        }
        .owl-controls .owl-dot.active span {
            background: none repeat scroll 0 0 <?php echo MAIN_COLOR2;?>;
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
        .register-block i{
            font-size: 24px;
            color: <?php echo MAIN_COLOR;?>;
            margin: 5px 3px;
        }
        #comment-block .comment-list-block .comment-user-name strong {
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
        .btn-more:hover {
            color: #fff;
            background: <?php echo MAIN_COLOR2;?>;
        }
        ul.events li i {
            font-size: 12px;
            width: 25px;
            color: <?php echo MAIN_COLOR2;?>;
        }
        ul.news-popular li i {
            font-size: 12px;
            width: 25px;
            color: <?php echo MAIN_COLOR;?>;
        }
        .child-category li.active a{
            color:<?php echo MAIN_COLOR;?>;
            font-weight:bold;
        }
        header .search-block {
            color: <?php echo MAIN_COLOR2;?>;
            display: inline-block;
            margin-top: 10px;
            margin-left: 10px;
        }
        footer .footer-nav {
            color: <?php echo MAIN_COLOR2;?>;
        }
        footer .footer-nav ul li a{
            color: <?php echo MAIN_COLOR2;?>;
            font-weight: bold;
        }
        header .search-block input[type=text] {
            border-radius: 12px;
            border: none;
            background-color: <?php echo MAIN_COLOR2;?>;
            color: #ffffff;
            padding: 4px 7px;
            width: 500px;
        }
        header .user-social li a {
            color: <?php echo MAIN_COLOR;?>;
            line-height: 24px;
            padding-left: 5px;
            padding-right: 5px;
        }
        #carousel-home .carousel-indicators li {
            line-height: 21px;
            height: 8px;
            width: 8px;
            border-radius: 50%;
            background-color: #bebebe;
            margin: 0 5px;
        }
        #carousel-home .carousel-indicators li.active {
            background-color: <?php echo MAIN_COLOR;?>;
        }
        .group-news-2 ul li i {
            font-size: 12px;
            width: 25px;
            color: <?php echo MAIN_COLOR2;?>;
        }
        .group-news-2.second ul li i {
            color: <?php echo MAIN_COLOR;?>;
        }
        .tab-content.user-setting h4 {
            margin-left: 15px;
            margin-right: 15px;
            border-bottom: 2px solid #e6e5e5;
            color: <?php echo MAIN_COLOR2;?>;
        }
        .carousel-indicators-numbers li.active, .carousel-indicators-numbers li:hover {
            margin: 0 2px;
            width: 30px;
            height: 30px;
            background-color: <?php echo MAIN_COLOR;?>;
        }
        .group-news-3 ul li i {
            font-size: 12px;
            width: 25px;
            color: <?php echo MAIN_COLOR2;?>;
        }
        .pagination li.active a,.pagination li a:hover {
            color: <?php echo MAIN_COLOR2;?>;

        }
        .news-content a {
            color: <?php echo MAIN_COLOR2;?>;
        }
        #formSearchHead input {
            background: <?php echo MAIN_COLOR;?>;
            color: #fff;
            height: 30px;
            border: none;
            border-radius: 20px;
            padding: 4px 7px;
            width: 500px;
            display: none;
        }
        #formSearchHead input::placeholder {
            color: #fff;
        }
        .left-block .category-parent strong {
            font-size: 23px;
            color: <?php echo MAIN_COLOR;?>;
            font-weight: bold;
            margin-right: 10px;
        }

        .left-block .category-child {
            font-size: 14px;
            padding: 0 5px 0 10px;
            border-left: 2px solid #8a8a8a;
            font-weight: bold;
        }

        .left-block .category-child.bn {
            border-left-width: 0 !important;
        }

        .left-block .category-child.active {
            color: <?php echo MAIN_COLOR;?>;
        }
    </style>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<!--<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-ND5G27C"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!--<script type="application/javascript" src="http://adnetwork.adasiaholdings.com/ac?out=js&nwid=2060&siteid=220538&pgname=vn_thieunien.abc_outstream&fmtid=44269&tgt=[sas_target]&visit=m&tmstp=[timestamp]&clcturl=[countgo]"></script>-->
<?php $this->beginBody() ?>
<header>
    <div class="fixed-header">
        <div class="col-top-header">
            <div class="float-left">
                <ul class="">
                    <li class="float-left">Chuyên trang</li>
                    <li class="float-left">Emagazine</li>
                </ul>
            </div>
            <div class="float-right">
                Hotline: 097123456
            </div>
        </div>
        <hr class="line-top-header">
    </div>
    <div id="fb-root"></div>
    <?php $siteConfig = $this->params['siteConfig']; ?>
    <div class="container header-block">
        <ul class="list-unstyled logo-tag">
            <li><a href="/"><img class="logo" src="<?=(isset($siteConfig['logo_header'])) ? $siteConfig['logo_header'] : '/frontend/img/logo/logo-20170207.png' ;?>"></a></li>
            <?php if ($this->params['tags']){ ?>
                <li style="text-align: right"><img src="/frontend/img/line-chart-icon.png" style="width: 65%"></li>
                <?php foreach($this->params['tags'] as $t){?>
                    <li><a class="border-gradiant-round border-radius-12" href="<?=($t->slug) ? '/tag/'.$t->slug : '#'; ?>">#<?=Functions::renameTag($t->name); ?><span class="text-gradiant">#<?=Functions::renameTag($t->name); ?></php></span></a></li>
                <?php } ?>
            <?php } ?>
        </ul>
        <div class="clearfix"></div>
        <input type="hidden" id="keyword" value="<?=$this->params['keyword'] ?>">
    </div>
    <nav>
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav text-uppercase text-center">
                    <li style="margin-left: 0; ">
                        <a href="/" style="padding-left: 0; ">
                            <i class="fa fa-home" aria-hidden="true"></i>
                        </a>
                    </li>
                    <?php if (isset($this->params['headerMenu'])){ ?>
                        <?php foreach($this->params['headerMenu'] as $k => $c){?>
                            <li class="dropdown main-menu">
                                <a href="/danh-muc/<?=$c['slug'] ?>" >
                                    <strong><?=$c['name']?></strong>
                                </a>
                                <?php if($c['child']) {?>
                                <ul class="dropdown-menu sub-menu">
                                    <?php foreach($c['child'] as $key => $value){ ?>
                                        <li>
                                            <a href="/danh-muc/<?=$c['slug'] ?>/<?=$value['slug'] ?>">
                                                <?=$value['name'] ?>
                                            </a>
                                        </li>
                                    <?php }?>
                                </ul>
                                <?php }?>
                            </li>
                        <?php } ?>
                        <?php if (count($this->params['extraMenu']) > 0){ ?>
                            <li class="dropdown pull-right menu-dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu">
                                    <?php foreach($this->params['extraMenu'] as $k => $c){?>
                                        <li><a href="/danh-muc/<?=$c['slug'] ?>"><?=$c['name'] ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <li style="margin-left: 40px; ">
                        <form action="/tim-kiem" method="get" id="formSearchHead">
                            <input type="text" placeholder="Nhập nội dung cần tìm kiếm..." id="input-search-head" name="keyword" value="<?=$this->params['keyword'] ?>" >
                        </form>
                        <a href="#" onclick="$('#formSearchHead input').toggle()">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main>
	<?= $content ?>
</main>
<footer>
    <div class="footer-info">
        <div class="container">
            <div class="footer-content">
                <div class="row" style="margin-left: 0; margin-right: 0; ">
                    <div class="col-sm-4 logo-footer">
                        <img src="<?= (isset($siteConfig['logo_footer'])) ? $siteConfig['logo_footer'] : '/frontend/img/logo-footer.png' ;?>">
                    </div>
                    <div class="col-sm-4 footer-set-homepage">

                    </div>
                    <div class="col-sm-4 comment-user">
                        <div class="border-box">
                            <i class="fa fa-commenting" aria-hidden="true" style="color: <?php echo MAIN_COLOR;?>;font-size: 22px;transform: scaleX(-1);margin-right: 5px"></i>
                            <strong class="text-uppercase">Phản hồi của độc giả</strong>
                            <div style="color: #828282;padding-left: 8px">
                                <i class="fa fa-phone" aria-hidden="true" style="margin-right: 8px"></i>
                                <span>Hotline: (024) 62 735735 – ext: 168</span>
                            </div>
                            <div style="color: #828282;padding-left: 5px">
                                <i class="fa fa-envelope" aria-hidden="true" style="margin-right: 8px"></i>
                                <span>Email: banbientap@thieunien.abc</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border-width: 2px"/>
                <div class="clearfix c-a-c">
                    <div class="row">
                        <div class="col-sm-8 bdr block-content">
                            <strong class="text-uppercase">Cơ quan chủ quản:</strong> Trung ương Đoàn Thanh Niên Cộng sản Hồ Chí Minh<br>
                            <strong class="text-uppercase">Số giấy phép:</strong> 165/GP-BTTTT, cấp ngày 16/08/2011<br>
                            <strong class="text-uppercase">Tổng biên tập:</strong> Nguyễn Huy Lộc<br>
                            <strong class="text-uppercase">Tòa soạn:</strong> Ô D29 Phạm Văn Bạch, Quận Cầu Giấy, Hà Nội<br>
                            <strong class="text-uppercase">Điện thoại:</strong> (04) 62 735 735 – 168
                            <div class="note" style="margin-top: 20px; ">
                                ® Ghi rõ nguồn "Thiếu Niên" khi bạn phát hành lại thông tin từ website này.<br>
                                Các trang ngoài sẽ được mở ra ở cửa sổ mới. Thiếu Niên không chịu trách nhiệm nội dung các trang ngoài.<br>
                                Công ty MGC độc quyền khai thác thương mại quảng cáo trên trang web này.
                            </div>
                        </div>
                        <div class="col-sm-4 block-content">
                            <strong class="text-uppercase">Liên hệ quảng cáo</strong><br>
                            <strong class="text-uppercase">Địa chỉ:</strong> Công ty MGC, .JSC C11, ngõ 88 Trung Kính, Q. Cầu giấy, HN<br>
                            <strong class="text-uppercase">Điện thoại:</strong> 0975 385 536<br>
                            <strong class="text-uppercase">Email:</strong> quangcao@thieunien.abc<br>
                            <div style="margin-top: 3px">
                                <strong class="text-uppercase">Báo giá:</strong> <a href="http://mgc.com.vn/baogia/hoahoctro.pdf" target="_blank"><strong class="price">Xem chi tiết</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
