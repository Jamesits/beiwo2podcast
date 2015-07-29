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

function hideAll() {
    $('.panel').hide();
}

function showSuccess(url) {
    hideAll();
    $('.feedurl').text(url);
    $('.panel-success').show();
}

function showWarning(url, msg) {
    hideAll();
    $('.feedurl').text(url);
    $('.errormsg').text(msg);
    $('.panel-warning').show();
}

function showError(msg) {
    hideAll();
    $('.errormsg').text(msg);
    $('.panel-warning').show();
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
    hideAll();
    uri = $('#fromurl').val();
    getFeedUri(uri);
}

$(function(){
    $('#btnsend').on("click", doConvert);
});
