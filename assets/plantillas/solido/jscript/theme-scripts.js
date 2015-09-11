
var footer_reach = 0,
	articleFont = 16,
	autoscroller = true,
	autoslidertime = 5000;

Array.prototype.forEach2=function(a){ var l=this.length; for(var i=0;i<l;i++)a(this[i],i) };

(function ($) {
	"use strict";

	jQuery(window).on("scroll", function() {
		var mainmenu = jQuery("#main-menu.willfix", ".header");
		if(parseInt(mainmenu.attr("rel"), 10) <= Math.abs(parseInt(jQuery(window).scrollTop(), 10))){
			mainmenu.addClass("isfixed");
		}else{
			mainmenu.removeClass("isfixed");
		}
		refreshSidebarFixed();
	});


	jQuery(window).on("resize", function(){
		var slwidth = parseInt(jQuery(".ot-slider-new", ".content").width(), 10);
		jQuery(".slider-slide > img", ".ot-slider-new").css("width", slwidth+"px");
		jQuery(".ot-slider-new", ".content").addClass("slidenoanim");
		jQuery(".slider-new-slides", ".ot-slider-new").children(".slider-slide").eq(0).css("margin-left", "-"+(parseInt(jQuery(".ot-slider-new", ".content").data("curr-slide"), 10)*parseInt(jQuery(".ot-slider-new", ".content").width(), 10))+"px");
		jQuery(".ot-slider-new", ".content").removeClass("slidenoanim");
	});

	jQuery(window).on("resize load", function(){
		jQuery(".item .item-content", ".article-grid.articles-long").toArray().forEach2(function(a){
			var thisel = jQuery(a),
				newheight = parseInt(thisel.siblings(".item-header").height(), 10)-83,
				newtextheight = Math.floor((newheight-parseInt(thisel.children(".item-content-head").height(), 10)-31)/19)*19;
			thisel.children("p").height(newtextheight);
			thisel.height(newheight);
		});
	});

	// jQuery(".article-more-arrow", ".content").on("mouseenter", function(){
	// 	var thisel = jQuery(this);
	// 	thisel.stop().animate({
	// 		"padding-right": (parseInt(thisel.children(".show-hover").width(), 10)+parseInt(thisel.children(".show-hover").css("padding-left"), 10)+parseInt(thisel.children(".show-hover").css("padding-right"), 10))+"px"
	// 	}, 150);
	// }).on("mouseleave", function(){
	// 	var thisel = jQuery(this);
	// 	thisel.stop().animate({
	// 		"padding-right": "0px"
	// 	}, 150);
	// });

	jQuery('a[href="#top"]').on("click", function () {
		jQuery('body,html').animate({
			scrollTop: 0
		}, 500);
		return false;
	});


	jQuery(window).on("load", function() {

		jQuery("a[href='#article-share']").on("click", function(){
			jQuery(".share-popup-block", ".content").toggle();
			return false;
		});

		jQuery(window).on("resize scroll", function(){
			refreshSidebarFixed();
		});

		jQuery(".ot-showmenu", ".header").on("click", function(){
			jQuery(this).find(".cmn-toggle-switch").toggleClass("active");
			jQuery(".under-menu").animate({
				"height": "toggle"
			}, 300);
			return false;
		});

		var slwidth = parseInt(jQuery(".ot-slider-new", ".content").width(), 10);
		jQuery("img", ".slider-slide").css("width", slwidth+"px");

		jQuery(".ot-scrollnimate", "body").toArray().forEach2( function(a){
			var bottom_of_object = jQuery(a).offset().top;
			var bottom_of_window = jQuery(window).scrollTop() + jQuery(window).height();

			if( bottom_of_window <= bottom_of_object ){
				jQuery(this).children().css("visibility", "hidden");
			}else{
				scrollNimate(jQuery(this));
				jQuery(this).removeClass("ot-scrollnimate");
			}
		});

		jQuery(window).on("scroll", function(){
			jQuery(".ot-scrollnimate", "body").toArray().forEach2( function(a){
				var bottom_of_object = jQuery(a).offset().top;
				var bottom_of_window = jQuery(window).scrollTop() + jQuery(window).height();

				if( bottom_of_window > bottom_of_object ){
					scrollNimate(jQuery(this));
					jQuery(this).removeClass("ot-scrollnimate");
				}
			});
		});


		jQuery(".tabs a", ".woocommerce-tabs").on("click", function(){
			var thisel = jQuery(this),
				thisopen = thisel.attr("href").split("#")[1];
			thisel.parent().addClass("active").siblings("li.active").removeClass("active").parent().parent().children(".panel").hide().siblings(".panel#"+thisopen).show();
			return false;
		});


		if(jQuery(".gallery-thumbnail-list", ".content").length){
			myScroll = new IScroll('.gallery-thumbnail-list', {
				scrollbars: true,
				mouseWheel: true,
				interactiveScrollbars: false,
				shrinkScrollbars: 'scale',
				fadeScrollbars: false,
				tap: true
			});
		}


		jQuery("#main-menu.willfix", ".header").toArray().forEach2(function(a) {
			var thisel = jQuery(a);
			thisel.wrap("<div class='main-menu-parent'></div>").attr("rel", thisel.offset().top).parent().height(thisel.height());
		});

		jQuery(".alert-box .close-alert, .coloralert .close-alert", ".content").on("click", function() {
			jQuery(this).parent().fadeOut();
			return false;
		});

		jQuery("a", ".category-ordering").on("click", function() {
			var thisel = jQuery(this),
				thisdata = thisel.data("trigger-cat"),
				elementanimate = "fadeIn";
			thisel.addClass("active").siblings(".active").removeClass("active");
			if(thisdata == "" || thisdata == "*"){
				thisel.parent().parent().siblings("div").find("[data-self-cat]").removeClass("animated "+elementanimate).css("display", "block");
				thisel.parent().parent().siblings("div").find("[data-self-cat]").addClass("animated "+elementanimate);
			}else{
				thisel.parent().parent().siblings("div").find("[data-self-cat]").toArray().forEach2(function(a) {
					var newel = jQuery(a),
						arraycats = (!newel.data("self-cat"))?"*":newel.data("self-cat").split(" ");

					if(jQuery.inArray(thisdata, arraycats) >= 0){
						if (newel.hasClass("category-select-block")){
							newel.removeClass("animated "+elementanimate).css("display", "flex").addClass("animated "+elementanimate);
						}else{
							newel.removeClass("animated "+elementanimate).css("display", "block").addClass("animated "+elementanimate);
						}
					}else{
						newel.css("display", "none");
					}
				});
			}
			return false;
		});

		footer_reach = parseInt(jQuery(".footer", "body").offset().top, 10);
		setTimeout(function(){
			footer_reach = parseInt(jQuery(".footer", "body").offset().top, 10);
		}, 1000);

		jQuery(".item-footer > a", ".ot-widget-gallery").on("click", function(){
			var thisel = jQuery(this),
				thiswidth = parseInt(thisel.siblings(".item-thumbnails").width(), 10),
				thisinner = thisel.siblings(".item-thumbnails").children(".item-thumbnails-inner"),
				thissize = Math.ceil(thisinner.children("a").length/3);

			if(!thisel.parent().data("current-page")){
				thisel.parent().data("current-page", 0);
			}

			if(thisel.attr("href") == "#galery-right"){
				if(thissize <= parseInt(thisel.parent().data("current-page"), 10)+1)return false;
				thisel.parent().data("current-page", parseInt(thisel.parent().data("current-page"), 10)+1);
				thisinner.css("margin-left", "-"+(thisel.parent().data("current-page")*(thiswidth+6))+"px");
			}else
			if(thisel.attr("href") == "#galery-left"){
				if(0 > parseInt(thisel.parent().data("current-page"), 10)-1)return false;
				thisel.parent().data("current-page", parseInt(thisel.parent().data("current-page"), 10)-1);
				thisinner.css("margin-left", "-"+(thisel.parent().data("current-page")*(thiswidth+6))+"px");
			}

			return false;
		});

		jQuery(".item-thumbnails-inner > a", ".ot-widget-gallery").on("click", function(){
			var thisel = jQuery(this);
			
			thisel.parent().parent().parent().siblings(".item-header").children("a").css("display", "none").addClass("markforremove").parent().prepend("<a href='"+thisel.data("href")+"' class='animated fadeIn'><img src='"+thisel.attr("href")+"' /></a>").children(".markforremove").remove();
			return false;
		});


		// Accordion blocks
		jQuery(".accordion > div > a", ".content").on("click", function () {
		    var thisel = jQuery(this).parent();
		    if (thisel.hasClass("active")) {
		        thisel.removeClass("active").children("div").animate({
		            "height": "toggle",
		            "opacity": "toggle",
		            "padding-top": "toggle"
		        }, 300);
		        return false;
		    }
		    thisel.siblings("div").toArray().forEach2(function (a) {
		        var tz = jQuery(a);
		        if (tz.hasClass("active")) {
		            tz.removeClass("active").children("div").animate({
		                "height": "toggle",
		                "opacity": "toggle",
		                "padding-top": "toggle"
		            }, 300);
		        }
		    });
		    thisel.addClass("active").children("div").animate({
		        "height": "toggle",
		        "opacity": "toggle",
		        "padding-top": "toggle"
		    }, 300);
		    return false;
		});


		// Tabbed blocks
		jQuery(".short-tabs", ".content").toArray().forEach2(function (a) {
			var thisel = jQuery(a);
			thisel.children("div").eq(0).addClass("active");
			thisel.children("ul").children("li").eq(0).addClass("active");
		});

		jQuery(".short-tabs > ul > li a", ".content").on("click", function () {
			var thisel = jQuery(this).parent();
			thisel.siblings(".active").removeClass("active");
			thisel.addClass("active");
			thisel.parent().siblings("div.active").removeClass("active");
			thisel.parent().siblings("div").eq(thisel.index()).addClass("active");
			return false;
		});

		jQuery(".lightbox", "body").on("click", function () {
			var thisel = jQuery(this);
			thisel.css('overflow', 'hidden');
			jQuery("body").css('overflow', 'auto');
			thisel.find(".lightcontent").fadeOut('fast');
			thisel.fadeOut('slow');
			return false;
		}).children().on("click", function (e) {
			return false;
		});


		jQuery(".article-meta-block a.font-meta-down, .article-meta-block a.font-meta-up", "content").on("click", function(){
			var thisel = jQuery(this);

			if(thisel.hasClass("font-meta-down")){
				articleFont = (articleFont <= 16)?16:articleFont-1;
			}else{
				articleFont = (articleFont >= 25)?25:articleFont+1;
			}
			thisel.siblings(".font-meta-num").html(articleFont).parent().parent().parent().parent().parent().css("font-size", articleFont+"px");
			return false;
		});

		jQuery(".category-review-block .featured-text, .article-featured-block .featured-text", "content").animate({
			"height":"toggle"
		}, 1);

		jQuery(".category-review-block .item a, .article-featured-block a", "content").on("mouseenter", function(){
			jQuery(this).find(".featured-text").animate({
				"height":"toggle",
				"paddingTop": "10px"
			}, 450, "swing");
			return false;
		});

		jQuery(".category-review-block .item a, .article-featured-block a", "content").on("mouseleave", function(){
			jQuery(this).find(".featured-text").animate({
				"height":"toggle",
				"paddingTop": "0px"
			}, 450, "swing");
			return false;
		});

		jQuery("a", ".ot-slider-new-controls").append("<span class='loading-line'></span>");

		if(autoscroller){
			jQuery(".ot-slider-new", ".content").toArray().forEach2(function(a){
				otslider_load(0, false, a);
			});
		}

		jQuery("a", ".ot-slider-new-controls").on("click", function() {
			autoscroller = false;
			otslider_load(jQuery(this).index(), true, jQuery(this).parent().parent().parent());
			return false;
		});

		jQuery(".ot-slider-new-controls-right", ".ot-slider-new").on("click", function() {
			var thisel = jQuery(this),
				thisvar = thisel.siblings(".ot-slider-new-controls-inner").children("a.active");
			
			autoscroller = false;
			thisvar.removeClass("active");
			if(thisvar.next().index() == -1){
				otslider_load(0, true, thisel.parent().parent());
			}else
			if(thisvar.next() != thisvar){
				otslider_load(thisvar.next().index(), true, thisel.parent().parent());
			}
			return false;
		});

		jQuery(".ot-slider-new-controls-left", ".ot-slider-new").on("click", function() {
			var thisel = jQuery(this),
				thisvar = thisel.siblings(".ot-slider-new-controls-inner").children("a.active");
			
			autoscroller = false;
			thisvar.removeClass("active");
			if(thisvar.prev().index() == -1){
				otslider_load(thisel.siblings(".ot-slider-new-controls-inner").children("a").size()-1, true, thisel.parent().parent());
			}else
			if(thisvar.prev() != thisvar){
				otslider_load(thisvar.prev().index(), true, thisel.parent().parent());
			}
			return false;
		});

		// Read more button navigates to article
		jQuery(".article-more-arrow", ".content").on("click", function(){
			var thisel = jQuery(this);
			window.location = thisel.parent().siblings(".item-content").find(".item-content-head h3 a").attr("href");
			return false;
		});


	});

})(jQuery);

// Sets position for fixed slider
function refreshSidebarFixed(){
	var fixedSidebars = jQuery(".sidebar-fixed", ".content");

	if(fixedSidebars.length){
		fixedSidebars.toArray().forEach2(function(a){
			var thisel = jQuery(a),
				fixedHeight = parseInt(thisel.height(), 10)+parseInt(thisel.offset().top, 10),
				fixedH = parseInt(thisel.height(), 10),
				fixedOffset = parseInt(thisel.offset().top, 10),
				contentHeight = parseInt(thisel.parent().height()+thisel.parent().offset().top, 10),
				scrollOffset = (jQuery("body").hasClass("admin-bar"))?parseInt(jQuery(window).scrollTop(), 10)+32+30:parseInt(jQuery(window).scrollTop(), 10)+30;
				scrollOffset = (jQuery("#main-menu", ".header").hasClass("willfix"))?scrollOffset+40:scrollOffset;
			
			var dopadding = scrollOffset - fixedOffset;

			if(fixedHeight >= contentHeight){
				thisel.removeClass("is-now-fixed").css("paddingTop", "0px");
			}else if(fixedOffset <= scrollOffset){
				if(dopadding+fixedOffset+fixedH >= contentHeight){
					thisel.addClass("is-now-fixed").css("paddingTop", parseInt(contentHeight-fixedHeight, 10)+"px");
				}else{
					thisel.addClass("is-now-fixed").css("paddingTop", parseInt(dopadding, 10)+"px")
				}
			}else{
				thisel.removeClass("is-now-fixed").css("paddingTop", "0px");
			}
		});
	}
}

function otslider_load(slide, stay, item){
	var mainel = item;
	jQuery(mainel).data("curr-slide", slide);
	jQuery(mainel).find(".slider-new-slides").children(".slider-slide").eq(0).css("margin-left", "-"+(slide*parseInt(jQuery(mainel).width(), 10))+"px");
	if(stay){
		jQuery(mainel).find(".ot-slider-new-controls-inner").children("a").removeClass("active").eq(slide).addClass("active").children(".loading-line").stop( true, true ).css("width", "100%");
		return false;
	}
	jQuery(mainel).find(".ot-slider-new-controls-inner").children("a").removeClass("active").eq(slide).addClass("active").children(".loading-line").css("width", 0).animate({
		"width": "100%"
	}, autoslidertime, "linear", function() {
		var thisel = jQuery(this);
		if(autoscroller){
			thisel.parent().removeClass("active");
			if(thisel.parent().next().index() == -1){
				otslider_load(0, false, mainel);
			}else
			if(thisel.parent().next() != thisel){
				otslider_load(thisel.parent().next().index(), false, mainel);
			}
		}
	});
}


function lightboxclose() {
	var thisel = jQuery(".lightbox");
	thisel.css('overflow', 'hidden');
	thisel.find(".lightcontent").fadeOut('fast');
	thisel.fadeOut('slow');
	jQuery("body").css('overflow', 'auto');
}

// Animation time of revieling and hiding menu (defaut = 400)
var _datMenuAnim = 400;
// Animation effect for now it is just 1 (defaut = "effect-1")
var _datMenuEffect = "effect-2";
// Submenu dropdown animation (defaut = true)
var _datMenuSublist = true;
// If fixed header is showing (defaut = true)
var _datMenuHeader = true;
// Header Title
var _datMenuHeaderTitle = "Solidus";
// If search is showing in header (defaut = true)
var _datMenuSearch = true;
// Search icon (FontAwesome) in header (defaut = fa-search)
var _datMenuCustomS = "fa-search";
// Menu icon (FontAwesome) in header (defaut = fa-bars)
var _datMenuCustomM = "fa-bars";  

function scrollNimate(_element) {

	var datanime = _element.data("animation"),
		uptimeout = 0;
	
	_element.children().toArray().forEach2(function (a) {
		var coolem = jQuery(a);
		coolem.css("visibility", "hidden").css("opacity", "0");
		setTimeout(function () {
			coolem.css("visibility", "visible").css("opacity", "1").addClass("animated "+datanime);
		}, uptimeout);
		uptimeout = uptimeout+200;
	});
	_element.removeClass("ot-scrollnimate");
	return false;

}