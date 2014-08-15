<script type="text/javascript" src="public/js/jquery.lazy.min.js"></script>
<h2>Album auswählen</h2>
<div id="gallerie">
	{% for dir in dir_names %}
		<a href="index/gallery/{{ dir }}" class="gal-block" data-content="{{ dir }}">
			<img class="lazy" src="public/img/icons/placeholder_300x300.png" data-src="img/portfolio/{{ dir }}/thumbs/{{ images[loop.index0] }}">
		</a>
	{% endfor %}
	<div class="clear"></div>
</div>
{{ content() }}
<script>
	jQuery("div#gallerie a img.lazy").lazy({
		effect: "fadeIn", 
		effectTime: 1000,
		combined: true,
		delay: 15000,
		afterLoad: function(element) { // this will be called after the image is finally loaded 
			element.parent().addClass("after");
		},
	});

	$('#drop').css({"display" : "block"});
	
	var first = true;
	
	$('#drop img').mouseenter(function(){
		if (first){
			first = false;
			$('#drop img').animate({
				'margin-top' : '100px'
				}, 300, function() {
					$('#drop img').css({ 'margin-top' : '-100px' });
					$('#drop img').animate({
						'margin-top' : '-2px'
					}, 300);
				} 
			);
		} else {
			first = true;
		}
	});
	$('#drop div').click(function(){
		$("html, body").animate({ scrollTop: $(window).height()}, 800);
	    return false;
	});
	
	$('header').height($(window).height());
	$('#inner_header').css({"padding-top" : $(window).height()/3+"px", "height": $(window).height()-100-$(window).height()/3+'px'});
</script>