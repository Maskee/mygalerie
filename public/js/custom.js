jQuery(function($) {
	var $cache = $('#sticker');
	var $toggler = $('#toggler');
	$toggler.html($cache.html());
	
	function fixDiv() {
		if ($(window).scrollTop() > 50){ 
			$cache.css({'display':'none'});
			$toggler.css({'display':'block'});
		} 
		else {
			$cache.css({'display':'block'});
			$toggler.css({'display':'none'});
		}  
	}
	$(window).scroll(fixDiv);
	fixDiv();
	
});

$('#options').click(function(){
	if(!$(this).hasClass('aktiviertx')){
		$(this).addClass('aktiviertx');
		$('#options_menu li').addClass('aktiviert');
		$(this).css({"background-color" : "white"});

	}
	else{
		$(this).removeClass('aktiviertx');
		$('#options_menu li').removeClass('aktiviert');
		$(this).css({"background-color" : "grey"});
	}
});

// ######## Less.je #############
less = {
        env: "development", // or "production"
        async: false,       // load imports async
        fileAsync: false,   // load imports async when in a page under
                            // a file protocol
        poll: 1000,         // when in watch mode, time in ms between polls
        functions: {},      // user functions, keyed by name
        dumpLineNumbers: "comments", // or "mediaQuery" or "all"
        relativeUrls: false,// whether to adjust url's to be relative
                            // if false, url's are already relative to the
                            // entry less file
        rootpath: ":/a.com/"// a path to add on to the start of every url
                            //resource
    };

$(document).ready(function() {
	if($('.box_skitter_large').length > 0){
		
		$(".box_skitter_large").skitter({
			interval: 4000,
			labelAnimation: 'left',
			theme: 'default',
			dots: true, 
			preview: true,
			numbers_align: 'center',
			navigation: false
		});
		
	}
	if($('#haftaus').length > 0){
		$('#haftaus').css({"display" : "none"});
	}
	
	
	$('#upload-form').submit(function(){
		ajaxindicatorstart('Daten werden übertragen...');
	});
	
});

function toggle(){
	if($('#haftaus').css('display') == "none"){
		$('#haftaus').css({"display" : "block"});
	} else {
		$('#haftaus').css({"display" : "none"});
	}
}

function ajaxindicatorstart(text){
	if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
	jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="public/img/icons/spinn.gif"><div>'+text+'</div></div><div class="bg"></div></div>');
	}
	
	window.scrollTo(0,0);
	$('body').addClass('stop-scrolling');
	
	jQuery('#resultLoading').css({
		'width':'100%',
		'height':'100%',
		'position':'absolute',
		'z-index':'10000000',
		'top':'expression(this.offsetParent.scrollTop-1);',
		'left':'0',
		'right':'0',
		'bottom':'0',
		'margin':'auto'
	});

	jQuery('#resultLoading .bg').css({
		'background':'#000000',
		'opacity':'0.7',
		'width':'100%',
		'height':'100%',
		'position':'absolute',
		'top':'0'
	});
	
	if($(window).width() < 440)
		width = $(window).width()-40;
	else 
		width = "430";
	
	jQuery('#resultLoading>div:first').css({
		'width': width+'px',
		'height':'75px',
		'text-align': 'center',
		'position': 'absolute',
		'top':'0',
		'left':'0',
		'right':'0',
		'bottom':'0',
		'margin':'auto',
		'font-size':'24px',
		'z-index':'10',
		'color':'white'

	});

    jQuery('#resultLoading .bg').height('100%');
       jQuery('#resultLoading').fadeIn(300);
    jQuery('body').css('cursor', 'wait');
}
function ajaxindicatorstop(){
    jQuery('#resultLoading .bg').height('100%');
       jQuery('#resultLoading').fadeOut(300);
    jQuery('body').css('cursor', 'default');
}

