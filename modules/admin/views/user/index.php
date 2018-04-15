<?php

use app\helper\Functions;
use yii\helpers\Html;
use app\modules\user\models\User;
$count = count($userList);


?>

<div class="header">
    <h3><?= $this->title ?></h3>
</div>
<div class="row">
    <div class="col-md-12">
        <form>
            <div class="row">

                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'id', $searchData['id'], ['class' => 'form-control input-mini', 'placeholder' => 'User Id']) ?>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'username', $searchData['username'], ['class' => 'form-control input-mini', 'placeholder' => 'Tên đăng nhập']) ?>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'email', $searchData['email'], ['class' => 'form-control input-mini', 'placeholder' => 'Email']) ?>
                    </div>
                </div>



                <div class="col-xs-2">
                    <div class="">
                        <?= Html::dropDownList('role_id', $searchData['role_id'], Yii::$app->params['role_name'], ['class' => 'input-mini form-control', 'prompt'=>'Phân quyền']) ?>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::dropDownList('status', $searchData['status'], [STATUS_ACTIVE => 'Hoạt động', STATUS_INACTIVE => 'Khóa', User::STATUS_UNCONFIRMED_EMAIL => 'Không xác nhận'], ['class' => 'input-mini form-control', 'prompt'=>'Trạng thái']) ?>
                    </div>
                </div>

                <div class="col-xs-2">
                    <div class="">
                        <button type="submit" class="btn btn-default">Tìm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="col-lg-1">Id</th>
                    <th class="col-lg-2">Tên đăng nhập</th>
                    <th class="col-lg-1">Phân quyền</th>                
                    <th class="col-lg-2">Email</th>
                    <th class="col-lg-3">Tên hiển thị</th>
                    <th class="col-lg-1">Trạng thái</th>
                    <th class="col-lg-2"></th>
                </tr>
            </thead>
            <tbody>
            <?php

            foreach($userList as $user){?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->username ?></td>
                <td>
                    <?=isset(Yii::$app->params['role_name'][$user->role_id])?Yii::$app->params['role_name'][$user->role_id]:'(không có)'?>
                </td>
                <td><?= $user->email ?></td>
                <td><?= isset($profileList[$user->id]->full_name)?$profileList[$user->id]->full_name:'' ?></td>
                <td>
                    <?php if($user->status == User::STATUS_ACTIVE){?>
                        <a class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i> Hoạt động</a>
                    <?php }?>    
                    <?php if($user->status == User::STATUS_INACTIVE){?>
                        <a class="btn btn-red btn-xs"><i class="glyphicon glyphicon-ban-circle"></i> Khóa</a>
                    <?php }?>    
                    <?php if($user->status == User::STATUS_UNCONFIRMED_EMAIL){?>
                        <a class="btn btn-red btn-xs"><i class="glyphicon glyphicon-ban-circle"></i> Không xác nhận</a>
                    <?php }?>    
                </td>
                <td class="text-right">
                    <a  class="btn btn-blue btn-xs" href="/admin/user/update?id=<?=$user->id?>"><i class="glyphicon glyphicon-cog"></i> Sửa</a>
           
                </td>
            </tr>
            <?php }?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-lg-12">
                <div class="">
					<?=$this->render('../pagination', ['count_items' => $count_items, 'page'=>$page, 'page_count'=>$page_count, 'pageUrl'=>$pageUrl]);?>
                </div>
            </div>
        </div>
    </div>
</div>