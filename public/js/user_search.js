$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
    $(this).toggleClass("open");
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
    $(this).toggleClass("open");
  });

  $('.main_categories').click(function () {
    // クリックされたメインカテゴリーの隣にあるサブカテゴリーを探して変数に
    var subCategories = $(this).next('.sub_categories');
    $(this).toggleClass("open");
    // そのサブカテゴリーを slideToggle で表示・非表示切り替え
    subCategories.slideToggle();
  });
});
