;(function(window, document, $){
	// define main prperties
	window.x_path = "";
	window.x_append = "";
	window.x_array = new Array();
	window.x_tabs = new Array();
	window.x_left = 0;
	window.x_right = 0;
	window.x_width = 872;
	window.x_ts = new Array();
	window.x_temp = new Array();
	window.x_pics = new Array();
	window.x_timeon = true;
	
	// set default easing
	jQuery.easing.def = "easeOutSine";
	
	// set window listeners
	// lose focus - stop frames, on focus - continue looping
	if(window.addEventListener) {
		window.addEventListener('blur', stopFrames);
		window.addEventListener('focus', continueFrames);
	}
	else {
		window.attachEvent('onblur', stopFrames);
		window.attachEvent('onfocus', continueFrames);
	}
	
	// continue loop on window focus
	function continueFrames() {
		if(window.x_timeon == true) {
			var cap = $('.x_caption').filter('.active');
			var par = $(cap).parent();
			var pages = $('.x_pages', par);
			var but = $('.but', pages).filter('.active');
			restartClock();
			loopFrames(but, pages);
		}
	}
	
	// restart clock gif image
	function restartClock() {
		var el = $('.x_clock');
		el.attr('src', '');
		el.attr('src', window.x_ppa+'images/clock1.gif');
	}
	
	// loop through frames
	function loopFrames(element, pages) {
		window.x_element = element;
		window.x_pages = pages;
		window.clearTimeout(window.x_timeout);
		window.x_timeout=window.setTimeout("clock(window.x_element, window.x_pages)", 5000);
	}
	
	// function that manages frames looping
	function clock(el, p) {
		restartClock();
		if(el.prev().length !=0) {
			window.x_element = $(el, p).prev();
			window.x_element.click();
			console.log('huy');
		}
		else {
			window.x_element = el.parent().find('.but').last();
			window.x_element.click();
			console.log('nah');
		}
	}
	
	// stop frames looping
	function stopFrames() {
		window.clearTimeout(window.x_timeout);
	}
	
		// apply gallery settings
	function applySettings() {
		$('.x_caption').css({'font-size': window.x_settings.titleSize+'px', color: '#'+window.x_settings.tabColor, 'background-color': '#'+window.x_settings.tabBack});
		$('h3', '.x_text').css({'font-size': window.x_settings.titleSize+'px', color: '#'+window.x_settings.titleColor});
		$('p', '.x_text').css({'font-size': window.x_settings.descSize+'px', color: '#'+window.x_settings.descColor});
		$('.but', '.x_pages').css({'width': window.x_settings.butWidth+'px', 'height': window.x_settings.butHeight+'px','background-color': '#'+window.x_settings.butColor});
		$('.but', '.x_pages').live('mouseenter', function() {
			$(this).css({'background-color': '#'+window.x_settings.butColorHover});
		});
		
		$('.but', '.x_pages').live('mouseleave', function() {
			if(!$(this).hasClass('active'))
			$(this).css({'background-color': '#'+window.x_settings.butColor});
		});
		//Pause event
		$('.x_clock', '.x_pages').live('mouseenter', function() {			
			var playiconmatch = $(this).attr('src').match(/clock_pause.png/i);//alert(playiconmatch);
			if(!playiconmatch)
				$(this).attr('src', window.x_ppa+'images/pause.png');
			//$(this).css({'background-color': '#'+window.x_settings.butColorHover});
		});
		$('.x_clock', '.x_pages').live('mouseleave', function() {
			var playiconmatch = $(this).attr('src').match(/clock_pause.png/i);//alert(playiconmatch);
			if(!playiconmatch)
			$(this).attr('src', window.x_ppa+'images/clock1.gif');
		});
		
	}
	
	// create caption images on the server-side
	function createCaptions(array) {
		var i=0;
		$('.x_caption').each(function() {
			$(this).append('<h3>'+array[i]+'</h3>');
			i++;
		});
	}
	
	// delete the old tag if it exists
	function removePriceTag(li) {
		var oldTag = $('.x_pricetag', li);
		if(oldTag.length != 0) {
			oldTag.remove();
		}
	}
	
	// add a price tag
	function addPriceTag(li, pb, pa) {
		removePriceTag();
		var html = '<div class="x_pricetag" style="'+
					'width: '+ window.x_pricetag.width +'px;'+
					'height: '+ window.x_pricetag.height +'px;'+
					'left: '+ window.x_pricetag.x +'px;'+
					'top: '+ window.x_pricetag.x +'px;">'+
					'<img src="'+ window.x_pricetag.image +
					'" style="width: '+ window.x_pricetag.width +'px; height: '+ window.x_pricetag.height +'px;"/>'+
					'<span class="x_before">'+ window.x_pricetag.symbol + pb +'</span>'+
					'<span class="x_after">'+ window.x_pricetag.symbol + pa +'</span></div>';
		li.append(html);
		return false;
	}
	   
	// preload images
	// preload first images for all categories
	function preloadImages() {
		var last_cat = window.x_array[0][0].replace(/(\r\n|\n|\r)/gm,"");
		var temp_cat ="";
		var temp_img = new Image();
		var t = 0;
		for(var i=0; i<window.x_array.length; i++) {
			last_cat = window.x_array[i][0].replace(/(\r\n|\n|\r)/gm,"");
			if(temp_cat != last_cat) {
				temp_cat = last_cat;
				temp_img.src = window.x_array[i][1].replace(/(\r\n|\n|\r)/gm,"");
				window.x_temp[t] = window.x_array[i][1].replace(/(\r\n|\n|\r)/gm,"");
				t++;
			}
		}
	}
	
	// load image src
	function loadImage(element, j, k) {
		var par = element.parent().parent();
		var pages = $('.x_pages', par);
		var img = $('img.img', par);
		var x_text = $('.x_text', par);
		var h3 = $('h3', x_text);
		var p = $('p', x_text);
		var rand = Math.floor(Math.random()*1001);
		img.after('<img class="img tx'+rand+'" src="">');
		
		// fade out previous image and text
		img.fadeOut(500);
		h3.fadeOut(250, function() {
			h3.text(window.x_pics[j][k][2].replace(/(\r\n|\n|\r)/gm,""));
			h3.fadeIn(500);
		});
		p.fadeOut(250, function() {
			p.text(window.x_pics[j][k][3].replace(/(\r\n|\n|\r)/gm,""));
			p.fadeIn(500);
		});
		var new_img = $('.tx'+rand);
		var new_src = window.x_pics[j][k][1].replace(/(\r\n|\n|\r)/gm,"");
		new_src = window.x_pics[j][k][1].replace(/(\r\n|\n|\r)/gm,"");
		new_img.attr('src', new_src);
		new_img.hide();
		// stop the clock image (show first frame)
		if(window.x_timeon == true) {
			$('.x_clock').attr('src', window.x_ppa+'images/clock_frame.png');
		}
		$(new_img).load(function() {
			// start looping frames
			if(window.x_timeon == true) {
				loopFrames(element, pages);
				restartClock();
			}
			// update and fadein
			new_img.fadeIn(500, function() {
				// remove previous image
				img.remove();
			});
		});
	}

	// get pricetag image from  parsed xml
	function getPricetagImage(str) {
		var result = str.match(/http\:\/\/{0,1}[a-zA-Z0-9_\-\/\.]*/, '');
		return result;
	}
	
	// find first image
	function findFirstImg(tabname) {
		for(var i=0; i<window.x_array.length; i++) {
			var x_reg = window.x_array[i][0].replace(/(\r\n|\n|\r)/gm,"");
			var x_tb = tabname.replace(/(\r\n|\n|\r)/gm,"");
			if(x_reg == x_tb)
				return window.x_array[i][1].replace(/(\r\n|\n|\r)/gm,"");
		}
	}
	
	// slide tabs
	function slide(el) {
		
		
		// get element id
		var gid = parseInt(el.attr('id')) - 1;
		//define which blocks to move
		var tempArray = new Array();
		// SLIDE LEFT
		if(window.x_ts[gid] == 0) {
			for(var i=window.x_tabs.length-1; i>gid; i--) {
				if(window.x_ts[i] == 0) {
					window.x_ts[i] = 1;
					gel = '#'+(i+1)+'xt';
					var par = $(gel).parent('li');
					//par.animate({left: (window.x_width-window.x_right-42)+'px'});
					//alert(window.x_settings.gallery_width);
					par.animate({left: (window.x_settings.gallery_width-window.x_right-42)+'px'});
					if(i == gid+1) {
						$('.x_caption').removeClass('last_right');
						$(gel).addClass('last_right');
					}
					window.x_right += 42;
					window.x_left -= 42;
										
				}
			}
		}
		// SLIDE RIGHT
		else{
			for(var i=0; i<=gid; i++) {
				if(window.x_ts[i] == 1) {
					window.x_ts[i] = 0;
					gel = '#'+(i+1)+'xt';
					var par = $(gel).parent('li');
					//par.animate({left: (window.x_settings.gallery_width-window.x_left)+'px'});
					par.animate({left: (window.x_left)+'px'});
					$('.x_caption').removeClass('last_right');
					$('#'+(i+2)+'xt').addClass('last_right');
					window.x_right -= 42;
					window.x_left += 42;
				}
			}
		}
		return false;
	}

	$(document).ready(function() {
		// PAGE CLICK
		$('.x_pages .but').live('click', function() {
			$('.x_pages .but').css({'background-color': '#'+window.x_settings.butColor});
			$(this).css({'background-color': '#'+window.x_settings.butColorHover});
			stopFrames();
			var par = $(this).parent().parent();
			var _j = parseInt($('.x_caption', par).attr('id')) - 1;
			var _k = parseInt($(this).attr('id')) - 1;
			// add a pricetag
			var pb = window.x_pics[_j][_k][4][0];
			var pa = window.x_pics[_j][_k][4][1];
			if((!isNaN(pb))&&(!isNaN(pa)))
				addPriceTag(par, pb, pa);
			else
				removePriceTag();
			// generate click - load image, etc.
			if(!$(this).hasClass('active')) {
				$('.but', par).removeClass('active');
				$(this).addClass('active');
				
				loadImage($(this), _j, _k);				
			}
			else {
				stopFrames();
				// start looping frames
				if(window.x_timeon == true) {
					loopFrames($(this), par);
					restartClock();
				}
			}
			return false;
		});
		
		// TIMER CLICK
		$('.x_clock').live('click', function() {
			if(window.x_timeon == true) {
				stopFrames();
				window.x_timeon = false;
				$('.x_clock').attr('src', window.x_ppa+'images/clock_pause.png');
			}
			else {
				window.x_timeon = true;
				var par = $(this).parent();
				var but = $('.but', par).filter('.active');
				but.click();
				$('.x_clock').attr('src', window.x_ppa+'images/clock1.gif');
			}
		});
		
		// get xml location
		window.x_xmlpath = $('.x_gallery').attr('data-xml');
	
		// LOAD XML
		$.ajax({
			url: window.x_xmlpath,
			type: 'GET',
			dataType: 'text',
			timeout: 5000,
			error: function(){
				alert('Error loading XML document');
			},
			success: function(xml){
				// hide cover
				$('.x_cover').fadeOut(500, function() {
					$(this).remove();
				});
				// PARSE XML
				var xmlDoc = $.parseXML( xml ),
					$xml = $( xmlDoc );
					
				window.x_settings = {};
				// parse settings
				window.x_settings.titleSize = parseInt($('title_size', $xml).text());
				window.x_settings.titleColor = $('title_color', $xml).text().replace(/(\r\n|\n|\r)/gm,"");
				window.x_settings.descSize = parseInt($('description_size', $xml).text());
				window.x_settings.descColor = $('description_color', $xml).text().replace(/(\r\n|\n|\r)/gm,"");
				window.x_settings.autoPlay = $('auto_play', $xml).text().replace(/(\r\n|\n|\r)/gm,"");
				
				//gallery width and height
				window.x_settings.gallery_width = parseInt($('gallery_width', $xml).text());
				window.x_settings.gallery_height = parseInt($('gallery_height', $xml).text());				
				
				// tab settings
				var tab = $('tab', $xml);
				window.x_settings.tabColor = $('text_color', tab).text().replace(/(\r\n|\n|\r)/gm,"");
				window.x_settings.tabBack = $('background_color', tab).text().replace(/(\r\n|\n|\r)/gm,"");
				window.x_settings.tabBackHover = $('background_color_over', tab).text().replace(/(\r\n|\n|\r)/gm,"");
				// button settings
				var controls = $('controls', $xml);
				window.x_settings.butShow = $('show', $xml).text().replace(/(\r\n|\n|\r)/gm,"");
				window.x_settings.butWidth = parseInt($('button_width', $xml).text());
				window.x_settings.butHeight = parseInt($('button_height', $xml).text());
				window.x_settings.butColor = $('button_color', $xml).text().replace(/(\r\n|\n|\r)/gm,"");
				window.x_settings.butColorHover = $('button_color_over', $xml).text().replace(/(\r\n|\n|\r)/gm,"");
				
				
				var tabs = $('tabs', $xml);
				// get the pricetag image
				var pricetag = $('price', $xml).first();
				window.x_pricetag = {};
				window.x_pricetag.x = parseInt($('x', pricetag).text());
				window.x_pricetag.y = parseInt($('y', pricetag).text());
				window.x_pricetag.width = parseInt($('width', pricetag).text());
				window.x_pricetag.height = parseInt($('height', pricetag).text());
				window.x_pricetag.symbol = $('symbol', pricetag).text();
				window.x_pricetag.image = getPricetagImage($(pricetag).text());

				//alert($('tab', tabs).length);
				var j = 0, k = 0;
				// create captions for categories
				// and fill the pictures array
				$($('tab', tabs).get().reverse()).each(function() {
					var element = $('element', this);
					var first_element = element[0];
					// append each tab and increase left
					var ap_class ="";
					if($(this).is(':first-child')) {
						ap_class="active";
					}
					if($('link', first_element).text() == ''){
					window.x_append += '<li style="left: '+(j*42)+'px;" ><div id="'+(j+1)+'xt" class="x_caption '+ap_class+'">'+
									   '</div><img class="img" src="'+$('picture', first_element).text()+'"/>';
					} else {
						window.x_append += '<li style="left: '+(j*42)+'px;" ><div id="'+(j+1)+'xt" class="x_caption '+ap_class+'">'+
									   '</div><a href="'+$('link', first_element).text()+'" target="_self"><img class="img" src="'+$('picture', first_element).text()+'"/></a>';
					}
					if(window.x_settings.butShow == 'true' && window.x_settings.autoPlay == 'true'){				   
						window.x_append +='<div class="x_pages">';
						for(var i=$('element', this).length-1; i>=0; i--) {
							var apc = "";
							if(i==0) {
								apc = "active";
							}
							window.x_append += '<span class="but '+apc+'" id="'+(i+1)+'xp"></span>'
						}
						window.x_append += '<img class="x_clock" src="'+window.x_ppa+'images/clock1.gif"/></div>';
					}else if(window.x_settings.butShow != "true" && window.x_settings.autoPlay == "true"){
						window.x_append +='<div class="x_pages" style="visibility:hidden;">';
						for(var i=$('element', this).length-1; i>=0; i--) {
							var apc = "";
							if(i==0) {
								apc = "active";
							}
							window.x_append += '<span class="but '+apc+'" id="'+(i+1)+'xp"></span>'
						}
						window.x_append += '<img class="x_clock" src="'+window.x_ppa+'images/clock1.gif"/></div>';
					}
					
					
					window.x_append += '<div class="x_text" test="'+window.x_settings.butShow+'">'+
										'<h3>'+$('title', first_element).text()+'</h3>'+
										'<p>'+$('description', first_element).text()+'</p>'+
										'</div><img src="'+window.x_ppa+'images/loading.gif" class="x_loading"/>';
					window.x_tabs[j] = $('name', this).text();
					window.x_pics[j] = [window.x_tabs[j]];
					var k = 0;
					element.each(function() {
						var price = $('price', this);
						window.x_array[j, k] = [window.x_tabs[j],
												$('picture',this).text(),
												$('title',this).text(),
												$('description',this).text(),
												[parseInt($('regular', price).text()), parseInt($('updated', price).text())]];
						window.x_pics[j][k] = window.x_array[j, k];
						k++;
					});
					window.x_append += '</li>';
					j++;
				});
				// append all slides (tabs)
				$('ul', '.x_gallery').append(window.x_append);
				// preload first images of categories
				preloadImages();
				// create captions
				createCaptions(window.x_tabs);
				// set starting left width (all tabs)
				window.x_left = j*42;
				for(var i=0; i<window.x_tabs.length; i++) {
					window.x_ts[i] = 0;
				}
				// start timer loop
				var par = $('li', '.x_gallery').last();
				var pages = $('.x_pages', par);
				var firstBut = $('.but', pages).filter('.active');
				// check if we need to loop in xml
				if(window.x_settings.autoPlay == "true")
					firstBut.click();
				else
					stopFrames();
				// apply gallery settings
				applySettings();
				$(".x_pages").css({'right': ((j*42)-56) + 'px'});
				$('.x_caption').hover(function() {
					if(!$(this).hasClass('active')) {
						$('.x_caption').css({'background-color': '#'+window.x_settings.tabBack});
						$(this).css({'background-color': '#'+window.x_settings.tabBackHover});
						stopFrames();
						if(window.x_timeon == true)
							restartClock();
						var par = $(this).parent();
						var but = $('.but', par).filter('.active');
						var pages = $('.x_pages', par);
						var butFirst = $('.but', par).last();
						$('.x_caption').removeClass('active');
						$(this).addClass('active');
						slide($(this));
						butFirst.click();
					}
					return false;
				});
				//change wudth each element
				var widthGallery = $('.x_gallery ul').width();
				var widthTitle = $('.x_gallery ul .x_caption').width();
				var TwidthTitle = $('.x_gallery ul .x_caption').width()*(j-1);
				//$('.x_gallery li').css('width',(widthGallery-TwidthTitle)+'px');
				$('.x_gallery li').css('width',window.x_settings.gallery_width+'px');
				$('.x_gallery li').css('height',window.x_settings.gallery_height+'px');
				slide($('#'+j+'xt'));
				$('#'+j+'xt').css({'background-color': '#'+window.x_settings.tabBackHover});
			}
		});
	});

})(window, document, jQuery);