/*
 * jquery.tgTwNotifyMessage1
 * for jQuery 1.8.1
 * 
 * 【概要】Twitter風の通知バー表示プラグイン パターンA
 * 
 * 
 * @Copyright : 2013 toogie | http://wataame.sumomo.ne.jp/archives/2694
 * @Version   : 1.0
 * @Modified  : 2013-04-16
 * 
 */

(function ($) {
    "use strict";
    $.fn.tgTwNotifyMessage1 = function (options) {

        var opts = $.extend({}, $.fn.tgTwNotifyMessage1.defaults, options);

        $(function () {
            $("document").ready(function () {
                $(opts.selector).stop().animate({'marginTop' : '0'}, 750).delay(opts.delayTime).slideUp(opts.slideUpTime);
            });
        });
    };

	// default option
	$.fn.tgTwNotifyMessage1.defaults = {
		selector : "#notifyMessage",	// セレクタ
        delayTime : 1500,               // メッセージ表示時間
		slideUpTime : 300				// スライドアップアニメーション時間
	};

})(jQuery);