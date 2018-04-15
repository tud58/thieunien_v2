<?php
    use yii\helpers\Html;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\widgets\Breadcrumbs;
    use app\assets\AdminAsset;

    AdminAsset::register($this);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->title ?> Hoa Học Trò</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?= Html::csrfMetaTags() ?>
        <!-- Bootstrap -->

        <!--<link rel="stylesheet" media="screen" href="/css/bootstrap-theme.css">


        <link rel="stylesheet" media="screen" href="/css/bootstrap-admin-theme.css">
        <link rel="stylesheet" media="screen" href="/css/bootstrap-admin-theme-change-size.css">   -->
        <?php
            $this->head();
        ?>

        <link rel="stylesheet" href="/backend/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
        <link rel="stylesheet" href="/backend/css/font-icons/entypo/css/entypo.css">

        <link rel="stylesheet" href="/backend/css/neon-core.css">
        <link rel="stylesheet" href="/backend/css/neon-theme.css">
        <link rel="stylesheet" href="/backend/css/neon-forms.css">
        <link rel="stylesheet" href="/backend/css/custom.css">

        <script src="/backend/js/jquery-1.11.0.min.js"></script>
        <script>$.noConflict();</script>	


    </head>
    <body class="page-body">
        <?php
            $this->beginBody();
        ?>

        <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

            <div class="sidebar-menu">

                <div class="sidebar-menu-inner">

                    <header class="logo-env">

                        <!-- logo -->
                        <div class="logo">
                            <a href="/">
                                <img src="/frontend/img/logo-footer.png" height="40px" alt="" />
                            </a>
                        </div>

                        <!-- logo collapse icon -->
                        <div class="sidebar-collapse">
                            <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                                <i class="entypo-menu"></i>
                            </a>
                        </div>


                        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                        <div class="sidebar-mobile-menu visible-xs">
                            <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                                <i class="entypo-menu"></i>
                            </a>
                        </div>

                    </header>


                    <ul id="main-menu" class="main-menu">

                        <li <?php if(Yii::$app->controller->id == 'index'){?>class="opened active"<?php }?>>
                            <a href="/admin">
                                <i class="entypo-gauge"></i>
                                <span class="title">Trang chủ quản trị</span>
                            </a>
                        </li>
                        <li <?php if(Yii::$app->controller->id == 'news'){?>class="opened active"<?php }?>>
                            <a href="/admin/news">
                                <i class="entypo-docs"></i>
                                <span class="title">Tin tức</span>

                            </a>
                            <ul>
                                <li <?php if(Yii::$app->controller->action->id == 'index' && Yii::$app->request->get('cancel') != 1){?>class="active"<?php }?>>
                                    <a href="/admin/news">
                                        <span class="title">Danh sách bài viết</span>
                                    </a>
                                </li>
                                <li <?php if(Yii::$app->controller->action->id == 'add'){?>class="active"<?php }?>>
                                    <a href="/admin/news/add">
                                        <span class="title">Đăng bài</span>
                                    </a>
                                </li>
                                <li <?php if(Yii::$app->controller->action->id == 'add'){?>class="active"<?php }?>>
                                    <a href="/admin/news/add?type=compare">
                                        <span class="title">Đăng tin so sánh ảnh</span>
                                    </a>
                                </li>
                                <li <?php if(Yii::$app->controller->action->id == 'user_post'){?>class="active"<?php }?>>
                                    <a href="/admin/news/user_post">
                                        <span class="title">Bài đóng góp</span>
                                    </a>
                                </li>
                                <li <?php if(Yii::$app->controller->action->id == 'index' && Yii::$app->request->get('cancel') == 1){?>class="active"<?php }?>>
                                    <a href="/admin/news?cancel=1">
                                        <span class="title">Bài bị trả lại</span>
                                    </a>
                                </li>							
                            </ul>

                        </li>
                        <li <?php if(Yii::$app->controller->id == 'category'){?>class="opened active"<?php }?>>
                            <a href="/admin/category">
                                <i class="entypo-layout"></i>
                                <span class="title">Chuyên mục</span>

                            </a>
                            <ul>
                                <li <?php if(Yii::$app->controller->action->id == 'index'){?>class="active"<?php }?>>
                                    <a href="/admin/category">
                                        <span class="title">Danh sách chuyên mục</span>
                                    </a>
                                </li>
                            </ul>
                            
                            <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){ ?>
                            <ul>
                                <li <?php if(Yii::$app->controller->action->id == 'add'){?>class="active"<?php }?>>
                                    <a href="/admin/category/add">
                                        <span class="title">Tạo chuyên mục</span>
                                    </a>
                                </li>
                            </ul>
                            <?php }?>
                        </li>
                        <li <?php if(Yii::$app->controller->id == 'event'){?>class="opened active"<?php }?>>
                            <a href="/admin/event">
                                <i class="entypo-star"></i>
                                <span class="title">Sự kiện</span>

                            </a>
                            <ul>
                                <li <?php if(Yii::$app->controller->action->id == 'index'){?>class="active"<?php }?>>
                                    <a href="/admin/event">
                                        <span class="title">Danh sách sự kiện</span>
                                    </a>
                                </li>
                            </ul>
                            
                            <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){ ?>
                            <ul>
                                <li <?php if(Yii::$app->controller->action->id == 'add'){?>class="active"<?php }?>>
                                    <a href="/admin/event/add">
                                        <span class="title">Tạo sự kiện</span>
                                    </a>
                                </li>
                            </ul>
                            <?php }?>
                        </li>
                        
                        <li <?php if(Yii::$app->controller->id == 'comment'){?>class="opened active"<?php }?>>
                            <a href="/admin/comment">
                                <i class="entypo-chat"></i>
                                <span class="title">Comment</span>				
                            </a>
                        </li>
                        <li>
                            <a href="/filemanager/file/filemanager_admin">
                                <i class="entypo-picture"></i>
                                <span class="title">Media</span>
                            </a>
                        </li>

                        <li <?php if(Yii::$app->controller->id == 'tag'){?>class="opened active"<?php }?>>
                            <a href="/admin/tag">
                                <i class="entypo-tag"></i>
                                <span class="title">Tag/ Từ khoá</span>
                            </a>
    
                        </li>

                        <li <?php if(Yii::$app->controller->id == 'stats'){?>class="opened active"<?php }?>>
                            <a href="/admin/stats">
                                <i class="entypo-chart-bar"></i>
                                <span class="title">Thống kê</span>
                            </a>
                        </li>
                        
                        <li <?php if(Yii::$app->controller->id == 'log'){?>class="opened active"<?php }?>>
                            <a href="/admin/log">
                                <i class="entypo-clock"></i>
                                <span class="title">Nhật ký</span>
                            </a>
                        </li>
                        
                        
                        <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){ ?>
                        <li <?php if(Yii::$app->controller->id == 'ads'){?>class="opened active"<?php }?>>
                            <a href="/admin/ads">
                                <i class="entypo-window"></i>
                                <span class="title">Quảng cáo</span>
                            </a>
                            <ul>
                                <li <?php if(Yii::$app->controller->action->id == 'index'){?>class="active"<?php }?>>
                                    <a href="/admin/ads">
                                        <span class="title">Danh sách</span>
                                    </a>
                                </li>
                                <li <?php if(Yii::$app->controller->action->id == 'add'){?>class="active"<?php }?>>
                                    <a href="/admin/ads/add">
                                        <span class="title">Tạo quảng cáo</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php }?>
                        
                        
                        
                        <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){ ?>
                            <li <?php if(Yii::$app->controller->id == 'subject'){?>class="opened active"<?php }?>>
                                <a href="/admin/subject">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                    <span class="title">Chủ đề</span>
                                </a>
                                <ul>
                                    <li <?php if(Yii::$app->controller->action->id == 'index'){?>class="active"<?php }?>>
                                        <a href="/admin/subject">
                                            <span class="title">Danh sách chủ đề</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul>
                                    <li <?php if(Yii::$app->controller->action->id == 'add'){?>class="active"<?php }?>>
                                        <a href="/admin/subject/add">
                                            <span class="title">Tạo mới chủ đề</span>
                                        </a>
                                    </li>
                                </ul>                           
                            </li>  
                            <li <?php if(Yii::$app->controller->id == 'user'){?>class="opened active"<?php }?>>
                                <a href="/admin/user">
                                    <i class="entypo-users"></i>
                                    <span class="title">Người dùng</span>
                                </a>
                                <ul>
                                    <li <?php if(Yii::$app->controller->action->id == 'index'){?>class="active"<?php }?>>
                                        <a href="/admin/user">
                                            <span class="title">Danh sách</span>
                                        </a>
                                    </li>
                                    <li <?php if(Yii::$app->controller->action->id == 'add'){?>class="active"<?php }?>>
                                        <a href="/admin/user/create">
                                            <span class="title">Tạo người dùng</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li <?php if(Yii::$app->controller->id == 'site'){?>class="opened active"<?php }?>>
                                <a href="/admin/site">
                                    <i class="entypo-monitor"></i>
                                    <span class="title">Layout</span>
                                </a>
                            </li>
                            <li <?php if(Yii::$app->controller->id == 'cache'){?>class="opened active"<?php }?>>
                                <a href="/admin/cache">
                                    <i class="entypo-download"></i>
                                    <span class="title">Quản lý cache</span>
                                </a>
                            </li>
                        <?php }?>
                    </ul>

                </div>

            </div>

            <div class="main-content">

                <div class="row">

                    <!-- Profile Info and Notifications -->
                    <div class="col-md-6 col-sm-8 clearfix">

                        <ul class="user-info pull-left pull-none-xsm">

                            <!-- Profile Info -->
                            <li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/uploads/user_avatar/<?=Yii::$app->user->id?>.png" alt="" class="img-circle" width="44" />
                                    <?php echo Yii::$app->params['role_name'][Yii::$app->user->identity->role_id] . ': ' .Yii::$app->user->identity->profile->full_name . ' #' .Yii::$app->user->identity->id;?>
                                </a>


                            </li>

                        </ul>


                    </div>


                    <!-- Raw Links -->
                    <div class="col-md-6 col-sm-4 clearfix hidden-xs">

                        <ul class="list-inline links-list pull-right">



                            <li>
                                <a  data-method="post" href="/user/logout">
                                    Log Out <i class="entypo-logout right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr />

                <?= $content ?>

                <!-- Footer -->
                <footer class="main">
                    &copy; 2016 <strong>Hht</strong>
                </footer>
            </div>
        </div>




        <?php
            $this->endBody();
        ?>
        <script src="/backend/js/gsap/main-gsap.js"></script>
        <script src="/backend/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
        <script src="/backend/js/joinable.js"></script>
        <script src="/backend/js/resizeable.js"></script>
        <script src="/backend/js/neon-api.js"></script>
        <script src="/backend/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

        <script src="/backend/js/neon-custom.js"></script>

        <script src="/backend/js/neon-demo.js"></script>
        <script src="/backend/js/toastr.js"></script>      
        <script type="text/javascript">
            $(document).ready(function(){
                var opts = {
                    "closeButton": true,

                    "timeOut": "10000",

                };
                <?php
                    foreach (Yii::$app->session->getAllFlashes() as $key => $messages) {
                        foreach($messages as $message){
                             echo "toastr.".$key."('".str_replace('"', '', $message)."', null, opts);";   
                             
                        }
                       
                    }

                ?> 
            })
        </script> 
    </body>
</html>
<?php
    $this->endPage();
?>
