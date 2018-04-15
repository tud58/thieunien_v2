var _input;
var _modal;

function filemanagerTinyMCE(callback, value, meta) {
	
			//console.log(value);
			//console.log(meta);
	
    var inputId = tinymce.activeEditor.settings.id,
        modal = $('[data-btn-id="' + inputId + '-btn"]'),
        iframe = $('<iframe src="' + modal.attr("data-frame-src")
            + '" id="' + modal.attr("data-frame-id") + '" frameborder="0" role="filemanager-frame"></iframe>');

		_modal = modal;
			
    iframe.on("load", function() { 
        var modal = $(this).parents('[role="filemanager-modal"]'),
            input = $("#" + modal.attr("data-input-id"));


		
        $(this).contents().find(".dashboard").on("click", "#insert-btn", function(e) {
            e.preventDefault();

			console.log(e);
			
            var data = getFormData($(this).parents("#control-form"));
			
            input.trigger("fileInsert", [data]);   
            callback(data.url, {alt: data.alt});
            modal.modal("hide");
        });   
			
		console.log('tinyMCE click show modal_'+modal.attr("data-input-id"));

    });
              
    modal.find(".modal-body").html(iframe);
    modal.modal("show");
}

function getFormData(form) {
    var formArray = form.serializeArray(),
        modelMap = {
            'Mediafile[alt]': 'alt',
            'Mediafile[description]': 'description',
            url: 'url',
            id: 'id'
        },
        data = [];

    for (var i=0; formArray.length > i; i++) {
        if (modelMap[formArray[i].name]) {
            data[modelMap[formArray[i].name]] = formArray[i].value;
        }
    }

    return data;
}


$(document).ready(function() {

	$('body').on('click', '.mce-btn.mce-open', function(){
		var mce_input_id = ($(this).attr('id')).replace('-open', '-inp');
		_input = $("#" + mce_input_id);
	});


    function frameHandler(e) {
        var modal = $(this).parents('[role="filemanager-modal"]'),
            imageContainer = $(modal.attr("data-image-container")),
            pasteData = modal.attr("data-paste-data"),
            input = $("#" + modal.attr("data-input-id"));
			
		_input = input;
		_modal = modal;
		
        $(this).contents().find(".dashboard").on("click", "#insert-btn", function(e) {
            e.preventDefault();

            var data = getFormData($(this).parents("#control-form"));

            input.trigger("fileInsert", [data]);

            if (imageContainer) {
                imageContainer.html('<img src="' + data.url + '" alt="' + data.alt + '">');
            }

            input.val(data[pasteData]);
            modal.modal("hide");
        });
		console.log('input click show modal_'+modal.attr("data-input-id"));
		
      
    }

    $('[role="filemanager-launch"]').on("click", function(e) {
        e.preventDefault();

        var modal = $('[data-btn-id="' + $(this).attr("id") + '"]'),
            iframe = $('<iframe src="' + modal.attr("data-frame-src")
                + '" id="' + modal.attr("data-frame-id") + '" frameborder="0" role="filemanager-frame"></iframe>');

        iframe.on("load", frameHandler);
        modal.find(".modal-body").html(iframe);
        modal.modal("show");
    });

    $('[role="clear-input"]').on("click", function(e) {
        e.preventDefault();

        $("#" + $(this).attr("data-clear-element-id")).val("");
        $($(this).attr("data-image-container")).empty();
    });
});
window.addEventListener("message", receiveMessage, false);
function receiveMessage(event)
{
	_input.val(event.data.url);
	_modal.modal("hide");
}

