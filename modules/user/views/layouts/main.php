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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/frontend/img/h2t.png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<header>
    <div id="fb-root"></div>

    <div class="container">
        <ul class="list-unstyled logo-tag">
            <li><a href="/"><img class="logo" src="/frontend/img/logo-header.png"></a></li>
            <?php if ($this->params['tags']){ ?>
                <li><img src="/frontend/img/line-chart-icon.png"></li>
                <?php foreach($this->params['tags'] as $t){?>
                    <li><a class="border-gradiant-round border-radius-12" href="<?=($t->slug) ? '/tag/'.$t->slug : '#'; ?>">#<?=$t->name ?><span class="text-gradiant">#<?=$t->name ?></php></span></a></li>
                <?php } ?>
            <?php } ?>
        </ul>
        <div class="clearfix"></div>
        <input type="hidden" id="keyword" value="<?=$this->params['keyword'] ?>">
        <form action="/tim-kiem" method="get" id="formSearchHead">
            <div class="search-block">
                <input type="text" placeholder="Nhập nội dung cần tìm kiếm..." id="input-search-head" name="keyword" value="<?=$this->params['keyword'] ?>" >
                <a onclick="$('#formSearchHead').submit()">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </div>
        </form>

        <ul class="list-unstyled pull-right user-social">
            <?php if (!Yii::$app->user->getIsGuest()){ ?>
                <li>
                    <button class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="/uploads/user_avatar/<?=Yii::$app->user->id?>.png" class="avatar_img"> <strong><?php echo Yii::$app->user->identity->profile->full_name;?></strong> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="/thong-tin-ca-nhan">Trang cá nhân</a></li>
                        <li><a data-method="post" href="/user/logout">Thoát</a></li>
                    </ul>
                </li>
            <?php } else { ?>
                <li><a href="/dang-nhap"><i class="fa fa-user" aria-hidden="true"></i> Đăng nhập</a></li>
                <li><a href="/user/auth/login?authclient=facebook"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                <li><a href="/user/auth/login?authclient=google"><i class="fa fa-google" aria-hidden="true"></i></a></li>

            <?php } ?>
        </ul>


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
                    <li>
                        <a href="/">
                            <i class="fa fa-home" aria-hidden="true"></i>
                        </a>
                    </li>
                    <?php if (isset($this->params['headerMenu'])){ ?>
                        <?php foreach($this->params['headerMenu'] as $k => $c){?>
                            <li>
                                <a href="/danh-muc/<?=$c['slug'] ?>">
                                    <i class="<?=$c['icon'] ?>" aria-hidden="true"></i>
                                    <strong><?=Functions::replace_second_space($c['name']) ?></strong>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="/video">
                                <i class="fa fa-film" aria-hidden="true"></i>
                                <strong>Video</strong>
                            </a>
                        </li>
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
                </ul>
            </div>
        </div>
    </nav>
</header>
<main>
	<?= $content ?>
</main>
<footer>
    <hr>
    <div class="container">
        <div class="row footer-nav">
            <?php if (isset($this->params['categories'])){ ?>
                <?php foreach($this->params['categories'] as $c){?>
                    <?php if ($c['parent_id'] == 0){ ?>
                        <div class="col-sm-3">
                            <h4 class="text-uppercase"><?=$c['name'] ?></h4>
                            <?php if ($c['child']){ ?>
                                <ul>
                                    <?php foreach($c['child'] as $sub){?>
                                        <li><a href="<?=($sub['slug']) ? '/danh-muc/'.$sub['slug'] : '#'; ?>"><?=$sub['name'] ?></a></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class="footer-info">
        <div class="container">
            <div class="logo-footer">
                <img src="/frontend/img/logo-footer.png">
                <a href="#" class="text-uppercase footer-set-homepage">
                    <i class="fa fa-home" aria-hidden="true"></i> Cài đặt H2T online làm trang chủ
                </a>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-4">
                <h3 class="text-uppercase">Cơ quan chủ quản</h3>
                Trung ương Đoàn Thanh Niên Cộng sản Hồ Chí Minh<br>
                Số giấy phép: 165/GP-BTTTT, cấp ngày 16/08/2011<br>
                Tổng biên tập: Nguyễn Huy Lộc.
            </div>
            <div class="col-sm-4">
                <h3 class="text-uppercase">Hợp tác nội dung</h3>
                Tòa soạn: D29 Trần Thái Tông, Cầu Giấy, Hà Nội<br>
                Điện thoại: 04.62 735 735<br>
                Email: toasoan.svvnhht@gmail.com
            </div>
            <div class="col-sm-4">
                <h3 class="text-uppercase">Liên hệ quảng cáo</h3>
                Công ty MGC, jsc<br>
                C11, ngõ 88 Trung Kính, Q. Cầu giấy, HN<br>
                Điện thoại: 04 3782 4323<br>
                Email: quangcao@hoahoctro.vn<br>
                Báo giá: <a href="http://mgc.com.vn/baogia/15/" style="background: #ffffff;border-radius: 10px;color: <?php echo MAIN_COLOR;?>;font-size: 12px" target="_blank">Xem chi tiết</a>
            </div>
            <div class="clearfix"></div>
            <p>
                <br>
                ® Ghi rõ nguồn "Hoa Học Trò" khi bạn phát hành lại thông tin từ website này.<br>
                Các trang ngoài sẽ được mở ra ở cửa sổ mới. Hoa Học Trò không chịu trách nhiệm nội dung các trang ngoài.<br>
                Công ty MGC độc quyền khai thác thương mại quảng cáo trên trang web này.
            </p>
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
</body>
</html>
<?php $this->endPage() ?>
