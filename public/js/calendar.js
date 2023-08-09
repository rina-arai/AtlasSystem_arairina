$(function () {

    // 編集ボタン(class="js-modal-open")が押されたら発火
    $('.js-modal-open').on('click', function () {
        // モーダルの中身(class="js-modal")の表示
        $('.js-modal').fadeIn();
        return false;
    });

    // はいボタンがクリックされた場合の処理
    $('#cancelButton').on('click', function (href) {
        // リンクの遷移
        window.location.href = href;
    });

    // 背景部分や閉じるボタン(js-modal-close)が押されたら発火
    $('.js-modal-close').on('click', function () {
        // モーダルの中身(class="js-modal")を非表示
        $('.js-modal').fadeOut();
        return false;
    });

});
