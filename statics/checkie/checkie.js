var ua = window.navigator.userAgent;
if (/msie/i.test(ua)) {
    if (parseInt(ua.match(/msie (\d+\.\d+)/i)[1])<9) {
        showLayer('#browser-fail');
    }
}
function showLayer(id) {
    closeLayers();
    var iframe = $(id).find('iframe');
    if (iframe.length > 0) {
        iframe.attr('src',iframe.attr('data-src'));
    }
    $('.floating-black').show();
    $(id).show();
}
function closeLayers() {
    $('.floating-black').hide();
    $('.floating-black .close').nextUntil('.shadow').hide();
}

$('.floating-black .close').click(function () {
    closeLayers();
});