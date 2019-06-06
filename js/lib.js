var onReCaptchaSuccess = function() {
	if (window.innerWidth < 768 && (/iPhone|iPod/.test(navigator.userAgent) && !window.MSStream)) {
		var destElementOffset = $('.g-recaptcha').position().top - window.innerWidth;
		$('html, body').animate({ scrollTop: destElementOffset }, 0);
	}
}

//find empty paragraphs
$('p').each(function() {
    var t = $(this);
    if(t.html().replace(/\s|&nbsp;/g, '').length === 0) { t.addClass('jEmpty'); }
});
//cf7 valid
$(document).ready(function () {
$(this).on('mouseenter', '.wpcf7-not-valid-tip', function () {
    // $(this).prev().trigger('focus');
     $(this).fadeOut(500, function () {
         $(this).remove();
     });
 });
});

//hover ios
var mobileHover = function () {
    $('*').on('touchstart', function () {
        $(this).trigger('hover');
    }).on('touchend', function () {
        $(this).trigger('hover');
    });
};
mobileHover();
