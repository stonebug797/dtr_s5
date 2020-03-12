$(function () {
	"use strict";
	var body = $('body'),
	header = $('#header'),
	footer = $('#footer'),
	scTop = 0;
	var ui = {
		menuOpen : function () {
			body.addClass('modal-open');
			header.addClass('active');
			$('.gnb').fadeIn(function () {
				$('.gnb__thumlist li').css('opacity',1);
			});
		},
		menuHide : function () {
			body.removeClass('modal-open');			
			header.removeClass('active');			
			$('.gnb__thumlist li').css('opacity',0);
			$('.gnb').fadeOut();
		},
		menuToggle : function () {
			if (header.hasClass('active')) {
				ui.menuHide();
			} else {
				ui.menuOpen();
			}
		},
		viewArea : function (ele) {
			var parent = ele.parent('li');
			parent.toggleClass('active');
			ele.next('.introduce__ba-listdetail').slideToggle();
		},
		viewBrochure : function () {
			$('.brochure__list').slideToggle();
		},
		explorer : function () {
			var margin = 0;
			if (!isMobile()) {
				margin = 100;
			}
			var t = $('.comm-tab').position().top;
			$('html,body').animate({
				scrollTop : (t-margin)+'px'
			},800,'easeInOutExpo');
		},
		bind : function () {
			$('[data-allmenu]').bind('click',function (e) {ui.menuToggle()});
			$('[data-arealist] li > a').bind('click',function (e) {e.preventDefault();});
			$(document).on('click','[data-brochure]',function (e) {ui.viewBrochure();});
			$('.introduce__top-explore a').bind('click',function(e) {e.preventDefault();ui.explorer();})
		}
	}
	ui.bind();

	/*
	var historyCurrernt = 3;
	var history  = {
		init : function () {
			$('.history .article').eq(3).fadeIn(function () {
				$(this).addClass('show');
			});
		},
		prev : function () {
			historyCurrernt--;
			if (historyCurrernt==-1) {historyCurrernt=3;}
			var prev = $('.history .article').eq(historyCurrernt);
			$('.history .article').not(prev).hide().removeClass('show');
			prev.fadeIn(function () {
				$(this).addClass('show');
			});
		},
		next : function () {
			historyCurrernt++;
			if (historyCurrernt==4) {historyCurrernt=0;}
			var next = $('.history .article').eq(historyCurrernt);
			$('.history .article').not(next).hide().removeClass('show');
			next.fadeIn(function () {
				$(this).addClass('show');				
			});
		},
		bind : function () {
			$('[data-historyprev]').bind('click',function (e) {e.preventDefault();history.prev();});
			$('[data-historynext]').bind('click',function (e) {e.preventDefault();history.next();});
		}		
	}
	history.bind();
	history.init();
	*/

	var main = {
		init : function() {
			$('.main .container').fadeIn(function () {
				$(this).addClass('show');
			});
		}
	}
	main.init();

	// TAB
	$.fn.tab = function (option) {		
		var defaults = {
			tabBtn : $(this),
			tabContent : '.tab-content'
		},
		options =  $.extend({},defaults,option),
		href = $(this).attr('href'),
		target = $(href);
		$(options.tabContent).not(target).removeClass('active');
		options.tabBtn.siblings().removeClass('active');
		options.tabBtn.addClass('active');
		target.addClass('active');
	}
	$('[data-tab] a').click(function (e) {
		e.preventDefault();
		$(this).tab();
	});
	// default tab
	$('[data-tab] a').first().tab();
});

$(window).on('load scroll',function() {
	/*console.log($(window).scrollTop());*/
	/*if($(window).scrollTop() > $("#header").height()) {*/
	if($(window).scrollTop() > 0) {
		$(".header").addClass("header_bg");
	}
	else {
		$(".header").removeClass("header_bg");
	}
});
/***************************************************
* AGENT & MOBILE
***************************************************/
var isMobile = function () {
	var filter = "win16|win32|win64|mac|macintel";
	if( navigator.platform  ){
		if( filter.indexOf(navigator.platform.toLowerCase())<0 ){
			return true;
		} else {
			return false;
		}
	}
}