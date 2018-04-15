<?php
    $this->title = 'Chi tiết bài gửi';
?>
<div class="header">
    <h2><?= $this->title ?></h2>
    </br>
</div>
<div class="row">
    <div class="col-md-8">
        <table class="table table-bordered">
            <tr>
                <td width="20%">Tiêu đề</td>
                <td><?=$userPost->title?></td>
            </tr>
            <tr>
                <td>Người tạo</td>
                <td><?=$userPost->user_full_name?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?=$userPost->user_email?></td>
            </tr>
            <tr>
                <td>Ngày tạo</td>
                <td><?=date('H:i:s d-m-Y', $userPost->create_time)?></td>
            </tr>
            <tr>
                <td>Nội dung</td>
                <td class="text-break"><?=$userPost->content?></td>
            </tr>
        </table>

    </div>
</div>