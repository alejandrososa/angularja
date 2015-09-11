

jQuery(document).ready(function() {
	jQuery("body").append("<div class='demo-settings'></div>");
	jQuery(".demo-settings").append("<a href='#show-settings' class='demo-button'><i class='fa fa-gear'></i>Settings</a>");
	jQuery(".demo-settings").append("<div class='demo-options'>"+
										"<div class='title'>Demo Settings</div>"+
										"<a href='#demo' rel='font-options' class='option'><img src='images/demo/image-1.png' class='demo-icon' alt='' /><span>Font Settings</span><font>Change Fonts</font></a>"+
										"<div class='option-box' rel='font-options'>"+
											"<div alt='font-options'>"+
												"<b class='sub-title'>Titles & Menu Font</b>"+
												"<a href='#' class='font-bulb active' style='font-family:\"PT Sans Narrow\", sans-serif;'>Aa</a>"+
												"<a href='#' class='font-bulb' style='font-family:\"Source Sans Pro\", sans-serif;'>Aa</a>"+
												"<a href='#' class='font-bulb' style='font-family:\"Alegreya Sans SC\", sans-serif;'>Aa</a>"+
												"<a href='#' class='font-bulb' style='font-family:\"Ruda\", sans-serif;'>Aa</a>"+
												"<a href='#' class='font-bulb' style='font-family:\"Marvel\", sans-serif;'>Aa</a>"+
											"</div>"+
										"</div>"+
										"<div class='option-box sequal' rel='font-options'>"+
											"<div alt='font-options2'>"+
												"<b class='sub-title'>Paragraph Font</b>"+
												"<a href='#' class='font-bulb active' style='font-family:\"PT Sans\", sans-serif;'>Aa</a>"+
												"<a href='#' class='font-bulb' style='font-family:\"Source Sans Pro\", sans-serif;'>Aa</a>"+
												"<a href='#' class='font-bulb' style='font-family:\"Alegreya Sans SC\", sans-serif;'>Aa</a>"+
												"<a href='#' class='font-bulb' style='font-family:\"Ruda\", sans-serif;'>Aa</a>"+
												"<a href='#' class='font-bulb' style='font-family:\"Marvel\", sans-serif;'>Aa</a>"+
											"</div>"+
										"</div>"+
										"<a href='#demo' rel='color-options' class='option'><img src='images/demo/image-2.png' class='demo-icon' alt='' /><span>Color Options</span><font>Color schemes</font></a>"+
										"<div class='option-box' rel='color-options'>"+
											"<div alt='color-options'>"+
												"<b class='sub-title'>Main Hover Color</b>"+
												"<a href='#' class='color-bulb active' style='background: #ce0000;'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background: #CE6300;'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background: #2CAA2C;'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background: #2985B9;'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background: #9231B1;'>&nbsp;</a>"+
											"</div>"+
										"</div>"+
										"<a href='#demo' rel='page-header' class='option'><img src='images/demo/image-6.png' class='demo-icon' alt='' /><span>Change Header</span><font>Choose Header Style</font></a>"+
										"<div class='option-box' rel='page-header'>"+
											"<div alt='header-box'>"+
												"<b class='sub-title'>Header Style</b>"+
												"<a href='#' class='header-bulb active' rel='style-1'><img src='images/demo/header-1.png' alt='' /></a>"+
												"<a href='#' class='header-bulb' rel='style-2'><img src='images/demo/header-2.png' alt='' /></a>"+
											"</div>"+
										"</div>"+
										"<a href='#demo' rel='background' class='option'><img src='images/demo/image-3.png' class='demo-icon' alt='' /><span>Background</span><font>Backgorund textures</font></a>"+
										"<div class='option-box' rel='background'>"+
											"<div alt='background'>"+
												"<b class='sub-title'>Background Texture</b>"+
												"<a href='#' class='color-bulb active' style='background: #efefef;'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background: url(images/background-texture-3.jpg);'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background: url(images/background-texture-1.jpg);'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background: url(images/background-texture-2.jpg);'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background: url(images/background-texture-4.jpg);'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background: url(images/background-texture-5.jpg);'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background-image: url(images/background-photo-1.jpg);background-size: 100%; background-attachment: fixed;'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background-image: url(images/background-photo-2.jpg);background-size: 100%; background-attachment: fixed;'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background-image: url(images/background-photo-3.jpg);background-size: 100%; background-attachment: fixed;'>&nbsp;</a>"+
												"<a href='#' class='color-bulb' style='background-image: url(images/background-photo-4.jpg);background-size: 100%; background-attachment: fixed;'>&nbsp;</a>"+
											"</div>"+
										"</div>"+
										"<a href='#demo' rel='page-width' class='option'><img src='images/demo/image-4.png' class='demo-icon' alt='' /><span>Change Width</span><font>Boxed or Full-Width</font></a>"+
										"<div class='option-box' rel='page-width'>"+
											"<div alt='option-box'>"+
												"<b class='sub-title'>Switch Page Width</b>"+
												"<a href='#' class='option-bulb active' rel='full'>Full-Width</a>"+
												"<a href='#' class='option-bulb' rel='boxed'>Boxed</a>"+
											"</div>"+
										"</div>"+
									"</div>");
	
	jQuery(".demo-settings a[href=#demo]").click(function(){
		var thiselem = jQuery(this);
		if(thiselem.parent().find("div[rel="+thiselem.attr("rel")+"]").hasClass("thisis") == false){
			thiselem.parent().find("div.thisis").removeClass("thisis").animate({
				height: 'toggle',
				paddingTop: 'toggle',
				opacity: 'toggle'
			}, 150);
		}
		thiselem.parent().find("div[rel="+thiselem.attr("rel")+"]").toggleClass("thisis").animate({
			height: 'toggle',
			paddingTop: 'toggle',
			opacity: 'toggle'
		}, 150);
		return false;
	});
	
	jQuery(".option-box div .color-bulb").click(function(){
		var thiselem = jQuery(this);
		var newcolor = thiselem.css("background-color");
		thiselem.siblings().removeClass("active");
		thiselem.addClass("active");

		if(thiselem.parent().attr("alt") == "color-options"){
			jQuery("head").append("<style>a:hover, .main-content .shortcode-content a:hover, .ot-panel-block.panel-dark > div a:hover, .widget .ot-widget-review .item a:hover strong, .widget.widget-dark .article-block .item-content h4 a:hover, .footer .footer-widgets a:hover, #sidebar-small.small-sidebar .widget > .title-block h2, .article-grid .item .item-content-date { color: "+newcolor+"; }</style>");
			jQuery("head").append("<style>.main-content .shortcode-content .tags-cats > a, .main-content .shortcode-content .tags-cats > span, .main-content .shortcode-content .article-header .article-header-meta .meta-item.meta-share-button i.fa, .writecomment .contact-form-submit button, .ot-panel-block .title-block h2, #sidebar-small .widget > .title-block h2, #sidebar .widget > .title-block h2, .article-grid .item .item-header .item-header-category i.fa, .ot-slider-new .ot-slider-new-controls .ot-slider-new-controls-left, .ot-slider-new .ot-slider-new-controls .ot-slider-new-controls-right, #main-menu ul li > a > span .m-d-arrow, .ot-slider-new .slider-slide .slider-layer .date { background: "+newcolor+"; }</style>");
		}

		return false;
	});
	
	jQuery(".option-box div .color-bulb").click(function(){
		var thiselem = jQuery(this);
		var newcolor = thiselem.css("background-image");
		var newcolor_1 = thiselem.css("background-position");
		var newcolor_2 = thiselem.css("background-repeat");
		var newcolor_3 = thiselem.css("background-attachment");
		var newcolor_4 = thiselem.css("background-origin");
		var newcolor_5 = thiselem.css("background-clip");
		var newcolor_6 = thiselem.css("background-color");
		var newcolor_7 = thiselem.css("background-size");
		thiselem.siblings().removeClass("active");
		thiselem.addClass("active");

		if(thiselem.parent().attr("alt") == "background"){
			jQuery(".dat-menu-container").css("background-image", newcolor).css("background-position", newcolor_1).css("background-repeat", newcolor_2).css("background-attachment", newcolor_3).css("background-origin", newcolor_4).css("background-clip", newcolor_5).css("background-color", newcolor_6).css("background-size", newcolor_7);
		}

		return false;
	});
	
	jQuery(".option-box div .font-bulb").click(function(){
		var thiselem = jQuery(this);
		var newfont = thiselem.css("font-family");
		thiselem.siblings().removeClass("active");
		thiselem.addClass("active");

		if(thiselem.parent().attr("alt") == "font-options"){
			jQuery("h1, h2, h3, h4, h5, h6, .widget .ot-widget-review .item strong, .widget .article-block .item-button, .ot-slide .ot-slider-layer a .content-bottom > strong, #main-menu, .under-menu a").css("font-family", newfont);
		}else
		if(thiselem.parent().attr("alt") == "font-options2"){
			jQuery("p, .ot-panel-block .title-block span, .split-block > #sidebar .widget > .title-block span, .ot-panel-block .title-block span, .top-menu").css("font-family", newfont);
		}

		return false;
	});
	
	jQuery(".option-box div .option-bulb").click(function(){
		var thiselem = jQuery(this);
		var newsize = thiselem.attr("rel");
		thiselem.siblings().removeClass("active");
		thiselem.addClass("active");

		if(thiselem.parent().attr("alt") == "option-box"){
			if(newsize == "boxed"){
				jQuery(".boxed").addClass("active");
				jQuery(window).resize();
			}else
			if(newsize == "full"){
				jQuery(".boxed").removeClass("active");
				jQuery(window).resize();
			}
		}

		return false;
	});
	
	jQuery(".option-box div .header-bulb, .option-box div .option-bulb").click(function(){
		var thiselem = jQuery(this);
		var newsize = thiselem.attr("rel");
		thiselem.siblings().removeClass("active");
		thiselem.addClass("active");

		if(thiselem.parent().attr("alt") == "header-box"){
			if(newsize == "style-2"){
				jQuery(".header-flex").fadeOut(function(){
					jQuery(this).siblings(".header-center").fadeIn();
				});
			}else
			if(newsize == "style-1"){
				jQuery(".header-center").fadeOut(function(){
					jQuery(this).siblings(".header-flex").fadeIn();
				});
			}
		}

		return false;
	});

	var leavetime = '';
	
	jQuery(".demo-settings").mouseleave(function(){
		var thiselem = jQuery(this);
		leavetime = setTimeout(function(){
			thiselem.removeClass("active");
		}, 600);
		return false;
	});
	
	jQuery(".demo-settings").mouseover(function(){
		clearTimeout(leavetime);
		return false;
	});
	
	jQuery(".demo-settings .demo-button").click(function(){
		jQuery(".demo-settings").addClass("active");
		return false;
	});
});

