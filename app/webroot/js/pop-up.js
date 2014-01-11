/**
 * Created by ishigetani on 14/01/11.
 */

$(function() {
    $( 'a[rel*=leanModal]').leanModal({
        top: 50,                     // モーダルウィンドウの縦位置を指定
        overlay : 0.5,               // 背面の透明度
        closeButton: "#chat-add"  // 閉じるボタンのCSS classを指定
    });
});