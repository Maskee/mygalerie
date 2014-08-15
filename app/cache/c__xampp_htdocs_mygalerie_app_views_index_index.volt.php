<script type="text/javascript" src="public/js/jquery.lazy.min.js"></script>
<h2>Album auswählen</h2>
<div id="gallerie">
	<?php $v25462905791iterator = $dir_names; $v25462905791incr = 0; $v25462905791loop = new stdClass(); $v25462905791loop->length = count($v25462905791iterator); $v25462905791loop->index = 1; $v25462905791loop->index0 = 1; $v25462905791loop->revindex = $v25462905791loop->length; $v25462905791loop->revindex0 = $v25462905791loop->length - 1; ?><?php foreach ($v25462905791iterator as $dir) { ?><?php $v25462905791loop->first = ($v25462905791incr == 0); $v25462905791loop->index = $v25462905791incr + 1; $v25462905791loop->index0 = $v25462905791incr; $v25462905791loop->revindex = $v25462905791loop->length - $v25462905791incr; $v25462905791loop->revindex0 = $v25462905791loop->length - ($v25462905791incr + 1); $v25462905791loop->last = ($v25462905791incr == ($v25462905791loop->length - 1)); ?>
		<a href="index/gallery/<?php echo $dir; ?>" class="gal-block" data-content="<?php echo $dir; ?>">
			<img class="lazy" src="public/img/icons/placeholder_300x300.png" data-src="img/portfolio/<?php echo $dir; ?>/thumbs/<?php echo $images[$v25462905791loop->index0]; ?>">
		</a>
	<?php $v25462905791incr++; } ?>
	<div class="clear"></div>
</div>
<?php echo $this->getContent(); ?>
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