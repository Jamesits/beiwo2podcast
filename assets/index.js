userIdRegex = [
    /beiwo\.ac\/users\/my\?.*id\=([0123456789abcdef]+)/,
    /beiwo\.ac\/users\/myPageDataWithPaging\?.*id\=([0123456789abcdef]+)/
];
soundIdRegex = [
    /beiwo\.ac\/users\/getSoundByIdWithAjax\?.*id\=([0123456789abcdef]+)/,
    /beiwo\.ac\/users\/audioIndexPc\?.*id\=([0123456789abcdef]+)/,
    /beiwo\.ac\/html\/page\.html\?.*id\=([0123456789abcdef]+)/
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

function validateAndGetFeedPath(userId) {
    $.getJSON('validateUser.php', {'id': userId}, function(data){
        if (data.result) {
            showSuccess(getFeedUriByUserId(userId));
        } else {
            showWarning(getFeedUriByUserId(userId), '该用户未上传任何内容，可能导致程序出错！');
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
    $('.panel-danger').show();
    enableButton();
}

function getFeedUri(uri) {
    for (e in userIdRegex) {
        result = userIdRegex[e].exec(uri);
        if (result && result.length > 0) {
            userId = result[1];
            validateAndGetFeedPath(userId);
            return;
        }
    }
    for (e in soundIdRegex) {
        result = soundIdRegex[e].exec(uri);
        if (result && result.length > 0) {
            soundId = result[1];
            getUserId(soundId);
            return;
        }
    }
    showError('网址无法识别');
}

function doConvert() {
    disableButton();
    hideAll();
    uri = $('#fromurl').val();
    getFeedUri(uri);
    $("#fromurl").focus();
}

$(function(){
    $('#btnsend').on("click", doConvert);
    $('#formconvert').submit(function(e){
        doConvert();
        e.preventDefault();
    });
    $("#fromurl").focus();
});
