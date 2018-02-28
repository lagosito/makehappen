/* global document */
/* global jQuery */
/* global uploader */
/* global snax */
/* global alert */
/* global confirm */
/* global plupload */
/* global snaxDemoItemsConfig */
/* global fabric */
/* global snax_quizzes */

snax.frontendSubmission = {};

(function ($, ctx) {

    'use strict';

    // Load config.
    ctx.config = $.parseJSON(window.snax_front_submission_config);

    // Init components.
    $(document).ready(function() {
        ctx.form.init();
        ctx.tabs.init();
        ctx.uploadImages.init();
        ctx.uploadEmbeds.init();
        ctx.cards.init();
        ctx.memeGenerator.init();
        ctx.quiz.init();
    });

})(jQuery, snax.frontendSubmission);


/*******************
 *
 * Component: Form
 *
 ******************/

(function ($, ctx) {

    'use strict';

    /** CONFIG *******************************************/

    // Register new component.
    ctx.form = {};

    // Component namespace shortcut.
    var c = ctx.form;

    // CSS selectors.
    var selectors = {
        'post':             '.snax-form-frontend',
        'item':             '.snax-object, .snax-card',
        'postTitle':        '#snax-post-title',
        'postTags':         'input#snax-post-tags',
        'postCategory':     'select#snax-post-category',
        'postDescription':  'textarea#snax-post-description',
        'postHasSource':    'input#snax-post-has-source',
        'postSource':       'input#snax-post-source',
        'postLegal':        'input#snax-post-legal',
        'postContentTitle': '#snax-post-title-editable',
        'postContentEditor':'textarea.snax-content-editor',
        'insertButton':     '.snax-form-frontend .snax-insert-button',
        'mediaForm':        '.snax-edit-post-row-media',
        'postContentTitleWrapper':  '.snax-edit-post-row-title',
        'publishPostButton':'.snax-button-publish-post',
        'previewPostButton':'.snax-button-preview'
    };

    var classes = {
        'postWithoutItems':     '.snax-form-without-items',
        'validationError':      'snax-validation-error',
        'froalaSimpleEditor':   'froala-editor-simple'
    };

    var i18n = {
        'confirm':      ctx.config.i18n.are_you_sure
    };

    // Allow accessing
    c.selectors = selectors;
    c.classes   = classes;
    c.i18n      = i18n;

    /** INIT *******************************************/

    c.init = function () {
        c.attachEventHandlers();
    };

    /** EVENTS *****************************************/

    c.attachEventHandlers = function() {
        c.validateForm();
        c.focusOnTitle();
        c.categoryRequirement();
        c.applyTagIt();
        c.applyFroala();
        c.resetForm();
        c.previewPost();
    };

    c.resetForm = function () {
        // Empty fields if post has media.
        if (!$(selectors.post).is('.snax-form-frontend-without-media') && !$(selectors.post).is('.snax-form-frontend-edit-mode')) {
            c.emptyFields();
        }
    };

    c.previewPost = function () {
        $(selectors.previewPostButton).on('click', function(e) {
            e.preventDefault();

            var url = $(this).attr('data-snax-preview-url');

            if (url) {
                window.open(url, '_blank');
            }
        });
    };

    c.categoryRequirement = function() {
        $(selectors.postCategory).on('change', function() {
            var $select = $(this);
            var current = parseInt($select.val(), 10);

            if (-1 !== current) {
                $select.parents('.snax-edit-post-row-categories').removeClass(classes.validationError);
            }
        });
    };

    c.validateForm = function() {
        $(selectors.post).submit(function(e) {
            var $wrapper = $(this);

            // Check if title is filled.
            var $postTitle = $(selectors.postTitle);

            if ($postTitle.val().length === 0) {
                var $postContentTitle = $(selectors.postContentTitle);  // Content editable elements (H1).

                // Content editable field exists and it's empty.
                if ($postContentTitle.length > 0 && $postContentTitle.text().length === 0) {
                    $(selectors.postContentTitleWrapper).addClass(classes.validationError);

                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    return false;
                } else {
                    $postTitle.val($postContentTitle.text());
                }
            }

            // Check if format requires items.
            if ( ! $wrapper.is(classes.postWithoutItems) ) {
                var $items = $wrapper.find(selectors.item);
                var valid;

                valid = $items.length > 0;

                if (!valid) {
                    var errorMessage = 'You need to choose at least one file/embed!';

                    alert(errorMessage);

                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    return false;
                }
            }

            // Check if category selected.
            var $categoryWrapper = $('.snax-edit-post-row-categories');

            if ($categoryWrapper.is('.snax-field-required')) {
                // Check if selected.
                var selectedCategory = parseInt($(selectors.postCategory).val(), 10);

                // Not valid.
                if (-1 === selectedCategory) {
                    $categoryWrapper.addClass(classes.validationError);

                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    return false;
                }
            }

            // Meme format.
            if ($wrapper.is('.snax-form-frontend-format-meme')) {
                var base64image = ctx.memeGenerator.getImageBase64();

                if (!base64image) {
                    alert('Meme image generation failed!');
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    return false;
                }

                var $memeImage = $('<textarea id="snax-post-meme" name="snax-post-meme" ></textarea>');
                $memeImage.val(base64image);
                $memeImage.hide();

                $wrapper.prepend($memeImage);
            }

            // All is ok, we can process submission.
            $(selectors.publishPostButton).attr( 'disabled', 'disabled' );
        });
    };

    c.focusOnTitle = function () {

        $(selectors.postTitle).each(function() {
            var $title = $(this);

            if ($title.is(':visible') && $title.val().length === 0 && !$title.is('.snax-focused')) {
                $title.focus();
                $title.addClass('snax-focused');
            }
        });
    };

    c.applyTagIt = function () {

        // Check if jQuery script is loaded.
        if (!$.fn.tagit) {
            return;
        }

        $(selectors.postTags).each(function() {
            var $input = $(this);

            var tagsLimit = parseInt(ctx.config.tags_limit, 10);

            var config = {
                'singleField':      true,
                'allowSpaces':      true,
                'tagLimit':         tagsLimit || 10,
                'placeholderText':  $input.prop('placeholder'),
                // Auto-loaded list of tags.
                'availableTags':    ctx.config.tags,
                'autocomplete':     {
                    'appendTo':   '.snax-autocomplete',
                    'position':     {
                        'my':       'left top',
                        'of':       '.snax-autocomplete'
                    },
                    'delay':      0,
                    'minLength':  1
                },
                showAutocompleteOnFocus: true
            };

            // Use ajax to load tags.
            if (ctx.config.tags_force_ajax || ctx.config.tags.length === 0) {
                config.autocomplete.delay = 500;
                config.autocomplete.minLength = 2;
                config.autocomplete.source = function(request, response) {
                    var xhr = $.ajax({
                        'type': 'GET',
                        'url': snax.config.ajax_url,
                        'dataType': 'json',
                        'data': {
                            'action':       'snax_get_tags',
                            'snax_term':    request.term
                        }
                    });

                    xhr.done(function (res) {
                        if (res.status === 'success') {
                            response(res.args.tags);
                        }
                    });
                };
            }

            if (typeof c.tagitConfig === 'function') {
                config = c.tagitConfig(config);
            }

            /*
             Change tagIt condig via child theme modifications.js:
             -----------------------------------------------------

             $.ui.keyCode.COMMA = $.ui.keyCode.ENTER; // To prevent comma as a delimiter.

             // Way to override tagIt config. Here to change placeholder text only.
             snax.frontendSubmission.form.tagitConfig = function (config) {
                 config.placeholderText = 'Separate tags with Enter'

                 return config;
             };
             */

            $input.tagit(config);

            // Hide jQuery UI accessibility status.
            $('.ui-helper-hidden-accessible').hide();
        });

        $('ul.tagit').each(function() {
            var $this = $(this);

            $this.find( 'input[type=text]' )
                .on('focus', function() {
                    $this.addClass('tagit-focus');
                })
                .on('blur', function() {
                    $this.removeClass('tagit-focus');
                });
        });
    };

    c.applyFroala = function () {

        // Check if Froals script is loaded.
        if (!$.fn.froalaEditor) {
            return;
        }

        $(selectors.postDescription).each(function() {
            var $textarea = $(this);

            if (!$textarea.hasClass(classes.froalaSimpleEditor)) {
                return;
            }

            var config = {
                'key':              'CMFIZJNKLDXIREJI==',
                'language':         c.getFroalaEditorConfig('language'),
                'heightMin':        200,
                // Toolbar buttons on large devices (≥ 1200px).
                'toolbarButtons':   ['bold', 'italic', 'insertLink', 'formatOL', 'formatUL', '|', 'undo', 'redo'],
                // On medium devices (≥ 992px).
                toolbarButtonsMD:   ['bold', 'italic', 'insertLink', 'formatOL', 'formatUL', '|', 'undo', 'redo'],
                // On small devices (≥ 768px).
                toolbarButtonsSM:   ['bold', 'italic', 'insertLink', 'formatOL', 'formatUL', '|', 'undo', 'redo'],
                // On extra small devices (< 768px).
                toolbarButtonsXS:   ['bold', 'italic', 'insertLink', 'formatOL', 'formatUL', '|', 'undo', 'redo'],
                quickInsertButtons: ['ol', 'ul'],
                charCounterMax:     c.getFroalaEditorMaxCharacters($textarea)
            };

            // Override Froala's config using this filter function.
            if (typeof ctx.froalaEditorConfig === 'function') {
                config = ctx.froalaEditorConfig(config);
            }

            if (snax.inDebugMode()) {
                snax.log(config);
            }

            // Init.
            $textarea.froalaEditor(config);
        });
    };

    c.getFroalaEditorConfig = function(id) {
        var config = ctx.config.froala;

        if (typeof config[id] !== 'undefined') {
            return config[id];
        }

        return null;
    };

    c.getFroalaEditorMaxCharacters = function($editor) {
        var maxCharacters = parseInt($editor.attr('maxlength'), 10);

        return maxCharacters > 0 ? maxCharacters : -1;
    };

    c.emptyFields = function () {
        // Title.
        $(selectors.postTitle).val('');

        // Description.
        var $description = $(selectors.postDescription);

        if ($description.is('.froala-editor-simple')) {
            $description.froalaEditor('html.set', '');
        } else {
            $description.val('');
        }

        // Category.
        $(selectors.postCategory).find('option:selected').removeAttr('selected');

        // Tags.
        var $tagsInput = $(selectors.postTags);

        $tagsInput.val('');

        if ($.fn.tagit) {
            $tagsInput.tagit('removeAll');
        }

        // Source.
        $(selectors.postHasSource).removeAttr('checked');
        $(selectors.postSource).val('');

        // Legal.
        $(selectors.postLegal).removeAttr('checked');
    };

})(jQuery, snax.frontendSubmission);

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

})(jQuery, snax.frontendSubmission);


/**************************
 *
 * Component: Upload Images
 *
 *************************/

(function ($, ctx) {

    'use strict';

    /** CONFIG *******************************************/

    // Register new component
    ctx.uploadImages = {};

    // Component namespace shortcut
    var c = ctx.uploadImages;

    // CSS selectors
    var selectors = {
        'post':                     '.snax-form-frontend',
        'postTitle':                '#snax-post-title',
        'parentFormat':             '.snax-form-frontend input[name=snax-post-format]',
        'form':                     '.snax-tab-content-image',
        'image':                    '.snax-card, .snax-image',
        'imagesWrapper':            '.snax-cards, .snax-edit-post-row-image',
        'imageDelete':              '.snax-image-action-delete',
        'demoImagesWrapper':        '.snax-demo-format',
        'loadDemoImagesButton':     '.snax-demo-format-image > a, .snax-demo-format-images > a',
        'demoImages':               'img',
        'loadImageFromUrl':         '.snax-load-image-from-url',
        // File processing.
        'fileProcessing':           '.snax-xofy-x',
        'filesAll':                 '.snax-xofy-y',
        'filesUploadProgressBar':   '.snax-progress-bar',
        'fileState':                '.snax-state',
        'filesStates':              '.snax-states',
        'statesWrapper':            '.snax-details',
        'feedbackCloseButton':      '.snax-close-button',
        'featuredImage':            '#snax-featured-image'
    };

    var classes = {
        'postWithoutMedia':     'snax-form-frontend-without-media',
        'postWithMedia':        'snax-form-frontend-with-media',
        'postWithRemovedMedia': 'snax-form-frontend-with-removed-media',
        'formHidden':           'snax-tab-content-hidden',
        'formVisible':          'snax-tab-content-visible',
        // Files processing.
        'fileState':            'snax-state',
        'fileStateProcessing':  'snax-state-processing',
        'fileStateSuccess':     'snax-state-success',
        'fileStateError':       'snax-state-error',
        'fileProcessed':        'snax-details-expanded'
    };

    var i18n = {
        'confirm':              ctx.config.i18n.are_you_sure,
        'multiDropForbidden':   ctx.config.i18n.multi_drop_forbidden,
        'uploadFailed':         ctx.config.i18n.upload_failed
    };

    c.selectors = selectors;
    c.classes   = classes;
    c.i18n      = i18n;

    var $form,
        parentFormat,
        $filesAll,
        $fileProcessing,
        $filesUploadProgressBar,
        $filesStates,
        fakeUpload,
        uploadStarted,                  // Defines if upload process already started.
        filesAll,                       // Number of all chosen by user files.
        filesAllList,                   // List of all file names choses by user.
        fileProcessing,                 // Index of file currently processing.
        filesUploaded,                  // Number of files already uplaoded.
        filesFailed,                    // Number of files that failed to upload.
        fileStateMessages,              // State messages.
        fileStates;                     // States of processed files. Format: [ { name: 1.jpg, state: 1 }, ... ].
                                        // States: 1 (success),  -1 (error), file not in array (not processed yet).

    /** INIT *******************************************/

    c.init = function () {
        $form = $(selectors.form);

        if (!$form.length) {
            return;
        }

        parentFormat = $(selectors.parentFormat).val();

        if (parentFormat.length === 0) {
            snax.log('Snax Front Submission Error: Parent format not defined!');
            return;
        }

        if (typeof uploader === 'undefined') {
            snax.log('Snax Front Submission Error: uploader instance not defined!');
            return;
        }

        if (snax.currentUserId === 0) {
            snax.log('Snax: Login required');
            return;
        }

        fakeUpload = false;

        // Prevent WP from sending extra request for upload media preview.
        window.prepareMediaItem = function () {};

        c.initQueue();
        c.attachEventHandlers();
    };

    /** PLUPLOAD ****************************************/

    /*
     * When user choose files to upload, only the filtered files will be processed.
     * Filtered files are those passed all registered filters. Pluplod default filters, in order of registartion and execution:
     * - mime_types,
     * - max_file_size,
     * - prevent_duplicates
     * Custom filters are fired only if all above filter passed. But we want to have access to skipped files.
     * The only way to get full list of chosen by user files (even those that won't be finally processed)
     * is to override first default filter (the 'mime_types' filter) and store file list for futher use.
     */
    plupload.addFileFilter('mime_types', function(filters, file, cb) {
        filesAll++;
        filesAllList.push(file);

        if (filters.length && !filters.regexp.test(file.name)) {
            this.trigger('Error', {
                code : plupload.FILE_EXTENSION_ERROR,
                message : plupload.translate('File extension error.'),
                file : file
            });
            cb(false);
        } else {
            cb(true);
        }
    });

    /** EVENTS *****************************************/


    /* Upload file */


    c.attachEventHandlers = function() {
        c.handleFileUploadEvents();

        /** Delete ***************/

        $(selectors.post).on('click', selectors.imageDelete, function(e) {
            e.preventDefault();

            if (!confirm(i18n.confirm)) {
                return;
            }

            var $image = $(this).parents(selectors.image);

            c.deleteImage($image);

            $(selectors.post).addClass( classes.postWithRemovedMedia );
        });

        /** Upload demo image *******/

        $(selectors.loadDemoImagesButton).on('click', function(e) {
            e.preventDefault();

            var $wrapper = $(this).parents(selectors.demoImagesWrapper);
            var $images = $wrapper.find(selectors.demoImages);
            var imagesCount = $images.length;

            if (imagesCount === 0) {
                return;
            }

            $images.each(function() {
                var imageId = parseInt($(this).attr('data-snax-media-id'), 10);
                var fakeFile = {
                    'id': imageId
                };

                filesAll++;
                filesAllList.push(fakeFile);
            });

            // Fake uploading process.
            fakeUpload = true;

            c.uploadStart();

            var uploadInterval = imagesCount === 1 ? 1000 : 700;

            var fakeUploadImages = function(index) {
                if (index === filesAll || filesAllList.length === 0) {
                    return;
                }

                var fakeFile = filesAllList[index];

                var fakeFileData = {};

                if (typeof snaxDemoItemsConfig !== 'undefined' && snaxDemoItemsConfig[fakeFile.id]) {
                    fakeFileData = snaxDemoItemsConfig[fakeFile.id];
                }

                c.createImageItem(fakeFile.id, null, fakeFileData);

                c.fileProcessed(fakeFile, 1);

                setTimeout(function() {
                    index++;
                    fakeUploadImages(index);
                }, uploadInterval);
            };

            fakeUploadImages(0);
        });

        /** Load image from url **/

        $(selectors.loadImageFromUrl).on('paste', function() {
            var $url = $(this);

            setTimeout(function () {
                c.uploadFromUrl($url.val());
            }, 200);
        });

        /** Close feedback *******/

        $(selectors.feedbackCloseButton).on('click', function(e) {
            e.preventDefault();

            snax.hideFeedback();
        });
    };

    c.handleFileUploadEvents = function() {

        uploader.bind('FilesAdded', function(up) {
            fakeUpload = false;

            // Block multiple files dropping.
            if ( ! up.getOption('multi_selection') && up.files.length > 1) {
                alert(i18n.multiDropForbidden);

                c.initQueue();
                return;

            }

            c.uploadStart();
        });

        uploader.bind('FileUploaded', function (up, file, response) {
            var uploadedMediaId = parseInt(response.response, 10);

            if (!isNaN(uploadedMediaId)) {
                if (typeof c.fileUploadedCallback === 'function') {
                    c.fileUploadedCallback(uploadedMediaId);
                } else {
                    c.createImageItem(uploadedMediaId, function() {
                        c.imageAdded();
                    });
                }
            }

            c.uploadSuccess(file, response.response);
        });

        uploader.bind('Error', function (up, err) {
            if (typeof err.file !== 'undefined') {
                c.fileUploadError(err.file);
            }
        });

        uploader.bind('UploadComplete', function () {
            c.uploadComplete();
        });
    };

    /** API *********************************************/

    c.isValidUrl = function(url) {
        return url.match(/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[\-;:&=\+\$,\w]+@)?[A-Za-z0-9\.\-]+|(?:www\.|[\-;:&=\+\$,\w]+@)[A-Za-z0-9\.\-]+)((?:\/[\+~%\/\.\w\-_]*)?\??(?:[\-\+=&;%@\.\w_]*)#?(?:[\.\!\/\\\w]*))?)/);
    };

    c.uploadFromUrl = function(url) {
        url = $.trim(url);

        if (!url || !c.isValidUrl(url)) {
            return;
        }

        var xhr = $.ajax({
            'type': 'POST',
            'url': snax.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':           'snax_save_image_from_url',
                'security':         $('input[name=snax-add-image-item-nonce]').val(),
                'snax_image_url':   url,
                'snax_author_id':     snax.currentUserId
            }
        });

        xhr.done(function (res) {
            if (res.status === 'success') {
                c.createImageItem(res.args.image_id, function() {
                    c.imageAdded();
                    c.fileProcessed(fakeFile, 1);

                    // Url was processed, empty it.
                    $(selectors.loadImageFromUrl).val('');
                });
            } else {
                c.fileUploadError(fakeFile, res.args.error_message);
            }
        });

        // Simulate uploading process.
        var fakeFile = { 'id': 1 };
        filesAll++;
        filesAllList.push(fakeFile);
        c.uploadStart();
    };

    c.uploadStart = function() {
        if (uploadStarted) {
            return;
        }

        uploadStarted = true;

        c.initFeedback();
    };

    c.uploadSuccess = function(file, response) {
        // If async-upload returned an error message, we need to catch it here.
        if ( response.match(/media-upload-error|error-div/) ) {
            c.fileUploadError(file);
        } else {
            c.fileProcessed(file, 1);
        }
    };

    c.fileProcessed = function(file, status, stateMessage) {
        fileStates[file.id] = status;
        fileStateMessages[file.id] = stateMessage;

        if (status === -1) {
            filesFailed++;
        }
    };

    c.uploadComplete = function() {};

    // This method is triggered when something goest wrong with file upload e.g.:
    // - file is too large
    // - doesn't match allowed mime types
    // - HTTP error during upload
    c.fileUploadError = function(file, errorMessage) {
        // If any of chosen files is valid and normal upload was not fired, we need to init feedback here.
        c.fileProcessed(file, -1, errorMessage);

        // If some error occured and normal upload won't start, we need to run it manually.
        setTimeout(function() {
            c.uploadStart();
        }, 100);
    };

    c.createImageItem = function(id, callback, data) {
        if ($form.is('.snax-tab-content-featured-image')) {
            // @todo - refactor when new upload form will be ready.
            fakeUpload = true;
            var postId = $form.attr('data-snax-parent-post-id') ? parseInt($form.attr('data-snax-parent-post-id'), 10) : '';

            c.setFeaturedImage(id, parentFormat, postId, callback);
        } else {
            callback = callback || function() {};
            data = data || {};

            data = $.extend({
                'mediaId':      id,
                'authorId':     snax.currentUserId,
                'status':       'publish',
                'parentFormat': parentFormat,
                'legal':        true,
                'title':        '',
                'source':       '',
                'description':  ''
            }, data);

            var item = snax.ImageItem(data);

            item.save(function(res) {
                if (res.status === 'success') {
                    switch(parentFormat) {
                        case 'image':
                        case 'meme':
                            c.addImage(res.args.item_id);
                            break;

                        default:
                            ctx.cards.addCard(res.args.item_id);
                    }
                }

                callback(res);
            });
        }
    };

    c.addImage = function(itemId) {
        var xhr = $.ajax({
            'type': 'GET',
            'url': snax.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':          'snax_load_image_item_tpl',
                'snax_item_id':    itemId
            }
        });

        xhr.done(function (res) {
            if (res.status === 'success') {
                var $image = $(res.args.html);

                $(selectors.imagesWrapper).append($image);

                $(selectors.form).removeClass(classes.formVisible);
                $(selectors.form).addClass(classes.formHidden);

                // @todo - MEME refactor
                setTimeout(function() {
                    ctx.memeGenerator.init();
                }, 500);
            }
        });
    };

    c.setFeaturedImage = function(mediaId, parentFormat, postId, callback) {
        var xhr = $.ajax({
            'type': 'GET',
            'url': snax.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':               'snax_load_featured_image_tpl',
                'snax_media_id':        mediaId,
                'snax_parent_format':   parentFormat,
                'snax_post_id':         postId
            }
        });

        xhr.done(function (res) {
            if (res.status === 'success') {
                var $image = $(res.args.html);

                // Hide upload form.
                $(selectors.form).removeClass(classes.formVisible).addClass(classes.formHidden);

                // Load image.
                $(selectors.featuredImage).empty().append($image);

                $('body').trigger('snaxFeaturedImageAdded',[$image, mediaId]);

                callback(res);
            }
        });
    };

    c.deleteImage = function($image) {
        var $link = $image.find(selectors.imageDelete);

        snax.deleteItem($link, function(res) {
            if (res.status === 'success') {
                $image.trigger('snaxImageRemoved',[$image]);

                $image.remove();

                // @todo - refactor
                if ('meme' === parentFormat) {
                    $('.snax-edit-post-row-media canvas, .snax-edit-post-row-media .canvas-container').remove();
                }

                // Allow uploading new image.
                if (!uploader.getOption('multi_selection')) {
                    c.initQueue();
                }

                $(selectors.form).addClass(classes.formVisible);
                $(selectors.form).removeClass(classes.formHidden);
            }
        });
    };

    c.initFeedback = function() {
        fileProcessing = 1;
        filesUploaded = 0;

        $fileProcessing         = $(selectors.fileProcessing);
        $filesAll               = $(selectors.filesAll);
        $filesUploadProgressBar = $(selectors.filesUploadProgressBar);
        $filesStates            = $(selectors.filesStates);

        // Numbers (1 of 5).
        $fileProcessing.text(fileProcessing);
        $filesAll.text(filesAll);

        // Progress bar.
        $filesUploadProgressBar.css('width', 0);

        // States.
        var i;
        $filesStates.empty();
        $(selectors.statesWrapper).removeClass(classes.fileProcessed);

        for(i = 0; i < filesAll; i++) {
            $filesStates.append('<li class="'+ classes.fileState +'"></li>');
        }

        snax.displayFeedback('processing-files');
        c.startPolling();
    };

    var timer;

    c.startPolling = function() {
        timer = setInterval(function() {
            c.updateFeedback();
        }, 500);
    };

    c.stopPolling = function() {
        clearInterval(timer);
    };

    c.updateFeedback = function() {
        if (c.uploadFinished()) {
            return;
        }

        var currentFileIndex = fileProcessing - 1;
        var currentFile      = filesAllList[currentFileIndex];
        var currentFileState = typeof fileStates[currentFile.id] !== 'undefined' ? fileStates[currentFile.id] : 0;

        var $fileState = $(selectors.filesStates).find(selectors.fileState).eq(currentFileIndex);

        $fileState.addClass(classes.fileStateProcessing);

        if (currentFileState !== 0) {
            $fileState.
                removeClass(classes.fileStateProcessing).
                addClass(currentFileState === 1 ? classes.fileStateSuccess : classes.fileStateError);

            if (currentFileState === -1) {
                var errorMessage = $('#media-item-' + currentFile.id + '.error').text();

                // If specific error message not set, display general error info.
                if (!errorMessage) {
                    errorMessage = fileStateMessages[currentFile.id] ? fileStateMessages[currentFile.id] : i18n.uploadFailed;
                }

                $fileState.text(errorMessage);
            }

            fileProcessing++;
            filesUploaded++;

            var progress = filesUploaded / filesAll * 100;

            $fileProcessing.text(filesUploaded);
            $filesUploadProgressBar.css('width', progress + '%');
        }
    };

    c.uploadFinished = function() {
        var finished = filesUploaded === filesAll;

        if (finished) {
            c.stopPolling();

            if (filesFailed > 0) {
                $(selectors.statesWrapper).addClass(classes.fileProcessed);

                // Not all files are broken.
                if (filesFailed < filesAll) {
                    c.afterSuccessfulUpload();

                    // Feedback will be closed via button click.
                }
            } else {
                setTimeout(function() {
                    c.afterSuccessfulUpload();

                    snax.hideFeedback();
                }, 750);
            }

            c.initQueue();
        }

        return finished;
    };

    c.afterSuccessfulUpload = function () {
        $(selectors.post).
            removeClass(classes.postWithoutMedia + ' ' + classes.postWithRemovedMedia).
            addClass(classes.postWithMedia);

        var $postTitle = $(selectors.post).find(selectors.postTitle);

        // If title has no "snax-focused" class yet,
        // we can be sure that the form is loaded for the first time.
        // So we can perform some initial actions.
        if (!$postTitle.is('.snax-focused')) {
            // Focus on title.
            $postTitle.addClass('snax-focused').focus();

            // Clear demo data.
            if (!fakeUpload) {
                ctx.form.emptyFields();
            }
        }
    };

    c.imageAdded = function() {};

    c.initQueue = function() {
        uploadStarted = false;
        filesAll = 0;
        filesAllList = [];
        fileStates = [];
        fileStateMessages = [];
        filesFailed = 0;

        // Reset uplaoder queue.
        if (typeof uploader !== 'undefined') {
            while (uploader.files.length > 0) {
                uploader.removeFile(uploader.files[0]);
            }
        }
    };

})(jQuery, snax.frontendSubmission);


/**************************
 *
 * Component: Upload Embeds
 *
 *************************/

(function ($, ctx) {

    'use strict';

    /** CONFIG *******************************************/

        // Register new component
    ctx.uploadEmbeds = {};

    // Component namespace shortcut
    var c = ctx.uploadEmbeds;

    // CSS selectors
    var selectors = {
        'post':                 '.snax-form-frontend',
        'postTitle':            '#snax-post-title',
        'parentFormat':         '.snax-form-frontend input[name=snax-post-format]',
        'form':                 '.snax-tab-content-embed',
        'embedUrlsField':       '.snax-embed-url-multi',
        'embedUrlField':        '.snax-embed-url',
        'removeEmbedUrlLink':   '.snax-remove-embed',
        'submitField':          'input[name=snax-add-embed-item]',
        'embed':                '.snax-card, .snax-embed',
        'embedsWrapper':        '.snax-cards',
        'embedDelete':          '.snax-embed-action-delete',
        'loadDemoEmbedButton':  '.snax-demo-format-embed > a',
        // Embeds processing.
        'embedProcessing':      '.snax-xofy-x',
        'embedsAll':            '.snax-xofy-y',
        'embedsProgressBar':    '.snax-progress-bar',
        'embedState':           '.snax-state',
        'embedsStates':         '.snax-states',
        'statesWrapper':        '.snax-details',
        'feedbackCloseButton':  '.snax-close-button'
    };

    // CSS classes
    var classes = {
        'embedUrlField':        'snax-embed-url',
        'removeEmbedUrlLink':   'snax-remove-embed',
        'fieldValidationError': 'snax-error',
        'formHidden':           'snax-tab-content-hidden',
        'formVisible':          'snax-tab-content-visible',
        'postWithoutMedia':     'snax-form-frontend-without-media',
        'postWithMedia':        'snax-form-frontend-with-media',
        'postWithRemovedMedia': 'snax-form-frontend-with-removed-media',
        // Embeds processing.
        'embedState':            'snax-state',
        'embedStateProcessing':  'snax-state-processing',
        'embedStateSuccess':     'snax-state-success',
        'embedStateError':       'snax-state-error',
        'embedProcessed':        'snax-details-expanded'
    };

    // i18n.
    var i18n = {
        'confirm':      ctx.config.i18n.are_you_sure
    };

    c.selectors = selectors;
    c.classes   = classes;
    c.i18n      = i18n;

    var $form,
        parentFormat,
        $embedsAll,
        $embedProcessing,
        $embedsProgressBar,
        $embedsStates,
        fakeUpload,
        embedsAll,
        embedProcessing,
        embedsUploaded,
        embedsFailed,
        embedErrors,
        embedStates;                    // States of processed files. Format: [ { name: 1.jpg, state: 1 }, ... ].
                                        // States: 1 (success),  -1 (error), file not in array (not processed yet).


    /** INIT *******************************************/

    c.init = function () {
        $form = $(selectors.form);

        if (!$form.length) {
            return;
        }

        parentFormat = $(selectors.parentFormat).val();

        if (parentFormat.length === 0) {
            snax.log('Snax Front Submission Error: Parent format not defined!');
            return;
        }

        if (snax.currentUserId === 0) {
            snax.log('Snax: Login required');
            return;
        }

        fakeUpload = false;

        c.attachEventHandlers();
    };

    /** EVENTS *****************************************/

    c.attachEventHandlers = function() {

        /* New url pasted */

        $(document).on('paste drop', selectors.embedUrlsField, function() {
            // Delay to make sure that we can read from the field.
            setTimeout(function () {
                $(selectors.submitField).trigger('click');
            }, 200);
        });

        /* New url typed */

        $(selectors.embedUrlsField).on('focusout', function() {
            if($(this).val().length > 0) {
                $(selectors.submitField).trigger('click');
            }
        });

        /* Submit url */

        $(selectors.submitField).on('click', function(e) {
            e.preventDefault();

            // Collect embed codes.
            var $urls = $form.find(selectors.embedUrlsField);

            var urls = [];
            urls.push($.trim($urls.val()));

            // Clear field.
            $urls.val('');

            // Validate if at least entered.
            if (urls.length === 0) {
                $(selectors.embedUrlsField).addClass(classes.fieldValidationError);
                return;
            } else {
                $(selectors.embedUrlsField).removeClass(classes.fieldValidationError);
            }

            fakeUpload = false;

            c.initFeedback(1);

            urls.reverse();

            c.addEmbedUrls(urls);
        });

        /** Delete ***************/

        $(selectors.embedsWrapper).on('click', selectors.embedDelete, function(e) {
            e.preventDefault();

            if (!confirm(i18n.confirm)) {
                return;
            }

            var $embed = $(this).parents(selectors.embed);

            c.deleteEmbed($embed);
        });

        /** Upload demo embed *******/

        $(selectors.loadDemoEmbedButton).on('click', function(e) {
            e.preventDefault();

            var urls = [
                $(this).attr('href')
            ];

            fakeUpload = true;

            // Fake uploading process.
            c.initFeedback(1);

            c.addEmbedUrls(urls);
        });

        /** Close feedback *******/

        $(selectors.feedbackCloseButton).on('click', function(e) {
            e.preventDefault();

            snax.hideFeedback();
        });
    };

    /** API *********************************************/

    c.addEmbedUrls = function(urls) {
        if (urls.length === 0) {
            c.uploadFinished();
            return;
        }

        var url = urls.pop();

        if ('text' === parentFormat) {
            c.addContentEmbed(url);

            c.embedProcessed(1);

            // Process next url.
            c.addEmbedUrls(urls);
        } else {
            var item = snax.EmbedItem({
                'embedCode':    url,
                'authorId':     snax.currentUserId,
                'status':       'publish',
                'parentFormat': parentFormat,
                'legal':        true
            });

            item.save(function(res) {
                if (res.status === 'success') {
                    switch(parentFormat) {
                        case 'embed':
                            c.addEmbed(res.args.item_id);
                            break;

                        default:
                            ctx.cards.addCard(res.args.item_id);
                    }

                    c.embedProcessed(1);
                } else {
                    c.embedProcessed(-1, res.message);
                }

                // Process next url.
                c.addEmbedUrls(urls);
            });
        }
    };

    c.embedProcessed = function(status, errorMsg) {
        embedStates[embedProcessing - 1] = status;

        if (status === -1) {
            embedsFailed++;
            embedErrors[embedProcessing - 1] = errorMsg;
        }

        // Update feedback.
        embedProcessing++;
        embedsUploaded++;

        c.updateFeedback();
    };

    c.addEmbed = function(itemId) {
        var xhr = $.ajax({
            'type': 'GET',
            'url': snax.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':          'snax_load_embed_item_tpl',
                'snax_item_id':    itemId
            }
        });

        xhr.done(function (res) {
            if (res.status === 'success') {
                var $embed = $(res.args.html);

                $(selectors.embedsWrapper).append($embed);

                $(selectors.form).removeClass(classes.formVisible);
                $(selectors.form).addClass(classes.formHidden);
            }
        });
    };

    c.addContentEmbed = function(url) {
        var xhr = $.ajax({
            'type': 'POST',
            'url': snax.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':           'snax_load_content_embed_tpl',
                'snax_embed_code':  url
            }
        });

        xhr.done(function (res) {
            if (res.status === 'success') {
                var $embed = $(res.args.html);

                $('body').trigger('snaxContentEmbedAdded',[$embed]);
            } else {
                alert(res.message);
            }
        });
    };

    c.deleteEmbed = function($embed) {
        var $link       = $embed.find(selectors.embedDelete);

        snax.deleteItem($link, function(res) {
            if (res.status === 'success') {
                $embed.trigger('snaxEmbedRemoved',[$embed]);

                $embed.remove();

                $(selectors.form).addClass(classes.formVisible);
                $(selectors.form).removeClass(classes.formHidden);
            }
        });
    };

    c.initFeedback = function(all) {
        // Init.
        embedProcessing = 1;
        embedsUploaded  = 0;
        embedsAll       = all;
        embedStates     = [];
        embedErrors     = [];
        embedsFailed    = 0;

        $embedProcessing    = $(selectors.embedProcessing);
        $embedsAll          = $(selectors.embedsAll);
        $embedsProgressBar  = $(selectors.embedsProgressBar);
        $embedsStates       = $(selectors.embedsStates);

        $embedProcessing.text(embedProcessing);
        $embedsAll.text(embedsAll);
        $embedsProgressBar.css('width', 0);

        // States.
        var i;
        $embedsStates.empty();

        for(i = 0; i < embedsAll; i++) {
            $embedsStates.append('<li class="'+ classes.embedState +'"></li>');
        }

        snax.displayFeedback('processing-files');
    };

    c.updateFeedback = function() {
        var currentIndex = embedsUploaded - 1;
        var currentState = typeof embedStates[currentIndex] !== 'undefined' ? embedStates[currentIndex] : 0;

        var $embedState = $(selectors.embedsStates).find(selectors.embedState).eq(currentIndex);

        $embedState.addClass(classes.embedStateProcessing);

        if (currentState !== 0) {
            $embedState.
                removeClass(classes.embedStateProcessing).
                addClass(currentState === 1 ? classes.embedStateSuccess : classes.embedStateError);

            if (currentState === -1) {
                var errorMessage = embedErrors[currentIndex];

                $embedState.text(errorMessage);
            }

            var progress = embedsUploaded / embedsAll * 100;

            $embedProcessing.text(embedsUploaded);
            $embedsProgressBar.css('width', progress + '%');
        }
    };

    c.uploadFinished = function() {
        var finished = embedsUploaded === embedsAll;

        if (finished) {
            if (embedsFailed > 0) {
                $(selectors.statesWrapper).addClass(classes.embedProcessed);
            } else {
                setTimeout(function() {
                    $(selectors.post).removeClass(classes.postWithoutMedia).addClass(classes.postWithMedia);

                    var $postTitle = $(selectors.post).find(selectors.postTitle);

                    // If title has no "snax-focused" class yet,
                    // we can be sure that the form is loaded for the first time.
                    // So we can perform some initial actions.
                    if (!$postTitle.is('.snax-focused')) {
                        // Focus on title.
                        $postTitle.addClass('snax-focused').focus();

                        // Clear demo data.
                        if (!fakeUpload) {
                            ctx.form.emptyFields();
                        }
                    }

                    snax.hideFeedback();
                }, 750);
            }
        }

        return finished;
    };

})(jQuery, snax.frontendSubmission);


/********************
 *
 * Component: Cards
 *
 *******************/

(function ($, ctx) {

    'use strict';

    /** CONFIG *******************************************/

    // Register new component
    ctx.cards = {};

    // Component namespace shortcut
    var c = ctx.cards;

    // CSS selectors
    var selectors = {
        'form':             'form.snax-form-frontend',
        'focusableFields':  'input,textarea',
        'card':             '.snax-card',
        'titleField':       'input[name=snax-title]',
        'sourceField':      'input[name=snax-source]',
        'descriptionField': '.snax-card-description > textarea',
        'focusedCard':      '.snax-card-focus',
        'blurredCard':      '.snax-card-blur',
        'cardUp':           '.snax-card-up',
        'cardDown':         '.snax-card-down',
        'cardDelete':       '.snax-card-action-delete',
        'cardPosition':     '.snax-card-position',
        'newEmbeds':        '.snax-new-embeds',
        'addEmbedsField':   'textarea.snax-add-embed-urls',
        'cardsWrapper':     '.snax-cards',
        'publishPostButton':'.snax-button-publish-post',
        'limitReachedNote': '.snax-limit-edit-post-items'
    };


    // CSS classes
    var classes = {
        'focusedCard':      'snax-card-focus',
        'blurredCard':      'snax-card-blur',
        'saving':           'snax-saving',
        'saveFailed':       'snax-save-failed',
        'noteOn':           'snax-note-on',
        'noteOff':          'snax-note-off'
    };

    // i18n.
    var i18n = {
        'confirm':      ctx.config.i18n.are_you_sure
    };

    c.selectors = selectors;
    c.classes   = classes;
    c.i18n      = i18n;

    var $form,
        cardsLimit,
        cardsCount;

    /** INIT *******************************************/

    c.init = function () {
        $form = $(selectors.form);

        if (!$form.length) {
            return;
        }

        cardsCount = parseInt($form.find(selectors.card).length, 10);
        cardsLimit = parseInt(ctx.config.items_limit, 10);

        c.checkLimits();

        c.attachEventHandlers();
        c.scheduleTasks();
    };

    /** EVENTS *****************************************/

    c.attachEventHandlers = function() {

        /** Focus *********************/

        $(selectors.cardsWrapper).on( 'focus', selectors.focusableFields, function() {
            var $card = $(this).parents(selectors.card);

            // Only if current card is not focused.
            if ( ! $card.is( selectors.focusedCard ) ) {
                // Blur all focused cards.
                $(selectors.focusedCard).toggleClass(classes.blurredCard + ' ' + classes.focusedCard);

                // Focus current.
                $card.toggleClass(classes.blurredCard + ' ' + classes.focusedCard);
            }
        } );

        /** Move up/down **************/

        $(selectors.cardsWrapper).on('click', selectors.cardUp, function(e) {
            e.preventDefault();

            var $card = $(this).parents(selectors.card);

            c.moveCard($card, -1);
        });

        $(selectors.cardsWrapper).on('click', selectors.cardDown, function(e) {
            e.preventDefault();

            var $card = $(this).parents(selectors.card);

            c.moveCard($card, 1);
        });

        /** Delete ***************/

        $(selectors.cardsWrapper).on('click', selectors.cardDelete, function(e) {
            e.preventDefault();

            if (!confirm(i18n.confirm)) {
                return;
            }

            var $card = $(this).parents(selectors.card);

            c.deleteCard($card);
        });

        /** Save post ************/

        var submitFormHandler = function() {
            var $button = $(selectors.publishPostButton);

            $button.addClass(classes.saving);

            c.updateCards(function (res) {
                $button.removeClass(classes.saving);

                if (res.status === 'success') {
                    $form.get(0).submit();
                } else {
                    $button.addClass(classes.saveFailed);
                }
            });
        };

        $form.on('submit', function(e) {
            e.preventDefault();

            submitFormHandler();
        });

        $form.find('input[name=snax-save-draft]').on('click', function(e) {
            e.preventDefault();

            // When form submission will proceed, form will be submitted programmatically and the  "Save Draft" submit input won't be attached to the request.
            // We need to simulate it.
            $form.find('input[type=hidden]#snax-submit-type').remove();
            $form.append('<input type="hidden" id="snax-submit-type" name="snax-save-draft" value="standard" />');

            // Here we update cards and then submit form again.
            submitFormHandler();
        });
    };

    /** SCHEDULED TASKS ********************************/

    c.scheduleTasks = function() {

        var updateIntervalInSec = parseInt(snax.config.autosave_interval, 10);

        if (updateIntervalInSec <= 0) {
            return;
        }

        setInterval(function () {

            /** Update cards ************/

            c.updateCards();

        }, updateIntervalInSec * 1000);

    };

    /** API *********************************************/

    c.moveCard = function($card, difference) {
        if (difference === 0) {
            return;
        }

        var $cardToSwitchWith = $(); // Empty jQuery object.

        if (difference < 0) {
            while(difference < 0) {
                $cardToSwitchWith = $card.prev(selectors.card);

                // Previous sibling exists so switch.
                if ($cardToSwitchWith.length > 0) {
                    $card.insertBefore($cardToSwitchWith);

                    c.updateCardNumber($card, -1);
                    c.updateCardNumber($cardToSwitchWith, 1);
                }

                difference++;
            }
        }

        if (difference > 0) {
            while(difference > 0) {
                $cardToSwitchWith = $card.next(selectors.card);

                // Next sibling exists so switch.
                if ($cardToSwitchWith.length > 0) {
                    $card.insertAfter($cardToSwitchWith);

                    c.updateCardNumber($card, 1);
                    c.updateCardNumber($cardToSwitchWith, -1);
                }

                difference--;
            }
        }
    };

    c.updateCardNumber = function($card, difference) {
        // Update all cards.
        if (typeof $card === 'undefined') {
            $(selectors.cardPosition).each(function(index) {
                $(this).text(index + 1);
            });

            return;
        }

        // Update single card.
        var $position = $card.find(selectors.cardPosition);
        var newValue = parseInt($position.text(), 10);

        // Using difference param.
        if (typeof difference !== 'undefined') {
            newValue += difference;
            // Using post index.
        } else {
            newValue = $(selectors.card).index($card) + 1;
        }

        $position.text(newValue);
    };

    c.addCard = function(itemId) {
        var xhr = $.ajax({
            'type': 'GET',
            'url': snax.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':          'snax_load_item_card_tpl',
                'snax_item_id':    itemId
            }
        });

        xhr.done(function (res) {
            if (res.status === 'success') {
                var $card = $(res.args.html);

                $(selectors.cardsWrapper).append($card);

                c.updateCardNumber($card);

                $card.trigger('snaxNewCardAdded',[$card]);

                c.bumpCardsCount(1);
            }
        });
    };

    c.deleteCard = function($card) {
        var $link       = $card.find(selectors.cardDelete);

        snax.deleteItem($link, function(res) {
            if (res.status === 'success') {
                $card.trigger('snaxCardRemoved',[$card]);

                $card.remove();

                c.updateCardNumber();

                c.bumpCardsCount(-1);
            }
        });
    };

    c.updateCards = function (callback) {
        callback = callback || function() {};

        var items = [];

        $(selectors.card).each(function () {
            var $card   = $(this);
            var id      = $card.attr('data-snax-id');
            var $title  = $card.find(selectors.titleField);
            var $source = $card.find(selectors.sourceField);
            var $desc   = $card.find(selectors.descriptionField);

            items.push({
                'id':           id,
                'title':        $.trim($title.val()),
                'source':       $.trim($source.val()),
                'description':  $.trim($desc.val())
            });
        });

        // Nothing to save.
        if (items.length === 0) {
            return callback({ status: 'success' });
        }

        snax.updateItems(items, callback);
    };

    c.bumpCardsCount = function(diff) {
        cardsCount += diff;

        c.checkLimits();
    };

    c.checkLimits = function() {
        if ( cardsLimit !== -1 && cardsCount >= cardsLimit ) {
            $form.find(selectors.limitReachedNote).removeClass('snax-note-off').addClass('snax-note-on');
        } else {
            $form.find(selectors.limitReachedNote).removeClass('snax-note-on').addClass('snax-note-off');
        }
    };

})(jQuery, snax.frontendSubmission);


/****************************
 *
 * Component: Meme Generator
 *
 ***************************/

(function ($, ctx) {

    'use strict';

    // Register new component
    ctx.memeGenerator = {};

    // Component namespace shortcut
    var c = ctx.memeGenerator;

    /** CONFIG *******************************************/

    // CSS selectors
    var selectors = {
        'image':    'form.snax-meme .snax-image img'
    };

    // CSS classes
    var classes = {};

    // i18n.
    var i18n = {
        'topText':      ctx.config.i18n.meme_top_text,
        'bottomText':   ctx.config.i18n.meme_bottom_text
    };

    // Config.
    var config = {
        'topText':      i18n.topText,
        'bottomText':   i18n.bottomText,
        'text':  {
            'offsetX':      30,
            'offsetY':      30,
            'fontSize':     32,
            'strokeRatio':  8 / 140
        },
        'bg': {
            'offsetX':  10,
            'offsetY':  10,
            'height':   70
        },
        'handle': {
            'width':    30,
            'height':   30,
            'offsetY':  65
        }
    };

    // Canvas objects.
    var canvas;
    var image;
    var top;
    var bottom;

    // Vars.
    var canvasWidth;
    var canvasHeight;
    var $image;

    c.selectors = selectors;
    c.classes   = classes;
    c.config    = config;

    /** INIT *******************************************/

    c.init = function () {
        if (typeof fabric === 'undefined') {
            snax.log('Fabric.js library is not loaded!');
            return;
        }

        $image = $(selectors.image);

        if ($image.length === 0) {
            snax.log('Canva image not exists!');
            return;
        }

        // @todo - MEME refactor
        $('.snax-edit-post-row-media canvas, .snax-edit-post-row-media .canvas-container').remove();

        var $canvas = $('<canvas id="snax-meme-canvas"></canvas>');

        $canvas.insertBefore($image);

        canvasWidth  = $image.prop('width');
        canvasHeight = $image.prop('height');

        $image.hide();

        $canvas.attr({
            width:  canvasWidth,
            height: canvasHeight
        });

        canvas = new fabric.Canvas($canvas.get(0));

        fabric.Image.fromURL($image.attr('src'), function(img) {
            img.set({
                width:              canvasWidth,
                height:             canvasHeight,
                lockMovementX:      true,
                lockMovementY:      true,
                lockRotation:       true,
                lockScalingX:       true,
                lockScalingY:       true,
                hasControls:        false,
                hasRotatingPoint:   false,
                hoverCursor:        'default',
                evented:            false
            });

            image = img;

            var iconUrl = ctx.config.assets_url + 'images/resize-handle.svg';

            fabric.loadSVGFromURL(iconUrl, function(objects, opts) {
                var obj = fabric.util.groupSVGElements(objects, opts);

                c.loaded(obj);
            });
        });
    };

    c.loaded = function(handleIcon) {
        top = {
            'text':     c.createText(config.topText, { 'top': config.text.offsetY, 'strokeWidth': 0 }),
            'stroke':   c.createText(config.topText, { 'top': config.text.offsetY, 'stroke': '#000000', 'fill': '#000000' }),
            'bg':       c.createBg({ 'top': config.bg.offsetY }),
            'handle':   c.createHandle(fabric.util.object.clone(handleIcon), { 'top': config.handle.offsetY }),
            'state':    {}
        };

        var bottomTextTop = canvasHeight - config.bg.offsetY - config.bg.height + 20;

        bottom = {
            'text':     c.createText(config.bottomText, { top: bottomTextTop, 'strokeWidth': 0 }),
            'stroke':   c.createText(config.bottomText, { top: bottomTextTop, 'stroke': '#000000', 'fill': '#000000' }),
            'bg':       c.createBg({ top: canvasHeight - config.bg.offsetY - config.bg.height }),
            'handle':   c.createHandle(fabric.util.object.clone(handleIcon), { top: canvasHeight - config.bg.offsetY - config.bg.height - config.handle.height / 2 }),
            'state':    {}
        };

        // Layers.
        // -------

        // Main image.
        canvas.add(image);
        canvas.moveTo(image, 1);

        // Top.
        canvas.add(top.bg);
        canvas.moveTo(top.bg, 5);

        canvas.add(top.handle);
        canvas.moveTo(top.handle, 7);

        canvas.add(top.stroke);
        canvas.moveTo(top.stroke, 9);

        canvas.add(top.text);
        canvas.moveTo(top.text, 10);

        // Bottom.
        canvas.add(bottom.bg);
        canvas.moveTo(bottom.bg, 15);

        canvas.add(bottom.handle);
        canvas.moveTo(bottom.handle, 17);

        canvas.add(bottom.stroke);
        canvas.moveTo(bottom.stroke, 19);

        canvas.add(bottom.text);
        canvas.moveTo(bottom.text, 20);

        // Focus on top text.
        canvas.setActiveObject(bottom.handle);

        // Events.
        c.handleTopTextEvents();
        c.handleBottomTextEvents();
    };

    c.createText = function(textValue, options) {
        options = options || {};

        var cfg = config.text;

        options = $.extend({
            cursorColor:    '#ffffff',
            cursorWidth:    2,
            fontFamily:     'Impact',
            fontSize:       cfg.fontSize,
            lineHeight:     1,
            left:           cfg.offsetX,
            width:          canvasWidth - 2 * cfg.offsetX,
            padding:        0,
            stroke:         '#000000',
            strokeWidth:    cfg.strokeRatio * cfg.fontSize,
            strokeLineCap:  'round',
            strokeLineJoin:  'round',
            fill:           '#ffffff',
            textAlign:      'center',
            lockMovementX:  true,
            lockMovementY:  true,
            hoverCursor:    'text',
            lockScalingX:   true,
            lockScalingY:   true,
            lockRotation:   true,
            hasBorders:     false,
            _fontSizeMult:  1
        }, options);

        var text = new fabric.Textbox(textValue.toUpperCase(), options);

        text.setControlVisible('ml', false);
        text.setControlVisible('mr', false);

        return text;
    };

    c.createBg = function(options) {
        options = options || {};

        options = $.extend({
            left:               config.bg.offsetX,
            width:              canvasWidth - 2 * config.bg.offsetX,
            height:             config.bg.height,
            fill:               'rgba(0,0,0, 0.33)',
            stroke:             '#ffffff',
            strokeWidth:        1,
            strokeDashArray:    [1, 4],
            lockMovementX:      true,
            lockMovementY:      true,
            lockScalingX:       false,
            lockScalingY:       false,
            excludeFromExport:  true
        }, options);

        return new fabric.Rect(options);
    };

    c.createHandle = function(svgIcon, options) {
        options = options || {};

        var cfg = config.handle;

        options = $.extend({
            left:               canvasWidth / 2 - cfg.width / 2,
            width:              cfg.width,
            height:             cfg.height,
            lockMovementX:      true,
            lockScalingX:       false,
            lockScalingY:       false,
            hasBorders:         false,
            hasControls:        false,
            excludeFromExport:  true
        }, options);

        svgIcon.set(options);

        return svgIcon;
    };

    /** EVENTS *****************************************/

    c.handleTopTextEvents = function() {
        var text        = top.text;
        var stroke      = top.stroke;
        var bg          = top.bg;
        var handle      = top.handle;

        // Init state.
        top.state = {
            text:           text.getText(),
            lines:          text._splitTextIntoLines().length,
            fontSize:       text.getFontSize(),
            handleMinY:     config.handle.offsetY,
            handleMaxY:     canvasHeight / 2 - config.handle.height
        };

        var state = top.state;

        text.on('changed', function() {
            // Keep upper-case letters.
            text.setText(text.getText().toUpperCase());
            stroke.setText(text.getText().toUpperCase());

            // Prevent entering new text if its width exceeds the range.
            var maxTextWidth = top.bg.getWidth() - 40;

            if (text.getWidth() > maxTextWidth) {
                // Text.
                text.setText(state.text);
                text.setWidth(maxTextWidth);

                // Stroke.
                stroke.setText(state.text);
                stroke.setWidth(maxTextWidth);
            } else {
                state.text = text.getText();
            }

            // Update font size if height exceeds the range.
            var newLines = text._splitTextIntoLines().length;

            if (newLines !== state.lines) {
                state.lines = newLines;
                state.fontSize = config.text.fontSize / newLines;

                c.changeTextSize(top);
            }
        });

        handle.on('moving', function() {
            var handleY     = handle.getTop();
            var bgHeight    = config.bg.height + handleY - state.handleMinY;

            // Min Y boundary.
            if (handleY <= state.handleMinY) {
                handleY     = state.handleMinY;
                bgHeight    = config.bg.height;
            }

            // Max Y boundary.
            if (handleY >= state.handleMaxY) {
                handleY     = state.handleMaxY;
                bgHeight    = state.handleMaxY - config.bg.offsetY + config.handle.height / 2;
            }

            // Update handle and bg positions.
            handle.setTop(handleY);
            bg.setHeight(bgHeight);

            c.changeTextSize(top);
        });
    };

    c.changeTextSize = function(obj) {
        var text    = obj.text;
        var stroke  = obj.stroke;
        var state   = obj.state;
        var diff    = obj.handle.getTop() - obj.state.handleMinY;

        var lines       = text._splitTextIntoLines().length;
        var fontSize    = text.getFontSize();

        var newFontSize = state.fontSize + diff / lines;

        text.setFontSize(newFontSize);
        stroke.setFontSize(newFontSize);

        // Does the text breaks into new line?
        if (text._splitTextIntoLines().length > lines) {
            // Main text. Reset to last valid state.
            text.setFontSize(fontSize);
            text.setWidth(canvasWidth - 2 * config.text.offsetX);

            // Stroke.
            stroke.setFontSize(fontSize);
            stroke.setWidth(canvasWidth - 2 * config.text.offsetX);
        }

        stroke.setStrokeWidth(text.getFontSize() * config.text.strokeRatio);
    };

    c.changeBottomTextSize = function(obj) {
        var text    = obj.text;
        var stroke  = obj.stroke;
        var state   = obj.state;
        var diff    = obj.state.handleMaxY - obj.handle.getTop();

        var lines       = text._splitTextIntoLines().length;
        var fontSize    = text.getFontSize();

        var newFontSize = state.fontSize + diff / lines;

        text.setFontSize(newFontSize);
        stroke.setFontSize(newFontSize);

        // Does the text breaks into new line?
        if (text._splitTextIntoLines().length > lines) {
            // Main text. Reset to last valid state.
            text.setFontSize(fontSize);
            text.setWidth(canvasWidth - 2 * config.text.offsetX);

            // Stroke.
            stroke.setFontSize(fontSize);
            stroke.setWidth(canvasWidth - 2 * config.text.offsetX);

        }

        var textOffsetTop = canvasHeight - config.text.offsetY - text.getHeight();

        text.top = textOffsetTop;
        stroke.top = textOffsetTop;

        stroke.setStrokeWidth(text.getFontSize() * config.text.strokeRatio);
    };

    c.handleBottomTextEvents = function() {
        var text        = bottom.text;
        var stroke      = bottom.stroke;
        var bg          = bottom.bg;
        var handle      = bottom.handle;

        // Init state.
        bottom.state = {
            text:           text.getText(),
            lines:          text._splitTextIntoLines().length,
            fontSize:       text.getFontSize(),
            handleMinY:     canvasHeight / 2,
            handleMaxY:     canvasHeight - config.bg.offsetY - config.bg.height - config.handle.height / 2
        };

        var state = bottom.state;

        text.on('changed', function() {
            // Keep upper-case letters.
            text.setText(text.getText().toUpperCase());
            stroke.setText(text.getText().toUpperCase());

            // Prevent entering new text if its width exceeds the range.
            var maxTextWidth = bottom.bg.getWidth() - 40;

            if (text.getWidth() > maxTextWidth) {
                // Main text.
                text.setText(state.text);
                text.setWidth(maxTextWidth);

                // Stroke.
                stroke.setText(state.text);
                stroke.setWidth(maxTextWidth);
            } else {
                state.text = text.getText();
            }

            // Update font size if height exceeds the range.
            var newLines = text._splitTextIntoLines().length;

            if (newLines !== state.lines) {
                state.lines = newLines;
                state.fontSize = config.text.fontSize / newLines;

                c.changeBottomTextSize(bottom);
            }
        });

        handle.on('moving', function() {
            var handleY     = handle.getTop();
            var bgHeight    = config.bg.height + state.handleMaxY - handle.getTop();

            // Min Y boundary.
            if (handleY <= state.handleMinY) {
                handleY     = state.handleMinY;
                bgHeight    = canvasHeight / 2 - config.bg.offsetY - config.handle.height / 2;
            }

            // Max Y boundary.
            if (handleY >= state.handleMaxY) {
                handleY     = state.handleMaxY;
                bgHeight    = config.bg.height;
            }

            // Update handle and bg positions.
            handle.setTop(handleY);
            bg.setTop(handleY + config.handle.height / 2);
            bg.setHeight(bgHeight);

            c.changeBottomTextSize(bottom);
        });
    };

    c.getImageBase64 = function() {
        if (!canvas) {
            return false;
        }

        var imageOrigWidth  = parseInt($image.attr('width'), 10);
        var imageCurrWidth  = canvasWidth;

        var scaleMultiplier = imageOrigWidth / imageCurrWidth;

        c.excludeFromExport(true);

        // Scale to origianl image size.
        c.scaleCanvas(scaleMultiplier);

        var data = canvas.toDataURL('image/jpeg');

        // Restore for further processing, if necessary.
        c.excludeFromExport(false);
        c.scaleCanvas(1 / scaleMultiplier);

        return data;
    };

    c.scaleCanvas = function(multiplier) {
        var objects = canvas.getObjects();

        for (var i in objects) {
            objects[i].scaleX = objects[i].scaleX * multiplier;
            objects[i].scaleY = objects[i].scaleY * multiplier;
            objects[i].left = objects[i].left * multiplier;
            objects[i].top = objects[i].top * multiplier;
            objects[i].setCoords();
        }

        canvas.setWidth(canvas.getWidth() * multiplier);
        canvas.setHeight(canvas.getHeight() * multiplier);
        canvas.renderAll();
        canvas.calcOffset();
    };

    c.excludeFromExport = function(bool) {
        var visible = !bool;

        top.bg.visible = visible;
        top.handle.visible = visible;

        bottom.bg.visible = visible;
        bottom.handle.visible = visible;
    };

})(jQuery, snax.frontendSubmission);

/****************************
 *
 * Component: Quiz
 *
 ***************************/

(function ($, ctx) {

    'use strict';

    // Register new component
    ctx.quiz = {};

    // Component namespace shortcut
    var c = ctx.quiz;

    /** INIT *******************************************/

    c.init = function () {
        if (typeof snax_quizzes === 'undefined') {
            return;
        }

        // Override backend UI.
        snax_quizzes.openMediaLibrary = useFrontendImageUploader;
        snax_quizzes.mediaDeleted = removeMediaFromLibrary;
    };

    var useFrontendImageUploader = function(callbacks) {
        ctx.uploadImages.fileUploadedCallback = function(mediaId) {
            var imageObject = { id: mediaId };

            callbacks.onSelect(imageObject);

            // Reset.
            ctx.uploadImages.fileUploadedCallback = null;
        };

        $('#plupload-browse-button').trigger('click');
    };

    var removeMediaFromLibrary = function(mediaId) {
        snax.deleteMedia({
            'mediaId':  mediaId,
            'authorId': snax.currentUserId
        });
    };

})(jQuery, snax.frontendSubmission);
