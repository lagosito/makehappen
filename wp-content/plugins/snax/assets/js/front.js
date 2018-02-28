/* global document */
/* global jQuery */
/* global snax */
/* global alert */
/* global confirm */
/* global console */

// globa namespace
if ( typeof window.snax === 'undefined' ) {
    window.snax = {};
}

/********
 *
 * Core
 *
 *******/

(function ($, ctx) {

    'use strict';

    /** VARS *************************/

    ctx.config = $.parseJSON(window.snax_front_config);

    if (!ctx.config) {
        throw 'Snax Error: Global config is not defined!';
    }

    /** FUNCTIONS ********************/

    ctx.log = function(msg) {
        if (typeof console !== 'undefined') {
            console.log(msg);
        }
    };

    ctx.inDebugMode = function() {
        return (typeof ctx.config.debug_mode !== 'undefined' && ctx.config.debug_mode);
    };

    ctx.isTouchDevice = function () {
        return ('ontouchstart' in window) || navigator.msMaxTouchPoints;
    };

    ctx.createCookie =  function (name, value, days) {
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        else {
            expires = '';
        }

        document.cookie = name.concat('=', value, expires, '; path=/');
    };

    ctx.readCookie = function (name) {
        var nameEQ = name + '=';
        var ca = document.cookie.split(';');

        for(var i = 0; i < ca.length; i += 1) {
            var c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1,c.length);
            }

            if (c.indexOf(nameEQ) === 0) {
                return c.substring(nameEQ.length,c.length);
            }
        }

        return null;
    };

    ctx.deleteCookie = function (name) {
        ctx.createCookie(name, '', -1);
    };

})(jQuery, snax);


/***********
 *
 * Helpers
 *
 ***********/

(function ($, ctx) {

    /* Image Item Class */

    ctx.ImageItem = function (data) {
        // Public scope.
        var instance = {};

        // Constructor.
        function init() {
            data = data || {};

            data = $.extend({
                'type':         'image',
                'title':        '',
                'source':       '',
                'description':  '',
                'mediaId':      '',
                'postId':       0,
                'authorId':     '',
                'status':       '',
                'parentFormat': 'list',
                'origin':       'post',
                'legal':        false
            }, data);

            return instance;
        }

        instance.save = function(callback) {
            callback = callback || function() {};

            var xhr = $.ajax({
                'type': 'POST',
                'url': ctx.config.ajax_url,
                'dataType': 'json',
                'data': {
                    'action':               'snax_add_image_item',
                    'security':             $('input[name=snax-add-image-item-nonce]').val(),
                    'snax_title':           data.title,
                    'snax_source':          data.source,
                    'snax_description':     data.description,
                    'snax_media_id':        data.mediaId,
                    'snax_post_id':         data.postId,
                    'snax_author_id':       data.authorId,
                    'snax_status':          data.status,
                    'snax_parent_format':   data.parentFormat,
                    'snax_origin':          data.origin,
                    'snax_legal':           data.legal ? 'accepted' : ''
                }
            });

            xhr.done(function (res) {
                 callback(res);
            });
        };

        return init();
    };

    /* Embed Item Class */

    ctx.EmbedItem = function (data) {
        // Public scope.
        var instance = {};

        // Constructor.
        function init() {
            data = data || {};

            data = $.extend({
                'type':         'embed',
                'title':        '',
                'description':  '',
                'embedCode':    '',
                'postId':       0,
                'authorId':     '',
                'status':       '',
                'parentFormat': 'list',
                'origin':       'post',
                'legal':        false
            }, data);

            return instance;
        }

        instance.save = function(callback) {
            callback = callback || function() {};

            var xhr = $.ajax({
                'type': 'POST',
                'url': ctx.config.ajax_url,
                'dataType': 'json',
                'data': {
                    'action':               'snax_add_embed_item',
                    'security':             $('input[name=snax-add-embed-item-nonce]').val(),
                    'snax_title':           data.title,
                    'snax_embed_code':      data.embedCode,
                    'snax_description':     data.description,
                    'snax_post_id':         data.postId,
                    'snax_author_id':       data.authorId,
                    'snax_status':          data.status,
                    'snax_parent_format':   data.parentFormat,
                    'snax_origin':          data.origin,
                    'snax_legal':           data.legal ? 'accepted' : ''
                }
            });

            xhr.done(function (res) {
                callback(res);
            });
        };

        return init();
    };


    ctx.deleteItem = function($link, callback) {
        callback = callback || function() {};

        var nonce       = $.trim($link.attr('data-snax-nonce'));
        var itemId      = parseInt($link.attr('data-snax-item-id'), 10);
        var userId      = snax.currentUserId;

        var xhr = $.ajax({
            'type': 'POST',
            'url': ctx.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':               'snax_delete_item',
                'security':             nonce,
                'snax_item_id':         itemId,
                'snax_user_id':         userId
            }
        });

        xhr.done(function (res) {
            callback(res);
        });
    };

    ctx.setItemAsFeatured = function($link, callback) {
        callback = callback || function() {};

        var nonce       = $.trim($link.attr('data-snax-nonce'));
        var itemId      = parseInt($link.attr('data-snax-item-id'), 10);
        var userId      = snax.currentUserId;

        var xhr = $.ajax({
            'type': 'POST',
            'url': ctx.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':               'snax_set_item_as_featured',
                'security':             nonce,
                'snax_item_id':         itemId,
                'snax_user_id':         userId
            }
        });

        xhr.done(function (res) {
            callback(res);
        });
    };

    ctx.updateItems = function(items, callback) {
        callback = callback || function() {};

        var xhr = $.ajax({
            'type': 'POST',
            'url': ctx.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':           'snax_update_items',
                'security':         $('input[name=snax-frontend-submission-nonce]').val(),
                'snax_items':       items
            }
        });

        xhr.done(function (res) {
            callback(res);
        });
    };

    ctx.loginRequired = function(blocked) {
        $('body').trigger('snaxLoginRequired', [blocked]);
    };

    ctx.getMediaHtmlTag = function(data, callback) {
        var xhr = $.ajax({
            'type': 'GET',
            'url': ctx.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':           'snax_load_media_tpl',
                'snax_media_id':    data.mediaId,
                'snax_post_id':     data.postId
            }
        });

        xhr.done(function (res) {
            callback(res);
        });
    };

    ctx.deleteMedia = function(data, callback) {
        callback = callback || function() {};

        var xhr = $.ajax({
            'type': 'POST',
            'url': ctx.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':           'snax_delete_media',
                'security':         $('input[name=snax-delete-media-nonce]').val(),
                'snax_media_id':    data.mediaId,
                'snax_author_id':   data.authorId
            }
        });

        xhr.done(function (res) {
            callback(res);
        });
    };

    ctx.updateMediaMetadata = function(data, callback) {
        callback = callback || function() {};

        var xhr = $.ajax({
            'type': 'POST',
            'url': ctx.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':               'snax_update_media_meta',
                // @todo - use separate nonce or use generic one.
                'security':             $('input[name=snax-delete-media-nonce]').val(),
                'snax_media_id':        data.mediaId,
                'snax_parent_format':   data.parentFormat
            }
        });

        xhr.done(function (res) {
            callback(res);
        });
    };

    ctx.getEmbedPreview = function(embed_code, callback) {
        var xhr = $.ajax({
            'type': 'POST',
            'url': ctx.config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':           'snax_load_embed_tpl',
                'snax_embed_code':  embed_code
            }
        });

        xhr.done(function (res) {
            callback(res);
        });
    };

    ctx.displayFeedback = function(type) {
        var feedbackTypeClass = 'snax-feedback-' + type;

        // Try to get type specific feedback first.
        var $feedback = $('.' + feedbackTypeClass);

        if ($feedback.length === 0) {
            return;
        }

        ctx.hideFeedback();

        // Activate.
        $feedback.toggleClass('snax-feedback-off snax-feedback-on');

        // Show.
        $('body').addClass('snax-show-feedback');
    };

    ctx.hideFeedback = function() {
        // Deactivate all.
        $('.snax-feedback-on').toggleClass('snax-feedback-on snax-feedback-off');

        // Hide all.
        $('body').removeClass('snax-show-feedback');
    };

})(jQuery, snax);


/*************************
 *
 * Module: Date > Time ago
 *
 *************************/

(function ($, ctx) {

    'use strict';

    var selectors = {
        'wrapper':      '.snax-time-left',
        'dateWrapper':  '> .snax-date-wrapper',
        'date':         '> .snax-date',
        'timeWrapper':  '> .snax-time-wrapper',
        'time':         '> .snax-time'
    };

    ctx.timeagoSelectors = selectors;

    ctx.dateConstans = {
        'day_ms':   1000 * 60 * 60 * 24,
        'month_ms': 1000 * 60 * 60 * 24 * 30,
        'year_ms':  1000 * 60 * 60 * 24 * 356
    };

    ctx.dateToTimeago = function () {
        if (!$.fn.timeago) {
            return;
        }

        // store current settings, thanks to $.extend we have a copy without reference to original object
        var origSettings = $.extend(true, {} , $.timeago.settings);

        // override
        $.extend($.timeago.settings, {
            cutoff: ctx.dateConstans.year_ms,
            allowFuture: true
        });

        $.extend($.timeago.settings.strings, {
            suffixFromNow: ''
        });

        // apply
        $(selectors.wrapper).each(function () {
            var $wrapper        = $(this);
            var $dateWrapper    = $wrapper.find(selectors.dateWrapper);
            var $date           = $dateWrapper.find(selectors.date);
            var $timeWrapper    = $wrapper.find(selectors.timeWrapper);
            var $time           = $timeWrapper.find(selectors.time);

            var timeLeftText = $.timeago($date.text());

            $time.text(timeLeftText);

            $dateWrapper.removeClass( '.snax-date-wrapper-unfriendly' );
            $timeWrapper.addClass( 'snax-time-wrapper-friendly' );
        });

        // restore
        $.timeago.settings = origSettings;
    };

    // fire
    $(document).ready(function () {
        ctx.dateToTimeago();
    });

})(jQuery, snax);


/**************************
 *
 * Module: Upvote/Downvote
 *
 *************************/

(function ($, ctx) {

    'use strict';

    var locked = false;

    var selectors = {
        'wrapper':      '.snax-voting',
        'upvoteLink':   '.snax-voting-upvote',
        'downvoteLink': '.snax-voting-downvote',
        'guestVoting':  '.snax-guest-voting',
        'voted':        '.snax-user-voted'
    };

    var classes = {
        'voted':        'snax-user-voted'
    };

    ctx.votesSelectors  = selectors;
    ctx.votesClasses    = classes;

    ctx.votes = function () {
        // Catch event on wrapper to keep it working after box content reloading
        $('body').on('click', selectors.upvoteLink + ', ' + selectors.downvoteLink, function (e) {
            e.preventDefault();

            if (locked) {
                return;
            }

            locked = true;

            var $link       = $(e.target);
            var voteType    = $link.is(selectors.upvoteLink) ? 'upvote' : 'downvote';
            var $wrapper    = $link.parents(selectors.wrapper);
            var nonce       = $.trim($link.attr('data-snax-nonce'));
            var itemId      = parseInt($link.attr('data-snax-item-id'), 10);
            var authorId    = parseInt($link.attr('data-snax-author-id'), 10);

            ctx.vote({
                'itemId':   itemId,
                'authorId': authorId,
                'type':     voteType
            }, nonce, $wrapper);
        });

        // Remove all guest votes if there are not related cookies.
        $(selectors.voted + selectors.guestVoting).each(function () {
            var $link  = $(this);
            var itemId = parseInt($link.attr('data-snax-item-id'), 10);
            var type   = $link.is(selectors.upvoteLink) ? 'upvote' : 'downvote';
            var itemVoteType = ctx.readCookie('snax_vote_item_' + itemId);

            if (type !== itemVoteType) {
                $(this).removeClass(classes.voted);
            }
        });
    };

    ctx.vote = function (data, nonce, $box) {
        var config = $.parseJSON(window.snax_front_config);

        if (!config) {
            ctx.log('Item voting failed. Global config is not defined!');
            return;
        }

        /*
         * Apply new voting box state before ajax response.
         */
        var $userVoted      = $box.find('.snax-user-voted');
        var userUpvoted     = $userVoted.length > 0 && $userVoted.is('.snax-voting-upvote');
        var userDownvoted   = $userVoted.length > 0 && $userVoted.is('.snax-voting-downvote');
        var $score          = $box.find('.snax-voting-score > strong');
        var score           = parseInt($score.text(), 10);
        var diff            = 'upvote' === data.type ? 1 : -1;

        // User reverted his vote.
        if (userUpvoted && 'upvote' === data.type || userDownvoted && 'downvote' === data.type) {
            diff *= -1;

            $box.find('.snax-user-voted').removeClass('snax-user-voted');

        // User voted opposite.
        } else if (userUpvoted && 'downvote' === data.type || userDownvoted && 'upvote' === data.type) {
            diff *= 2;

            $box.find('.snax-user-voted').removeClass('snax-user-voted');
            $box.find('.snax-voting-' + data.type).addClass('snax-user-voted');

        // User added new vote.
        } else {
            $box.find('.snax-voting-' + data.type).addClass('snax-user-voted');
        }

        // Update score.
        $score.text(score + diff);

        // Send ajax.
        var xhr = $.ajax({
            'type': 'POST',
            'url': config.ajax_url,
            'dataType': 'json',
            'data': {
                'action':           'snax_vote_item',
                'security':         nonce,
                'snax_item_id':     data.itemId,
                'snax_author_id':   data.authorId,
                'snax_vote_type':   data.type,
                'snax_user_voted':  ctx.readCookie( 'snax_vote_item_' + data.itemId )
            }
        });

        xhr.done(function (res) {
            if (res.status === 'success') {
                // Replace just box content to keep assigned to it events
                $box.html($(res.args.html).html());

                ctx.updateVoteState(data.itemId, data.type, $box);
            }

            locked = false;
        });
    };

    ctx.updateVoteState = function(itemId, type, $box) {
        var cookieName = 'snax_vote_item_' + itemId;

        var currentValue = ctx.readCookie(cookieName);

        // Cookie can't be read immediately so we need to update CSS classes manually.
        $box.find(selectors.voted).removeClass(classes.voted);

        // User voted and now he wants to remove the vote.
        if (currentValue === type) {
            ctx.deleteCookie(cookieName);
        } else {
            ctx.createCookie(cookieName, type, 30);

            // Cookie can't be read immediately so we need to update CSS classes manually.
            $box.find('.snax-voting-' + type).addClass(classes.voted);
        }
    };

    // fire
    $(document).ready(function () {
        ctx.votes();
    });

})(jQuery, snax);


/****************
 *
 * Module: Popup
 *
 ****************/

(function ($, ctx) {

    'use strict';

    var selectors = {
        'popupContent':     '#snax-popup-content',
        'loginRequired':    '.snax-login-required',
        'usernameField':    '#user_login'
    };

    ctx.popupSelectors = selectors;

    ctx.popup = function () {
        if (!$.fn.magnificPopup) {
            return;
        }

        $(selectors.loginRequired).click(function (e) {
            e.preventDefault();

            var $content = $(selectors.popupContent);

            ctx.openPopup($content);

            // Delay till popup opens.
            setTimeout(function() {
                $content.find(selectors.usernameField).focus();
            }, 100);
        });

        $('body').on('snaxLoginRequired', function(e, blocked) {
            blocked = blocked || false;

            var $content = $(selectors.popupContent);

            ctx.openPopup($content, {
                'closeOnBgClick': blocked
            });

            // Delay till popup opens.
            setTimeout(function() {
                $content.find(selectors.usernameField).focus();
            }, 100);

            // Prevent default close action to not show page under the overlay when redirecting.
            if (blocked) {
                $.magnificPopup.instance.close = function() {
                    window.location.href = window.location.origin;
                };
            }
        });
    };

    ctx.openPopup = function ($content, args) {
        args = args || {};

        args.items = {
            src: $content,
            type: 'inline'
        };

        $.magnificPopup.open(args);
    };

    // fire
    $(document).ready(function () {
        ctx.popup();
    });

})(jQuery, snax);


/*********************
 *
 * Module: Login form
 *
 ********************/

(function ($, ctx) {

    'use strict';

    var selectors = {
        'formWrapper':          '.snax-login-form',
        'form':                 '.snax-login-form #loginform',
        'errorMessage':         '.snax-login-form .snax-login-error-message',
        'user': {
            'loginInput':       '#user_login',
            'emailInput':       '#user_email',
            'passwordInput':    '#user_pass'
        },
        'forgotPasswordLink':   '#snax-popup-content .snax-link-forgot-pass',
        'passwordWrapper':      '#snax-popup-content .login-password',
        'connectWithLabel':     '#snax-popup-content .wp-social-login-connect-with'
    };

    ctx.loginFormSelectors = selectors;

    ctx.loginForm = function () {
        // Add input placeholders.
        $.each(selectors.user, function (id, selector) {
            var $input = $(selector);
            var $label = $input.prev('label');

            if ($label.length > 0) {
                $input.attr('placeholder', $label.text());
            }
        });

        // Move forgot link after password field.
        $(selectors.passwordWrapper + ' input').after( $(selectors.forgotPasswordLink) );

        // Wrap label with <h4> tag.
        $(selectors.connectWithLabel).wrapInner( '<h4>' );

        handleSubmitAction();
    };

    var handleSubmitAction = function() {
        $(selectors.form).on('submit', function(e) {
            e.preventDefault();

            var $form = $(this);
            var $errorMessage = $(selectors.errorMessage);
            var nonce = $form.parents(selectors.formWrapper).attr('data-snax-nonce');

            var requestData = {
                'action':   'snax_login',
                'security': nonce
            };

            $.each($form.serializeArray(), function(i, field) {
                requestData[field.name] = field.value;
            });

            // Clear error message.
            $errorMessage.text('');

            var xhr = $.ajax({
                'type':     'POST',
                'url':      ctx.config.ajax_url,
                'dataType': 'json',
                'data':     requestData
            });

            xhr.done(function (res) {
                if ('success' === res.status) {
                    var redirectTo = res.args.redirect_url;

                    if (redirectTo) {
                        window.location.href = redirectTo;
                    } else {
                        window.location.reload();
                    }
                } else {
                    if (res.message) {
                        $errorMessage.html( '<p class="snax-validation-tip">' + res.message + '</p>');
                    }
                }
            });
        });
    };

    // Fire.
    $(document).ready(function () {
        ctx.loginForm();
    });

})(jQuery, snax);


/*************************
 *
 * Module: Actions Menu
 *
 ************************/

(function ($, ctx) {

    'use strict';

    var selectors = {
        'actions' :         '.snax-actions',
        'actionsToggle':    '.snax-actions-toggle',
        'actionsExpanded':  '.snax-actions-expanded'
    };

    var classes = {
        'expanded': 'snax-actions-expanded'
    };

    ctx.actionsMenuSelectors = selectors;
    ctx.actionsMenuClasses = classes;

    ctx.actionsMenu = function () {
        var $body = $('body');

        $('body').on('click', selectors.actionsToggle, function(e) {
            e.preventDefault();

            var $toggle = $(e.target);

            $toggle.parents(selectors.actions).toggleClass(classes.expanded);
        });

        // Hide on focus out.
        $body.on('click touchstart', function (e) {
            var $activeMenu = $(e.target).parents(selectors.actions);

            // Collapse all expanded menus except active one.
            $(selectors.actionsExpanded).not($activeMenu).removeClass(classes.expanded);
        });
    };

    // Fire.
    $(document).ready(function () {
        ctx.actionsMenu();
    });

})(jQuery, snax);


/*************************
 *
 * Module: Item Share
 *
 ************************/

(function ($, ctx) {

    'use strict';

    var selectors = {
        'wrapper' :         '.snax-item-share',
        'toggle':           '.snax-item-share-toggle',
        'expandedState':    '.snax-item-share-expanded'
    };

    var classes = {
        'expanded': 'snax-item-share-expanded'
    };

    ctx.itemShareSelectors = selectors;
    ctx.itemShareClasses   = classes;

    ctx.itemShare = function () {
        // On none touchable devices, shares visibility is handled via css :hover.
        // On touch devices there is no "hover", so we emulate hover via CSS class toggle on click.
        $(selectors.toggle).on('click', function (e) {
            e.preventDefault();

            $(this).parents(selectors.wrapper).addClass(classes.expanded);
        });

        // Hide shares on focus out.
        $('body').on('click touchstart', function (e) {
            var $activeElem = $(e.target).parents(selectors.expandedState);

            // Collapse all expanded micro shares except active one.
            $(selectors.expandedState).not($activeElem).removeClass(classes.expanded);
        });
    };

    // Fire.
    $(document).ready(function () {
        if (ctx.isTouchDevice()) {
            $('body').removeClass('snax-hoverable');

        }

        ctx.itemShare();
    });

})(jQuery, snax);


/*************************
 *
 * Module: Delete Item
 *
 ************************/

(function ($, ctx) {

    'use strict';

    /** CONFIG *******************************************/

        // Register new component.
    ctx.deleteItemModule = {};

    // Component namespace shortcut.
    var c = ctx.deleteItemModule;

    // CSS selectors.
    var selectors = {
        'deleteLink':   '.snax-delete-item'
    };

    var i18n = {
        'confirm':      'Are you sure?'
    };

    // Allow accessing
    c.selectors = selectors;
    c.i18n      = i18n;

    /** INIT *******************************************/

    c.init = function () {
        c.attachEventHandlers();
    };

    /** EVENTS *****************************************/

    c.attachEventHandlers = function() {

        /* Delete item */

        $(selectors.deleteLink).on('click', function (e) {
            e.preventDefault();

            if (!confirm(i18n.confirm)) {
                return;
            }

            ctx.deleteItem($(this), function(res) {
                if (res.status === 'success') {
                    location.href = res.args.redirect_url;
                } else {
                    alert(res.message);
                }
            });
        });
    };

    // Fire.
    $(document).ready(function () {
        c.init();
    });

})(jQuery, snax);


/*******************************
 *
 * Module: Set Item as Featured
 *
 ******************************/

(function ($, ctx) {

    'use strict';

    /** CONFIG *******************************************/

    // Register new component.
    ctx.setItemAsFeaturedModule = {};

    // Component namespace shortcut.
    var c = ctx.setItemAsFeaturedModule;

    // CSS selectors.
    var selectors = {
        'link':   '.snax-set-item-as-featured'
    };

    // Allow accessing
    c.selectors = selectors;

    /** INIT *******************************************/

    c.init = function () {
        c.attachEventHandlers();
    };

    /** EVENTS *****************************************/

    c.attachEventHandlers = function() {

        /* Delete item */

        $(selectors.link).on('click', function (e) {
            e.preventDefault();

            ctx.setItemAsFeatured($(this), function(res) {
                if (res.status === 'success') {
                    location.reload();
                } else {
                    alert(res.message);
                }
            });
        });
    };

    // Fire.
    $(document).ready(function () {
        c.init();
    });

})(jQuery, snax);