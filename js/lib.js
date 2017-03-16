//selbel
(function ($) {
    'use strict';
    $.fn.selbel = function(settings) {
        var defaults = {
            onChange: function () {}
        },
        options = $.extend(defaults, settings);

        return this.each(function () {
            var el = $(this),
                sb_label = el.attr("data-label") !== undefined ? '<label>' + el.attr("data-label") + '</label>' : '';
            if (!el.hasClass('selbel')) { el.addClass('selbel'); }
            if(el.parent().is('.selbel_w')) { return false; }
            el.each(function() {
                $(this).wrap("<span class='selbel_w' />").before(sb_label).after('<span>' + $('*:selected', this).text() + '</span>');
            });
            el.change(function() {
                $(this).next().text($('*:selected', this).text());
                if(options.onChange) options.onChange.call(this);
            });
        });
    };
})(jQuery);
//find empty paragraphs
$('p').each(function() {
    var t = $(this);
    if(t.html().replace(/\s|&nbsp;/g, '').length === 0) { t.addClass('jEmpty'); }
});
//cf7 valid
$(document).ready(function () {
    $(this).on('click', '.wpcf7-not-valid-tip', function(){
        $(this).prev().trigger('focus');
        $(this).fadeOut(500,function(){
            $(this).remove();
        });
    });
});