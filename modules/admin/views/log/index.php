<?php

use app\helper\Functions;
use yii\helpers\Html;


?>

<div class="header">
    <h3><?= $this->title ?></h3>
</div>
<div class="row">
    <div class="col-md-12">
        <form>
            <div class="row">
                <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){?>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'user_id', $searchData['user_id'], ['class' => 'form-control input-mini', 'placeholder' => 'UserId']) ?>
                    </div>
                </div>
                <?php }?>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::dropDownList('reference_type', $searchData['reference_type'], Yii::$app->params['log_reference_type'], ['class' => 'input-mini form-control', 'prompt'=>'Loại']) ?>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'reference_id', $searchData['reference_id'], ['class' => 'form-control input-mini', 'placeholder' => 'Id tham chiếu']) ?>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::dropDownList('action_id', $searchData['action_id'], Yii::$app->params['actions'], ['class' => 'input-mini form-control', 'prompt'=>'Hành động']) ?>
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
                    <th class="col-lg-1">Loại</th>                 
                    <th class="col-lg-2">User</th>
                    <th class="col-lg-2">Hành động</th>
                    <th class="col-lg-3">Tiêu đề</th>
                    <th class="col-lg-1">Id</th>
                    <th class="col-lg-3">Thời gian</th>


                </tr>
            </thead>
            <tbody>
            <?php

            foreach($logList as $log){?>
            <tr>
                <td><?= $log->id ?></td>
                <td><?= Yii::$app->params['log_reference_type'][$log->reference_type] ?></td>              
                <td><?= $log->user_full_name ?></td>
                <td><?= Yii::$app->params['actions'][$log->action_id] ?></td>

                <td>
                    <?= $log->reference_name ?>
                    <?php if($log->note != ''){?>
                    </br>
                        <?=$log->note?>
                    <?php }?>
                </td>
                <td><?= $log->reference_id ?></td>
                <td><?= date('H:i:s d-m-Y', $log->create_time) ?></td>


                
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