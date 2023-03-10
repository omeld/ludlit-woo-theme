$(document).ready(function() {

	$('p, div.wp-caption').has('img:not(.wp-smiley)').addClass('has-image');
	/*
    $('#myPostShowcase').cycle({
		fx: 'fade',
		pause: 1,
		//speed: 250,
		timeout: 2000,
		after: function() {
			//$('#mySlide').html(this.alt);
		}
	});
	*/

	$('.introduction').wrap('<div class="gray-4 introduction-wrapper stretch-full-width gray-background-not large-top-padding-not large-bottom-padding-not x-large-bottom-margin"></div>');
    
	/*$('.bwWrapper').BlackAndWhite({
    	hoverEffect : true, // default true
        webworkerPath : false
    });*/

	/*
	$(".hoverBox").css({opacity: 0.5});

	$(".hoverBox").mouseleave(function() {
		$(this).fadeTo("slow", 0.5);
	});
	$(".hoverBox").mouseenter(function() {
		$(this).fadeTo("fast", 1);
	});
	*/

	$(".widget_categories option").addClass("truncateThis");

	$(".truncateThis").truncate({
		width: '190',
		center: true,
		addtitle: false,
	});

	$("#myTitleSelect, #myAuthorSelect").css('display', 'block');

	$("#ns_widget_mailman_form-3 label").html('Vaš e-naslov: ');
	
	$(".single #ns_widget_mailman_form-3 label").html('');
	$(".single #ns_widget_mailman_form-3 input[type=text]").css('color', '#666');
	$(".single #ns_widget_mailman_form-3 input[type=text]").val('e-naslov za obveščevalnik');
	$(".single #ns_widget_mailman_form-3 input[type=text]").focus(function() {
		this.value = '';
	});

	$('select#cat option:first').html('Izberi rubriko ');


	var defaultValue = "Išči";

	//$("#s").addClass("rounded");

	$("#s").val(defaultValue);

	$("#s").focus(function() {
		if (this.value == defaultValue) {
			this.value = '';
		}
	});

	$("#s").blur(function() {
		if (this.value == '') {
			this.value = defaultValue;
		}
	});
	$("#ns_widget_mailman_form-2 label").hide();
	
	/*
	$(div.mySlide .mySlideDescriptionContainer).filter(function() {
		return ($(this).parent().css('display') == 'block');
	}).css
	 
	 */
	$("#events-list-widget-2 .dig-in a").attr("href","http://www.ludliteratura.si/dogodki/");

	/* fixed scroll floater */
	/*
	var e = "#fixedFloaterContainer";
	var e_top = $(e).offset().top;
	$(window).scroll(function(event) {
		if ($(window).scrollTop() >= e_top) {
			$(e).addClass('pin');
		} else {
			$(e).removeClass('pin');
		}
	});
	*/
	

	/*
	$('.touch-to-show').click(function() {
		if ($(this).hasClass('newlit-item-is-clicked')) {
			$(this).next('.show-when-touched').animate({ left: '-120%' });
		} else {
			$(this).next('.show-when-touched').animate({ left: '0%' });
		}
		$(this).toggleClass('newlit-item-is-clicked');
	});
	*/
	$('.touch-to-show').click(function() {
		$('html, body').toggleClass('no-scroll');
		$(this).parents('.show-when-touched').toggleClass('newlit-css-transition-hide newlit-css-transition-show');
	});
	/*
	 * prevent background scrolling on (ios?) mobile!
	 * the above works for all others …
	 */
	$('.no-scroll').live("touchmove", {}, function(event){
		event.preventDefault();
	});

	var showTextMore = false;
	$('.show-hide').click(function(e) {
		var thisButton = $(this);

		if (showTextMore === false) {
			showTextMore = thisButton.text();
		}
		var showTextLess = 'manj';
		var target = $(this).siblings('.show-on-request');
		if (target.length === 0) {
			target = $(this).parent().siblings('.show-on-request');
		}
		if (target.hasClass('hide')) {
			thisButton.text(showTextLess).toggleClass('expanded');
			target.css({display: 'block'}).animate({opacity: 1}, 500, function() {
				target.toggleClass('hide show');
			});

		} else {
			target.animate({opacity: 0}, 500, function() {
				target.css({display: 'none'}).toggleClass('hide show');
				thisButton.text(showTextMore).toggleClass('expanded');
			});
		}
	    e.preventDefault();	//prevent jumping/reloading with href #	
	});

	$(".interviewQuestion").css('marginLeft', function() {
		myInnerContainer = $(this).parents("#main-article-text");
		innerContainerWidth = myInnerContainer.outerWidth();
		innerContainerMargin = (myInnerContainer.outerWidth(true) - innerContainerWidth) / 2;
		return '-' + innerContainerMargin + 'px';

	});
	$("p").has(".span-make-blockquote").before(function() {

		myParent = $(this);
		myInnerContainer = $(this).parents("#main-article-text");
		myOuterContainer = $(this).parents(".content");

		parentWidth = myParent.outerWidth();
		innerContainerWidth = myInnerContainer.outerWidth();
		innerContainerMargin = (myInnerContainer.outerWidth(true) - innerContainerWidth) / 2;
		outerContainerWidth = myOuterContainer.outerWidth();
		outerContainerMargin = (myOuterContainer.outerWidth(true) - outerContainerWidth) / 2;
		
		margin = innerContainerMargin + outerContainerMargin;

		quote = $(this).children(".span-make-blockquote").text();
		quote = quote.substr(0,1).toUpperCase() + quote.substr(1);

		if (/[^\.\?\!«‹…]$/.test(quote)) {
			quote = quote + '.';
		}

		l = quote.trim().split(/\s+/).length;

		if ($(this).closest(".category-na-prvo-zogo").length) {
			fontSize = (l < 30 ? ' font-size-4 light ' : ' font-size-3 leading-tight');
			return("<blockquote style='margin-right: 2em;" + "margin-left: -" + margin +"px; float: left; width: 50%' class='newlit-generated-blockquote serif italic align-right blue medium-top-margin tiny-top-padding medium-bottom-margin" + fontSize + "'>" + quote + "</blockquote>");
		} else if ($(this).closest(".neke-vrste-intervju").length) {
			fontSize = (l < 30 ? ' font-size-4 light ' : ' font-size-3 leading-tight');
			return("<blockquote style='margin-right: 2em;" + "margin-left: -" + margin +"px; float: left; width: 50%' class='newlit-generated-blockquote serif italic align-right blue medium-top-margin tiny-top-padding medium-bottom-margin" + fontSize + "'>" + quote + "</blockquote>");
		} else if ($(this).closest(".category-intervju").length) {
			fontSize = (l < 30 ? ' font-size-4 light ' : ' font-size-3 leading-tight');
			return("<blockquote style='margin-right: 2em;" + "margin-left: -" + margin +"px; float: left; width: 50%' class='newlit-generated-blockquote serif italic align-right blue medium-top-margin tiny-top-padding medium-bottom-margin" + fontSize + "'>" + quote + "</blockquote>");
		} else if ($(this).closest(".category-izdano").length) {
			fontSize = (l < 30 ? ' font-size-4 light ' : ' font-size-3 leading-tight');
			return("<blockquote style='margin-right: 2em;" + "margin-left: -" + margin +"px; float: left; width: 50%' class='newlit-generated-blockquote serif italic align-right blue medium-top-margin tiny-top-padding medium-bottom-margin" + fontSize + "'>" + quote + "</blockquote>");
		} else {
			fontSize = (l < 30 ? ' font-size-5 light ' : ' font-size-4 leading-tight');
			return("<blockquote style='margin-right: -" + "0" + "px; margin-left: -" + margin +"px' class='newlit-generated-blockquote serif italic align-right blue medium-top-margin tiny-top-padding medium-bottom-margin" + fontSize + "'>" + quote + "</blockquote>");
		}
	});

	var down = false;
	var scrollLeft = 0;
	var x = 0;
	var scrollContainer = $('.image-stripe, .horizontal-scroll');
	$('.image-stripe img, .horizontal-scroll').on('dragstart', function(event){ event.preventDefault(); });

	scrollContainer.mousedown(function(e) {
		down = true;
		scrollLeft = this.scrollLeft;
		x = e.pageX;
	}).mouseup(function() {
		down = false;
	}).mousemove(function(e) {
		if (down) {
			this.scrollLeft = scrollLeft + x - e.pageX;
		}
	}).mouseleave(function() {
		down = false;
	});


	/* triangles */
	$(".has-triangle").each(function(i) {
		var trContainer = $(this).find('.triangle-outer')
		var trSibling = $(this).find('.triangle-inner')
		var tr = $(this).find(".triangle-inner");
		var trh = trContainer.outerHeight();

		if (i % 2 === 0) {
			var trw = trContainer.outerWidth() - trSibling.outerWidth() - parseInt(trContainer.css('padding-right').replace("px", ""));
		} else {
			var trw = trContainer.outerWidth() - trSibling.outerWidth() - parseInt(trContainer.css('padding-left').replace("px", ""));
		}
		var angle = Math.atan(trw / (trh / 2)) * 180 / Math.PI;
		var diagonal = Math.sqrt((trh / 2) * (trh / 2) + trw * trw);

		if (i % 2 === 0) {

			tr.append('<div class="triangle" style="left: ' + (trSibling.outerWidth() + parseInt(trContainer.css('padding-left').replace("px", "")) ) + 'px; width: ' + diagonal + 'px; height: ' + diagonal + 'px; top: 0; padding: 0; transform: rotate(-' + angle + 'deg)"></div>');
			tr.append('<div class="triangle" style="transform-origin: top right; right: ' + 0 + 'px; width: ' + diagonal + 'px; height: ' + diagonal + 'px; top: 50%; padding: 0; transform: rotate(-' + (90 - angle) + 'deg)"></div>');
		} else {
			tr.append('<div class="triangle" style="left: ' + trw + 'px; width: ' + diagonal + 'px; height: ' + diagonal + 'px; bottom: 50%; padding: 0; transform-origin: bottom right; transform: translateX(-100%) rotate(-' + angle + 'deg)"></div>');
			tr.append('<div class="triangle" style="left: ' + trw + 'px; width: ' + diagonal + 'px; height: ' + diagonal + 'px; top: 50%; padding: 0; transform-origin: top right; transform: translateX(-100%) rotate(' + angle + 'deg)"></div>');
		}
	});
	/* end triangles */

	/* begin sidenotes */
	function getOffsets(el) {
		$(el).each(function(i){
		myoffset = $(this).offset();
		myoffset.top = $(this).outerHeight(true);
		myexit = $(this).parent().find(".exit");
		myexit.css({
			"left": myoffset.left,
			"bottom": 'calc(1% + ' + myoffset.top + 'px)'
		});
		});
	}

	$(".text").each(function(i){
		myexit = $("<div class='exit'>&times;</div>");
		myelement = $(this);
		$(this).parent().prepend(myexit);
		getOffsets(myelement);
		myexit.click(function(e) {
			$(this).parent().removeClass("visible");
		})
	});

	$(".notelink").click(function(e){
		ref = $(this).attr("data-ref");
		$(".note").removeClass("visible");
		$("#" + ref).addClass("visible");
	});


	$(window).resize(function() {
		getOffsets($(".text"));
	});


	/* end sidenotes */

	/* begin equal height gallery */

	$(".fotogalerija.equal-height > a").has("img").each(function(i) {
		myimg = $(this).find("img");
		myh = myimg[0].naturalHeight;
		myw = myimg[0].naturalWidth;
		myratio = parseFloat(myw) / parseFloat(myh);
		myflex = myratio + " 1 0";
		$(this).css({
			"flex": myflex
		});
	});
	/* end equal height gallery */
	
});
