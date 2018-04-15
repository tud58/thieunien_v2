<?php foreach($noteList as $note){
$color = '';
$role_name = '';
if($note->role_id == ROLE_CONTRIBUTOR){
    $color = '-red';
}
if($note->role_id == ROLE_EDITOR){
    $color = '-green';
}
?>
    <div class="col-md-12">
        <blockquote class="blockquote<?=$color?>">
            <p>
                <strong><?=$note->full_name?></strong>
                <i class="pull-right"><small><?=date('H:i d/m/Y', $note->create_time)?></small></i>
            </p>
            <p>
                <small style="color: #000;"><?=$note->note?></small>
            </p>
        </blockquote>
    </div>
<?php }?>