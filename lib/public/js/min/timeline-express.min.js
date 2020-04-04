/*
 * @Plugin Timeline Express
 * @Author Code Parrots
 * @Site https://www.wp-timelineexpress.com
 * @Version 1.8.1
 * @Build 04-04-2020
 */
jQuery(document).ready(function(){window.dispatchEvent(new CustomEvent("timelineLayoutStart")),jQuery("html").addClass("cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions");var e=jQuery(".cd-timeline-block");e.each(function(){timeline_express_data.animation_disabled||jQuery(this).offset().top>jQuery(window).scrollTop()+.75*jQuery(window).height()&&jQuery(this).find(".cd-timeline-img, .cd-timeline-content").addClass("is-hidden")}),timeline_express_data.animation_disabled||jQuery(window).on("scroll",function(){e.each(function(){jQuery(this).offset().top<=jQuery(window).scrollTop()+.75*jQuery(window).height()&&jQuery(this).find(".cd-timeline-img").hasClass("is-hidden")&&jQuery(this).find(".cd-timeline-img, .cd-timeline-content").removeClass("is-hidden").addClass("bounce-in")})}),window.dispatchEvent(new CustomEvent("timelineLayoutComplete"))});