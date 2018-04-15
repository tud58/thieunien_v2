<div class="row">


    <div class="col-md-7">
        <h3>Chủ đề đang giao</h3>
        <div class="row">
            <?php foreach($subject_list as $subject){
                    $showRequestButton = true;
                    $showCancelButton = false;
                    if(isset($userSubject[$subject->id])){
                        foreach($userSubject[$subject->id] as $us){
                            if($us->user_id == Yii::$app->user->id){
                                $showRequestButton = false;
                                if($us->status != STATUS_DELETED){
                                    $showCancelButton = true;
                                }
                            }
                        }
                    }    
                ?>
                <div class="col-md-12">
                    <div class="panel panel-info" data-collapsed="0">
                                        
                        <!-- panel head -->
                        <div class="panel-heading">

                                <b><?=$subject->name?></b> 
                                <?php if($showCancelButton){?>
                                    <a href="/admin/subject/cancel_request?subject_id=<?=$subject->id?>" class="btn btn-primary btn-xs pull-right" style="color: #fff;">Bỏ chủ đề</a>
                                <?php } ?>
                                <?php if($showRequestButton){?>
                                    <a href="/admin/subject/request?subject_id=<?=$subject->id?>" class="btn btn-blue btn-xs pull-right" style="color: #fff;">Nhận chủ đề</a>
                                <?php }?>

                        </div>

                        <div class="panel-body text-break">             
                            <?php if(isset($userSubject[$subject->id])){  ?>
                            <small>Người nhận: </small>
                            <?php foreach($userSubject[$subject->id] as $us){
                                    
                                    $color = 'info';
                                    $tooltip = 'Chờ xử lý';
                                    if($us->status==STATUS_ACTIVE){
                                        $color = 'green';
                                        $tooltip = 'Đã được giao';
                                    }elseif($us->status==STATUS_DELETED){
                                        $color = 'default';
                                        $tooltip = 'Đã bị từ chối';
                                    }                         
                                ?>
                                <button type="button" class="btn btn-<?=$color?> btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=$tooltip?>"><?=$us->user_full_name?></button> &nbsp;
                            <?php   } ?>
                            <hr>                   
                            <?php }?>
                            
                            <?=$subject->description?><br>
                            <?php if($subject->begin_time > 0){?>
                            <br><b>Bắt đầu: <?=date('d-m-Y', $subject->begin_time)?></b>
                            <?php }?>    
                            <?php if($subject->end_time > 0){?>
                            <br><b>Kết thúc: <?=date('d-m-Y', $subject->end_time)?></b>
                            <?php }?> 
                        </div>

                    </div>     
                </div>     
            <?php }?>

        </div>
    </div>
    <div class="col-md-4">
        <iframe scrolling="no" style="border:none;" width="100%" height="800" src="https://www.google.com/trends/hottrends/widget?pn=p28&amp;tn=20&amp;h=800"></iframe>
    </div>
</div>