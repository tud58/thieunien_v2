var loading = false;
$(document).ready(function () {
    save_note = function (news_id) {
        var note = $('#note_input').val();
        if (note == '') {
            return;
        }
        $.ajax({
            url: "/admin/news/save_note",
            type: "POST",
            data: {news_id: news_id, note: note},
            beforeSend: function () {

            },
            success: function (message) {
                load_note(news_id);
            },
            complete: function () {
                //$('#loading_topic').hide();
            }
        });
    };
    load_note = function (news_id) {
        $.ajax({
            url: "/admin/news/load_note?news_id=" + news_id,
            type: "GET",
            beforeSend: function () {

            },
            success: function (res) {
                $('#note_view').html(res);
            },
            complete: function () {
            }
        });
    };
    quickAddTag = function () {
        if (loading) {
            return false;
        }
        loading = true;
        var tag = $("#new-tag").val();
        if (!tag) {
            return false;
        }
        $.ajax({
            url: "/admin/news/quick_add_tag?tag=" + tag,
            type: "GET",
            beforeSend: function () {

            },
            dataType: "json",
            success: function (res) {
                console.log(res);
                var msg = "Thêm thất bại!";
                if (res.msg == "denied") {
                    msg = "Bạn không có quyền thêm mới tag.";
                    $("#new-tag").val("");
                } else if (res.msg == "exits") {
                    msg = "Từ khóa đã tồn tại.";
                } else if (res.msg == "success") {
                    msg = "Thêm thành công!";
                    $("#new-tag").val("");
                    var tag_show = '<li class="select2-selection__choice" title="' + tag + '">' + '<input type="hidden" name="tag[]" value="' + res.newTagId + '">' + '<span class="quick-add-tag__remove" onclick="$(this).parent().remove();">×</span>' + tag + '</li>';
                    $("#select-tag ul.select2-selection__rendered").prepend(tag_show);
                }
                $("#add-tag-msg").html(msg);
                loading = false;
            },
            complete: function () {
            }
        });
        return false;
    };
    $("#ads_type").change(function () {
        var type = $("#ads_type").val();
        if (type == 1) {
            $(".ads-banner").hide(function () {
                $(".ads-code").show(function () {

                });
            });
        } else {
            $(".ads-code").hide(function () {
                $(".ads-banner").show(function () {
                });
            });
        }
    });
    $("#ads_show_type").change(function () {
        var show_type = $("#ads_show_type").val();
        if (show_type == 1) {
            $("#ads-content").hide(function () {
                $("#ads-multi-content").show(function () {

                });
            });
        } else {
            $("#ads-multi-content").hide(function () {
                $("#ads-content").show(function () {

                });
            });
        }
    });

    $("#ads-num_slide").change(function () {
        $("form").submit();
    });

    exportStarts = function () {
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();
        var category_id = $("#category_id").val();

        var url = '/admin/stats/export?from_date=' + from_date + '&to_date=' + to_date + '&category_id=' + category_id;
        window.open(url);
        return false;
    };
    $('.admin-check-all').change(function() {
        if($(this).is(":checked")) {
            $('.admin-check-item').prop('checked', true);
			
        }else{
			$('.admin-check-item').prop('checked', false);
		}   
    });
	
});
