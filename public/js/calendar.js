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

// キャンセルモーダル表示
$('.js-modal-open').on('click', function () {
    // モーダルの中身がフェードイン
    $('.js-modal').fadeIn();
    // .js-modal-openのカスタム属性を変数に格納
    // attr()はカスタム属性を取得する
    var reserveDate = $(this).attr('reserveDate');
    var reservePart = $(this).attr('reservePart');

    // （ブレイドでの場所を指定）　value属性に水色の変数を入れる
    $('.reserveDate').text("予約日： " + reserveDate);
    $('.reservePart').text("時間： リモ" + reservePart + "部");

    // キャンセルボタン送信時に送る値
    $('.delete input[name="getPart"]').val(reservePart);
    $('.delete input[name="delete_date"]').val(reserveDate);

    return false;
});

$('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
});
