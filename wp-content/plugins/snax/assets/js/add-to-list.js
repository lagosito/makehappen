/* global document */
/* global jQuery */
/* global uploader */
/* global snax */
/* global alert */
/* global confirm */

// Post namespace.
snax.post = {};

(function ($, ctx) {

    'use strict';

    // Init components.
    $(document).ready(function() {
        ctx.tabs.init();
        ctx.uploadImage.init();
        ctx.uploadEmbed.init();
    });

})(jQuery, snax.post);


/*******************
 *
 * Component: Tabs
 *
 ******************/

(function ($, ctx) {

    'use strict';

    /** CONFIG *******************************************/

    // Register new component.
    ctx.tabs = {};

    // Component namespace shortcut.
    var c = ctx.tabs;

    // CSS selectors.
    var selectors = {
        'tabsNav':              '.snax-tabs-nav',
        'tabsNavItem':          '.snax-tabs-nav-item',
        'tabsNavItemCurrent':   '.snax-tabs-nav-item-current',
        'tabContent':           '.snax-tab-content',
        'tabContentCurrent':    '.snax-tab-content-current',
        'focusableFields':      'input,textarea'

    };

    // CSS classes.
    var classes = {
        'tabsNavItemCurrent':   'snax-tabs-nav-item-current',
        'tabContentCurrent':    'snax-tab-content-current'
    };

    // Allow accessing
    c.selectors   = selectors;
    c.classes     = classes;

    /** INIT *******************************************/

    c.init = function () {
        c.attachEventHandlers();
    };

    /** EVENTS *****************************************/

    c.attachEventHandlers = function() {

        /* Switch tab */

        $(selectors.tabsNavItem).on('click', function(e) {
            e.preventDefault();

            var $tab = $(this);

            // Remove current selection.
            $(selectors.tabsNavItemCurrent).removeClass(classes.tabsNavItemCurrent);
            $(selectors.tabContentCurrent).removeClass(classes.tabContentCurrent);

            // Select current nav item.
            $tab.addClass(classes.tabsNavItemCurrent);

            // Select current content (with the same index as selected nav item).
            var navItemIndex = $(selectors.tabsNavItem).index($tab);

            var $tabContent = $(selectors.tabContent).eq(navItemIndex);

            $tabContent.addClass(classes.tabContentCurrent);

            // Focus first field.
            $tabContent.find(selectors.focusableFields).filter(':visible:first').focus();
        });

    };

})(jQuery, snax.post);


/*************************
 *
 * Component: Upload Image
 *
 ************************/

(function ($, ctx) {

    'use strict';

    /** CONFIG *******************************************/

    // Register new component.
    ctx.uploadImage = {};

    // Component namespace shortcut.
    var c = ctx.uploadImage;

    // CSS selectors.
    var selectors = {
        'wrapper':              '.snax-tab-content',
        'form':                 'form#snax-new-item-image',
        'titleField':           'input[name=snax-item-title]',
        'sourceField':          'input[name=snax-item-source]',
        'descriptionField':     'textarea[name=snax-item-description]',
        'legalField':           'input[name=snax-item-legal]',
        'legalWrapper':         '.snax-new-item-row-legal',
        'mediaWrapper':         '.snax-media',
        'mediaUpload':          '.snax-upload',
        'mediaPreview':         '.snax-upload-preview',
        'mediaPreviewInner':    '.snax-upload-preview-inner',
        'clearPreviewLink':     '.snax-upload-preview-delete',
        'mediaIdField':         '.snax-uploaded-media-id',
        'selectFilesButton':    '#plupload-browse-button',
        'dropArea':             '#drag-drop-area',
        'newItemWrapper':       '.snax-new-item-wrapper',
        'uploadErrors':         '#media-items .error-div.error, #media-items .media-item.error, #media-items #media-upload-error'
    };

    // CSS classes.
    var classes = {
        'wrapperFocus':         'snax-tab-content-focus',
        'wrapperBlur':          'snax-tab-content-blur',
        'formPriorMedia':       'snax-form-prior-media',
        'formWithMedia':        'snax-form-with-media',
        'formWithoutMedia':     'snax-form-without-media',
        'fieldValidationError': 'snax-validation-error',
        'newItemProcessing':    'snax-new-item-wrapper-processing'
    };

    var i18n = {
        'confirm':              'Are you sure?',
        'multiDropForbidden':   'You can drop only one file here. Last file will be used.'
    };

    // Allow accessing
    c.selectors = selectors;
    c.classes   = classes;
    c.i18n      = i18n;

    // Vars.
    var $form, newItemData, skipUploadComplete;

    /** INIT *******************************************/

    c.init = function () {
        $form = $(selectors.form);

        if (!$form.length) {
            snax.log('Snax Post Error: Image form not found!');
            return;
        }

        if (snax.currentUserId === 0) {
            c.attachLoginEvents();
            return;
        }

        if (typeof uploader === 'undefined') {
            snax.log('Snax Post Error: uploader instance not defined!');
            return;
        }

        if (typeof snax.newItemData === 'undefined') {
            snax.log('Snax Post Error: New item base data is not defined!');
            return;
        }

        newItemData = snax.newItemData;

        // Prevent WP from sending extra request for upload media preview.
        window.prepareMediaItem = function () {};

        c.loadPreview();
        c.attachEventHandlers();
    };

    /** EVENTS *****************************************/

    c.attachEventHandlers = function() {

        uploader.bind('FilesAdded', function (up) {
            // Block multiple files dropping.
            if ( ! up.getOption('multi_selection') && up.files.length > 1) {
                alert(i18n.multiDropForbidden);

                while (up.files.length > 1) {
                    up.removeFile(up.files[0]);
                }
            }
        });

        /** Upload image */

        uploader.bind('FileUploaded', function (up, file, response) {
            // Remove all old errors.
            $form.find(selectors.uploadErrors).empty();

            // if async-upload returned an error message, we need to catch it here
            c.uploadError();

            var uploadedMediaId = parseInt(response.response, 10);

            if (!isNaN(uploadedMediaId)) {
                skipUploadComplete = true;

                c.showUploadedMedia(uploadedMediaId);
            }
        });

        uploader.bind('Error', function () {
            c.uploadError();
        });

        uploader.bind('UploadComplete', function () {
            if (!skipUploadComplete) {
                c.uploadComplete();
            }
        });

        uploader.bind('UploadProgress', function (up, file) {
            c.uploadProgress(up, file);
        });

        /** Submit new item */

        $(selectors.form).submit(function (e) {
            // Collect form data.
            var $title              = $form.find(selectors.titleField);
            var $mediaRow           = $form.find(selectors.mediaWrapper);
            var $source             = $form.find(selectors.sourceField);
            var $description        = $form.find(selectors.descriptionField);
            var $legal              = $form.find(selectors.legalField);
            var $uploadedMediaId    = $form.find(selectors.mediaIdField);

            var formValid = true;

            // Validate uploaded image.
            if ($uploadedMediaId.val() === '') {
                $mediaRow.addClass(classes.fieldValidationError);

                formValid = false;
            } else {
                $mediaRow.removeClass(classes.fieldValidationError);
            }

            // Validate legal, if required.
            var legalAccepted = false;

            if ($legal.length > 0) { // If there is no legal field, skip front validation.
                var $legalWrapper = $form.find(selectors.legalWrapper);
                legalAccepted = $legal.is(':checked');

                if (!legalAccepted) {
                    $legalWrapper.addClass(classes.fieldValidationError);

                    formValid = false;
                } else {
                    $legalWrapper.removeClass(classes.fieldValidationError);
                }
            }

            if (formValid) {
                // All data correct, submit new item.
                var item = snax.ImageItem({
                    'title':        $.trim($title.val()),
                    'source':       $.trim($source.val()),
                    'description':  $.trim($description.val()),
                    'mediaId':      parseInt($uploadedMediaId.val(), 10),
                    'postId':       newItemData.postId,
                    'authorId':     newItemData.authorId,
                    'origin':       'contribution',
                    'legal':        legalAccepted
                });

                item.save(function(res) {
                    if (res.status === 'success') {
                        location.href = res.args.redirect_url;
                    } else {
                        alert(res.message);
                    }
                });
            }

            // Stop default form submission. It's done via ajax.
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            return false;
        });

        /* Clear Preview */

        $form.find(selectors.clearPreviewLink).on('click', function(e) {
            e.preventDefault();

            if (!confirm(i18n.confirm)) {
                return;
            }

            var $preview = $form.find(selectors.mediaPreview);
            var mediaId = parseInt($preview.attr('data-snax-media-id'), 10);

            $form.removeClass(classes.formWithMedia);

            c.clearPreview();
            snax.deleteMedia({
                'mediaId':  mediaId,
                'authorId': snax.currentUserId
            });
        });
    };

    c.attachLoginEvents = function() {
        $form.find(selectors.dropArea).on('drop', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            snax.loginRequired();
        });

        $(selectors.selectFilesButton).on('click', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            snax.loginRequired();
        });
    };

    c.loadPreview = function() {
        var $preview = $form.find(selectors.mediaPreview);
        var mediaId = parseInt($preview.attr('data-snax-media-id'), 10);

        if (mediaId > 0) {
            c.showUploadedMedia(mediaId);
        }
    };

    c.showUploadedMedia = function (id) {
        var $preview = $form.find(selectors.mediaPreview);
        var $previewInner = $form.find(selectors.mediaPreviewInner);
        var postId = snax.newItemData.postId;

        c.clearPreview();

        snax.getMediaHtmlTag({ 'mediaId': id, 'postId': postId }, function(res) {
            if (res.status === 'success') {
                $form.removeClass(classes.formWithoutMedia).removeClass(classes.formPriorMedia).addClass(classes.formWithMedia);

                $preview.attr('data-snax-media-id', id);
                $previewInner.append(res.args.html);

                c.uploadComplete();
            }
        });

        $form.find(selectors.mediaIdField).val(id);

        $form.parents(selectors.wrapper).
            removeClass(classes.wrapperBlur).
            addClass(classes.wrapperFocus);
    };

    c.clearPreview = function() {
        $form.removeClass(classes.formWithMedia).addClass(classes.formWithoutMedia);

        var $previewInner = $form.find(selectors.mediaPreviewInner);

        $previewInner.empty();

        $form.find(selectors.mediaIdField).val('');
    };

    c.uploadError = function() {
        var $errors = $form.find(selectors.uploadErrors);

        $errors.each(function() {
            var $error = $(this);

            if ($error.html().length === 0) {
                return;
            }

            // Get rid of unwanted HTML elements (UI controls, headers).
            $error.find('a.dismiss').remove();

            var $previewInner = $form.find(selectors.mediaPreviewInner);

            $previewInner.append($error.html());
        });
    };

    c.uploadProgress = function() {
        $form.parents(selectors.newItemWrapper).addClass(classes.newItemProcessing);
    };

    c.uploadComplete = function() {
        $form.parents(selectors.newItemWrapper).removeClass(classes.newItemProcessing);
        $form.find(selectors.titleField).focus();
    };

})(jQuery, snax.post);


/*************************
 *
 * Component: Upload Embed
 *
 ************************/

(function ($, ctx) {

    'use strict';

    /** CONFIG *******************************************/

    // Register new component.
    ctx.uploadEmbed = {};

    // Component namespace shortcut.
    var c = ctx.uploadEmbed;

    // CSS selectors.
    var selectors = {
        'wrapper':              '.snax-tab-content',
        'form':                 'form#snax-new-item-embed',
        'titleField':           'input[name=snax-item-title]',
        'descriptionField':     'textarea[name=snax-item-description]',
        'legalField':           'input[name=snax-item-legal]',
        'legalWrapper':         '.snax-new-item-row-legal',
        'embedCodeField':       'textarea[name=snax-item-embed-code]',
        'embedCodeWrapper':     '.snax-new-item-row-embed-code',
        'wrongEmbedCodeTip':    '.snax-validation-tip',
        'mediaWrapper':         '.snax-media',
        'mediaPreviewInner':    '.snax-upload-preview-inner',
        'clearPreviewLink':     '.snax-upload-preview-delete',
        'newItemWrapper':       '.snax-new-item-wrapper'
    };

    // CSS classes.
    var classes = {
        'wrapperFocus':         'snax-tab-content-focus',
        'wrapperBlur':          'snax-tab-content-blur',
        'formPriorMedia':       'snax-form-prior-media',
        'formWithMedia':        'snax-form-with-media',
        'formWithoutMedia':     'snax-form-without-media',
        'fieldValidationError': 'snax-validation-error',
        'mediaUploaded':        'snax-media-uploaded',
        'newItemProcessing':    'snax-new-item-wrapper-processing'
    };


    var i18n = {
        'confirm':      'Are you sure?'
    };

    // Allow accessing
    c.selectors   = selectors;
    c.classes     = classes;
    c.i18n        = i18n;

    // Vars.
    var $form, newItemData;

    /** INIT *******************************************/

    c.init = function () {
        $form = $(selectors.form);

        if (!$form.length) {
            snax.log('Snax Post Error: Embed form not found!');
            return;
        }

        if (snax.currentUserId === 0) {
            c.attachLoginEvents();
            return;
        }

        if (typeof snax.newItemData === 'undefined') {
            snax.log('Snax Post Error: New item base data is not defined!');
            return;
        }

        newItemData = snax.newItemData;

        c.attachEventHandlers();
    };

    /** EVENTS *****************************************/

    c.attachEventHandlers = function() {

        /* Enter urls */

        $(selectors.embedCodeField).on('keyup', function() {
            var $textarea = $(this);

            $form.parents(selectors.newItemWrapper).addClass(classes.newItemProcessing);

            var embedUrl = $.trim($textarea.val());

            snax.getEmbedPreview(embedUrl, function(res) {
                var $previewInner   = $form.find(selectors.mediaPreviewInner);
                var $embedWrapper   = $form.find(selectors.embedCodeWrapper);
                var $errorFeedback  = $embedWrapper.find(selectors.wrongEmbedCodeTip);

                c.clearPreview();

                if (res.status === 'success') {
                    $form.
                        removeClass(classes.formWithoutMedia).
                        removeClass(classes.formPriorMedia).
                        addClass(classes.formWithMedia);

                    $embedWrapper.removeClass('snax-validation-error');

                    $errorFeedback.text('');

                    // Show feedback.
                    $previewInner.append(res.args.html);

                    // Show all other fields.
                    $form.parents(selectors.wrapper).
                        removeClass(classes.wrapperBlur).
                        addClass(classes.wrapperFocus);
                } else {
                    $embedWrapper.addClass('snax-validation-error');
                    $errorFeedback.text(res.message);
                }

                $form.parents(selectors.newItemWrapper).removeClass(classes.newItemProcessing);
                $form.find(selectors.titleField).focus();
            });
        });

        /* Submit new item */

        $(selectors.form).submit(function (e) {
            // Collect form data.
            var $title          = $form.find(selectors.titleField);
            var $embedCode      = $form.find(selectors.embedCodeField);
            var $mediaWrapper   = $form.find(selectors.mediaWrapper);
            var $description    = $form.find(selectors.descriptionField);
            var $legal          = $form.find(selectors.legalField);

            var formValid = true;

            // Validate embed code.
            if ($.trim($embedCode.val()) === '') {
                $mediaWrapper.addClass(classes.fieldValidationError);

                formValid = false;
            } else {
                $mediaWrapper.removeClass(classes.fieldValidationError);
            }

            // Validate legal, if required.
            var legalAccepted = false;

            if ($legal.length > 0) { // If there is no legal field, skip front validation.
                var $legalWrapper = $form.find(selectors.legalWrapper);

                legalAccepted = $legal.is(':checked');

                if (!legalAccepted) {
                    $legalWrapper.addClass(classes.fieldValidationError);

                    formValid = false;
                } else {
                    $legalWrapper.removeClass(classes.fieldValidationError);
                }
            }

            if (formValid) {
                // All data correct, submit new item.
                var item = snax.EmbedItem({
                    'title':        $.trim($title.val()),
                    'description':  $.trim($description.val()),
                    'embedCode':    $.trim($embedCode.val()),
                    'postId':       newItemData.postId,
                    'authorId':     newItemData.authorId,
                    'origin':       'contribution',
                    'legal':        legalAccepted
                });

                item.save(function(res) {
                    if (res.status === 'success') {
                        location.href = res.args.redirect_url;
                    } else {
                        alert(res.message);
                    }
                });
            }

            // Stop default form submission. It's done via ajax.
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            return false;
        });

        /* Clear Preview */

        $form.find(selectors.clearPreviewLink).on('click', function(e) {
            e.preventDefault();

            if (!confirm(i18n.confirm)) {
                return;
            }

            $form.removeClass(classes.formWithMedia).addClass(classes.formWithoutMedia);

            $form.find(selectors.embedCodeField).val('');

            c.clearPreview();
        });
    };

    c.attachLoginEvents = function() {
        $(document).on('paste drop', selectors.embedCodeField, function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            snax.loginRequired();
        });

        $(selectors.embedCodeField).on('click', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            snax.loginRequired();
        });
    };

    c.clearPreview = function() {
        var $previewInner = $form.find(selectors.mediaPreviewInner);

        $previewInner.empty();

        $form.find(selectors.mediaWrapper).removeClass(classes.fieldValidationError);
    };

})(jQuery, snax.post);
