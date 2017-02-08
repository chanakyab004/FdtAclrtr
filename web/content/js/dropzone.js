$(document).ready(function () {
    $('a.dz-remove').click(function (e) {
        modal.open({ content: 'Are you sure you want to delete?<br/><br/>' });
        e.preventDefault();
    });

    Dropzone.options.myDropzone = {
        maxFilesize: 20,
        addRemoveLinks: true,
        removedfile: function (file) {
            $('div.dz-default.dz-message').remove();
            modal.open({
                content: 'Are you sure you want to delete?<br/><br/>',
                name: file.name,
                image: file.previewElement,
            });

        },
        acceptedFiles: "image/jpeg,image/png,image/gif",
        sending: function (file, xhr, formData) {
            if ($.isFunction(parent.resizeDropzone)) parent.resizeDropzone($('#section').val(), $(document).height());
        },
        success: function (file, response) {
            if ($('#section').val() != "general"){
                if ($.isFunction(parent.updateDropzone)) parent.updateDropzone("general");
            }

            if ($.isFunction(parent.resizeDropzone)) parent.resizeDropzone($('#section').val(), $(document).height());

            $(file.previewElement).find('.dz-image > img').attr('src', 'image.php?type=evalimage&cid=' + $('#companyID').attr('value') + '&pid=' + $('#projectID').attr('value') + '&eid=' +
                $('#evaluationID').attr('value') + '&name=thumb_' + response);
            $(file.previewElement).find('.dz-progress, .dz-error-message, .dz-success-mark, .dz-error-mark, .dz-size').remove();
            $(file.previewElement).find('.dz-details > .dz-filename > span').text(response);
            $(file.previewElement).find('.dz-remove').text('Remove File');
            $(file.previewElement).find('a.dz-remove').click(function (e) {
                modal.open({
                    content: 'Are you sure you want to delete?<br/><br/>',
                    name: $(this).parent().find(".dz-filename > span").text(),
                    image: $(this).parent(".dz-preview"),
                });
                e.preventDefault();
            });
            $(file.previewElement).find('.dz-image').on('click', function (e) {
                imagePreview.show(e);
                e.stopPropagation();
                return;
            });

            //console.log(file, response);
            //var evaluationID = $('#evaluationID').attr('value');

            //console.log(file.name);
            //console.log(evaluationID);
        },
        //If we add a an error catch then dropzone default errors won't work. 
        complete: function (jqXHR, textStatus) {
        }
    }

    //Get Photos and Add to Dropzones
    $.ajax({
        url: 'getPhotos.php',
        dataType: "json",
        contentType: 'application/json',
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        data: {
            evaluationID: $('#evaluationID').val(),
            section: $('#section').val()
        },
        success: function (response) {
            if (!response == '') {
                $.each(response, function (i, item) {
                    var $d = $('<div class="dz-preview dz-image-preview"><div class="dz-image"><a href="image.php?type=evalimage&cid=' + $('#companyID').attr('value') + 
                        '&eid=' + item.evaluationID + '&pid=' + $('#projectID').attr('value') + '&name=' + item.photoFilename + '" data-title="' + 
                        item.photoFilename + '"><img alt="' + item.photoFilename + '" src="image.php?type=evalimage&cid=' + $('#companyID').attr('value') + '&eid=' + 
                        item.evaluationID + '&pid=' + $('#projectID').attr('value') + '&name=' + 'thumb_' + item.photoFilename + 
                        '"></a></div><div class="dz-details"><div class="dz-filename"><span data-dz-name="">' + item.photoFilename + 
                        '</span></div></div><a class="dz-remove" data-dz-remove="">Remove File</a><div class="is-hidden" name="original-section" value="'+item.photoSection+'"></div></div>');
                    $('form').append($d);
                    $('div.dz-default.dz-message').remove();
                    //$('.dz-remove').click(removeImage);
                    $d.find('a.dz-remove').click(function (e) {
                        modal.open({
                            content: 'Are you sure you want to delete?<br/><br/>',
                            name: $(this).parent().find(".dz-filename > span").text(),
                            image: $(this).parent(".dz-preview"),
                        });
                        e.preventDefault();
                    });
                    $d.find('.dz-image').on('click', function (e) {
                        imagePreview.show(e);
                    });
                });
                if ($.isFunction(parent.resizeDropzone)) {
                    parent.resizeDropzone($('#section').val(), $(document).height());
                }
            }
        },
        complete: function (jqXHR, textStatus) {
        }
    });
    if ($.isFunction(parent.resizeDropzone)) parent.resizeDropzone($('#section').val(), $(document).height());
    //End Get Photos
});

var imagePreview = function () {
    var pv = {},
        $overlay = null,
        $preview = null,
        $prevButton,
        $nextButton,
        $closeButton;

    $prevButton = $('<a class="previousImage">&lsaquo;</a>');
    $nextButton = $('<a class="nextImage">&rsaquo;</a>');
    $closeButton = $('<a class="closeImage">X</a>');

    $closeButton.on('click', function (e) {
        e.preventDefault();
        $preview.hide();
        $overlay.hide();
        $prevButton.detach();
        $nextButton.detach();
        $closeButton.detach();
        $('div.dz-preview.currentImage').removeClass('currentImage');
        $preview.find('img').off();
    });

    $prevButton.on('click', function (e) {
        var $p, $e = $('div.dz-preview.currentImage');
        if ($e.length > 0) {
            $p = $e.prev('div.dz-preview');
            if ($p.length == 0) $p = $e.nextAll('div.dz-preview').last();
            if ($p.length > 0) {
                $e.removeClass('currentImage');
                $p.addClass('currentImage');
                $i = $preview.find('img');
                $i.attr('src', $i.attr('root-path') + $p.find('.dz-details> .dz-filename > span').text().trim());
            }
        }
    });

    $nextButton.on('click', function (e) {
        var $n, $e = $('div.dz-preview.currentImage');
        if ($e.length > 0) {
            $n = $e.next('div.dz-preview');
            if ($n.length == 0) $n = $e.prevAll('div.dz-preview').first();
            if ($n.length > 0) {
                $e.removeClass('currentImage');
                $n.addClass('currentImage');
                $i = $preview.find('img');
                $i.attr('src', $i.attr('root-path') + $n.find('.dz-details> .dz-filename > span').text().trim());
            }
        }
    });

    pv.show = function (e) {
        if ($overlay == null) {
            if ($('div#previewoverlay', parent.document).length == 0) {
                $overlay = $('<div id="previewoverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; opacity: 0.5; filter: alpha(opacity=50); z-index: 10001; display: none;"></div>');
                $('body', parent.document).append($overlay);
            }
            else
                $overlay = $('div#previewoverlay', parent.document);
        }
        if ($preview == null) {
            if ($('div#preview', parent.document).length == 0) {
                $preview = $('<div id="preview" style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); padding: 8px; border-radius: 8px; background: #fff; padding: 20px; text-align: center; z-index: 10002; display: none;"><img alt="" /></div>'); //<div style="overflow: scroll; width: 100%; height: 100%;"></div>
                $('body', parent.document).append($preview);
            }
            else
                $preview = $('div#preview', parent.document);
        }

        $(e.delegateTarget).parent('.dz-preview').addClass('currentImage');

        $preview.append($prevButton, $nextButton, $closeButton);
        $preview.find('img').attr('src', 'image.php?type=evalimage&type=evalimage&cid=' + $('#companyID').attr('value') + '&eid=' + 
            $(e.delegateTarget).parents('form').find('input#evaluationID').val() + '&pid=' + $('#projectID').attr('value') + '&name=' +
            $(e.delegateTarget).parent().find('.dz-details > .dz-filename > span').text()).attr('root-path', 'image.php?type=evalimage&cid=' + $('#companyID').attr('value') + '&eid=' +
            $(e.delegateTarget).parents('form').find('input#evaluationID').val() + '&pid=' + $('#projectID').attr('value')).on('load', resizeImage);
        $preview.width($(parent).width() - 100);
        $preview.height($(parent).height() - 100);
        $overlay.show();
        $preview.show();

        e.stopPropagation();
        e.preventDefault();
    };

    return pv;
}();

var resizeImage = function(e){
    if ($(e.delegateTarget).width() > $(e.delegateTarget).parent().width()) {
        $(e.delegateTarget).css('width', '100%');
        $(e.delegateTarget).css('height', 'auto');
    }
    if ($(e.delegateTarget).height() > $(e.delegateTarget).parent().height()) {
        $(e.delegateTarget).css('height', '100%');
        $(e.delegateTarget).css('width', 'auto');
    }
}

var modal = function () {

    var method = {},
    $overlay,
    $modal,
    $content,
    $no,
    $yes;

    // Center the modal in the viewport
    method.center = function () {
        var top, left;

        top = Math.max($(parent).height() - $modal.outerHeight(), 0) / 2;
        left = Math.max($(parent).width() - $modal.outerWidth(), 0) / 2;

        $modal.css({
            top: top + $(parent).scrollTop(),
            left: left + $(parent).scrollLeft()
        });
    };

    // Open the modal

    method.open = function (settings) {
        $modal.append($content, $yes, $no);

        $content.empty().append(settings.content);
        $modal.css({
            width: settings.width || 'auto',
            height: settings.height || 'auto'
        });

        $name = settings.name;
        $image = settings.image;

        method.center();
        $(window).bind('resize.modal', method.center);
        $modal.show();
        $overlay.show();
    };

    // Close the modal

    method.close = function () {
        $modal.hide();
        $overlay.hide();
        //$modal.empty();
        $yes.detach();
        $no.detach();
        $content.empty();
        $(window).unbind('resize.modal');
    };

    // Generate the HTML and add it to the document

    $content = $('<div id="content" style="font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; font-size: .8rem; color: #353536; font-weight: bold;"></div>');
    $yes = $('<a class="button small" href="#null" id="yes" style="font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; font-size: .8rem; color: #ffffff; padding: .4rem .8rem .4rem .8rem; background-color: #353536; text-decoration: none; border-radius: 5px; margin-right: 0.5rem;">Yes</a>');
    $no = $('<a class="button small" href="#null" id="no" style="font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; font-size: .8rem; color: #ffffff; padding: .4rem .8rem .4rem .8rem; background-color: #353536; text-decoration: none; border-radius: 5px; margin-left: 0.5rem;">No</a>');

    $(document).ready(function () {
        if ($('div#overlay', parent.document).length == 0) {
            $overlay = ('<div id="overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; opacity: 0.5; filter: alpha(opacity=50); z-index: 9999; display: none;"></div>');
            $('body', parent.document).append($overlay);
        }
        else
            $overlay = $('div#overlay', parent.document);

        if ($('div#modal', parent.document).length == 0) {
            $modal = ('<div id="modal" style="position: absolute; padding: 8px; border-radius: 8px; background: #fff; padding: 20px; text-align: center; z-index: 10000; display: none;"></div>');
            $('body', parent.document).append($modal);
        }
        else
            $modal = $('div#modal', parent.document);
    });

    $no.click(function (e) {
        e.preventDefault();
        method.close();
    });

    $yes.click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var originalSection = $image.find('.is-hidden').attr('value');

        $.ajax({
            url: 'dropzone-delete.php',
            dataType: "json",
            contentType: 'application/json',
            type: "POST",
            contentType: "application/x-www-form-urlencoded",
            data: {
                photoName: $name,
                evaluationID: $('#evaluationID').val(),
                projectID: $('#projectID').val(),
                section: $('#section').val(),
            },
            success: function (response) {
                if ($('#section').val() == "general"){
                    if ($.isFunction(parent.updateDropzone)) parent.updateDropzone(originalSection);
                }
                else{
                    if ($.isFunction(parent.updateDropzone)) parent.updateDropzone("general");
                }
                
                ($image).remove();

                if (!$('#my-dropzone').has('.dz-preview.dz-image-preview').length) {
                    //$('#my-dropzone').addClass('noPreview');
                    $('#my-dropzone').append('<div class="dz-default dz-message"><span></span></div>');
                }
                parent.resizeDropzone($('#section').val(), $(document).height());
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            },
            complete: function (jqXHR, textStatus) {
            }
        });
        method.close();
    });

    return method;
}();


/*
var modal = (function () {

    var method = {},
    $overlay,
    $modal,
    $content,
    $no,
    $yes;

    // Center the modal in the viewport
    method.center = function () {
        var top, left;

        top = Math.max($(window).height() - $modal.outerHeight(), 0) / 2;
        left = Math.max($(window).width() - $modal.outerWidth(), 0) / 2;

        $modal.css({
            top: top + $(window).scrollTop(),
            left: left + $(window).scrollLeft()
        });
    };

    // Open the modal

    method.open = function (settings) {
        $content.empty().append(settings.content);
        $modal.css({
            width: settings.width || 'auto',
            height: settings.height || 'auto'
        });

        $name = settings.name;
        $image = settings.image;

        method.center();
        $(window).bind('resize.modal', method.center);
        $modal.show();
        $overlay.show();
    };

    // Close the modal

    method.close = function () {
        $modal.hide();
        $overlay.hide();
        $content.empty();
        $(window).unbind('resize.modal');
    };

    // Generate the HTML and add it to the document

    $overlay = $('<div id="overlay"></div>');
    $modal = $('<div id="modal"></div>');
    $content = $('<div id="content"></div>');
    $yes = $('<a class="button small" href="#" id="yes">Yes</a>');
    $no = $('<a class="button small" href="#" id="no">No</a>');

    $modal.hide();
    $overlay.hide();
    $modal.append($content, $yes, $no);

    $(document).ready(function () {
        $('body').append($overlay, $modal);
    });

    $no.click(function (e) {
        e.preventDefault();
        method.close();
    });

    $yes.click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            url: 'dropzone-delete.php',
            dataType: "json",
            contentType: 'application/json',
            type: "POST",
            contentType: "application/x-www-form-urlencoded",
            data: {
                photoName: $name,
                evaluationID: $('#evaluationID').val(),
                section: $('#section').val(),
            },
            success: function (response) {

                ($image).remove();

                if (!$('#my-dropzone').has('.dz-preview.dz-image-preview').length) {
                    //$('#my-dropzone').addClass('noPreview');
                    $('#my-dropzone').append('<div class="dz-default dz-message"><span></span></div>');
                }
                parent.resizeDropzone($('#section').val(), $(document).height());
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            },
            complete: function (jqXHR, textStatus) {
            }
        });
        method.close();
    });

    return method;
}());
*/