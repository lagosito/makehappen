/* global document */
/* global jQuery */
/* global snax_admin */

window.snax_admin = {};

(function ($, ns) {

    $(document).ready(function () {

        ns.metaboxes();

        if ($('body').is('.settings_page_snax-general-settings')) {
            ns.settings();
        }

    });

})(jQuery, snax_admin);


/*************
 *
 * Metaboxes
 *
 *************/
(function ($, ns) {

    /** CSS *****************/

    var selectors = {
        'toggle': '#snax-metabox-options .snax-forms-toogle',
        'formsWrapper': '#snax-metabox-options-forms'
    };

    var classes = {
        'formsVisible': 'snax-forms-visibility-standard',
        'formsHidden': 'snax-forms-visibility-none'
    };

    /** end of CSS **********/

    ns.metaboxes = function () {

        $(selectors.toggle).on('change', function () {
            $(selectors.formsWrapper).toggleClass(classes.formsVisible + ' ' + classes.formsHidden);
        });

        $('#snax-open-list').on('change', function () {
            updateOpenListOptions();
        });

        $('#snax-ranked-list').on('change', function () {
            updateRankedListOptions();
        });

        $('a.snax-set-current-date').on('click', function(e) {
            e.preventDefault();

            var $input = $(this).prev('input');

            var formattedDate = new Date();

            var day     = pad(formattedDate.getDate(), 2);
            var month   = pad(formattedDate.getMonth() + 1, 2);
            var year    = formattedDate.getFullYear();
            var hours   = pad(formattedDate.getHours(), 2);
            var minutes = pad(formattedDate.getMinutes(), 2);
            var seconds = pad(formattedDate.getSeconds(), 2);

            $input.val(year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds);
        });
    };

    function updateOpenListOptions() {
        var show = $('#snax-open-list').is(':checked');
        var $box = $('#snax-open-list-options');

        if (show) {
            $box.show();
        } else {
            $box.hide();
        }
    }

    function updateRankedListOptions() {
        var show = $('#snax-ranked-list').is(':checked');
        var $box = $('#snax-ranked-list-options');

        if (show) {
            $box.show();
        } else {
            $box.hide();
        }
    }

    function pad(n, width, z) {
        z = z || '0';
        n = n + '';
        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }

})(jQuery, snax_admin);

/*************
 *
 * Settings
 *
 *************/
(function ($, ns) {

    ns.settings = function () {
        if ($.fn.sortable) {
            $('#snax-settings-active-formats').sortable({
                'update': function() {
                    var formats = [];

                    $(this).find('input[type=checkbox]').each(function() {
                        formats.push($(this).val());
                    });

                    $('#snax_formats_order').val(formats.join(','));
                }
            });
        }
    };

})(jQuery, snax_admin);


