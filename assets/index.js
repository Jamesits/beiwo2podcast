userIdRegex = [
    /beiwo\.ac\/users\/my\?.*id\=([0123456789abcdef]+)/,
    /beiwo\.ac\/users\/myPageDataWithPaging\?.*id\=([0123456789abcdef]+)/
];
soundIdRegex = [
    /beiwo\.ac\/users\/getSoundByIdWithAjax\?.*id\=([0123456789abcdef]+)/,
    /beiwo\.ac\/users\/audioIndexPc\?.*id\=([0123456789abcdef]+)/
]

function getUserId(soundId) {
    $.getJSON('getUserIdBySoundId.php', {'id': soundId}, function(data){
        if (data.userId && data.userId != '') {
            showSuccess(getFeedUriByUserId(data.userId));
        } else {
            showError('数据错误');
        }
    });
}

function getFeedUriByUserId(userId) {
    return install_path + 'feed.php?id=' + userId;
}

function disableButton() {
    $('#btnsend').text('转换中').attr('disabled', 'disabled');
}

function enableButton() {
    $('#btnsend').text('转换为 RSS').removeAttr('disabled');
}

function hideAll() {
    $('.panel').hide();
}

function showSuccess(url) {
    hideAll();
    $('.feedurl').html('<a href="' + url + '">' + url + '</a>');
    $('.panel-success').show();
    enableButton();
}

function showWarning(url, msg) {
    hideAll();
    $('.feedurl').html('<a href="' + url + '">' + url + '</a>');
    $('.errormsg').text(msg);
    $('.panel-warning').show();
    enableButton();
}

function showError(msg) {
    hideAll();
    $('.errormsg').text(msg);
    $('.panel-warning').show();
    enableButton();
}

function getFeedUri(uri) {
    for (e in userIdRegex) {
        result = userIdRegex[e].exec(uri);
        if (result && result.length > 0) {
            userId = result[1];
            showSuccess(getFeedUriByUserId(userId));
        }
    }
    for (e in soundIdRegex) {
        result = soundIdRegex[e].exec(uri);
        if (result && result.length > 0) {
            soundId = result[1];
            getUserId(soundId);
        }
    }
}

function doConvert() {
    disableButton();
    hideAll();
    uri = $('#fromurl').val();
    getFeedUri(uri);
}

$(function(){
    $('#btnsend').on("click", doConvert);
});
