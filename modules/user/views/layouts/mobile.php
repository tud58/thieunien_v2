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
</head>
<body>
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
            <li><a href="/"><img class="logo" src="/frontend/img/logo-footer.png"></a></li>
        </ul>
        <form action="/tim-kiem" method="get" id="formSearchHead">
            <div class="search-block pull-right">
                <a onclick="$('#input-search').toggle();">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </div>
            <div class="input-group search-input" style="display: none" id="input-search">
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
                        <a href="/video">
                            <i class="fa fa-film" aria-hidden="true"></i>
                            <span>Video</span>
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
            <div class="no-collapse ">
                <ul class="nav navbar-nav text-uppercase text-center">
                    <?php foreach($this->params['headerMenu'] as $k => $c){?>
                        <li>
                            <a href="/danh-muc/<?=$c['slug'] ?>">
                                <i class="<?=$c['icon'] ?>" aria-hidden="true"></i>
                                <span><?=Functions::replace_second_space($c['name']) ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="/video">
                            <i class="fa fa-film" aria-hidden="true"></i>
                            <span>Video</span>
                        </a>
                    </li>
                    <?php foreach($this->params['extraMenu'] as $k => $c){?>
                        <li>
                            <a href="/danh-muc/<?=$c['slug'] ?>">
                                <i class="<?=$c['icon'] ?>" aria-hidden="true"></i>
                                <span><?=Functions::replace_second_space($c['name']) ?></span>
                            </a>
                        </li>
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
    <div class="footer-info">
        <div class="container">
            <img src="/frontend/img/logo-footer.png">
            <p>Cơ quan chủ quản: Trung ương Đoàn Thanh Niên Cộng sản Hồ Chí Minh<br>
                Số giấy phép: 165/GP-BTTTT, cấp ngày 16/08/2011<br>
                Tổng biên tập: Nguyễn Huy Lộc. Tòa soạn: D29 Trần Thái Tông, Cầu Giấy, Hà Nội.<br>
                Điện thoại: 04.62 735 735 - Email: toasoan.svvnhht@gmail.com<br>
                ® Ghi rõ nguồn "Hoa Học Trò" khi bạn phát hành lại thông tin từ website này.<br>
                Các trang ngoài sẽ được mở ra ở cửa sổ mới. Hoa Học Trò không chịu trách nhiệm nội dung các trang ngoài.</p>
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
