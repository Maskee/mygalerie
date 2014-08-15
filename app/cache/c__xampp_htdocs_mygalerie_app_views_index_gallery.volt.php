<script src="public/js/galleria/galleria-1.3.6.min.js" type="text/javascript"></script>
<script src="public/js/jquery-impromptu.min.js" type="text/javascript"></script>
<script type="text/javascript" src="public/js/jquery.lazy.min.js"></script>
<div id="gal-nav">
	<h2>Weitere Alben</h2>
	<div  id="gal-nav-images">
		<?php $v9175656751iterator = $dir_names; $v9175656751incr = 0; $v9175656751loop = new stdClass(); $v9175656751loop->length = count($v9175656751iterator); $v9175656751loop->index = 1; $v9175656751loop->index0 = 1; $v9175656751loop->revindex = $v9175656751loop->length; $v9175656751loop->revindex0 = $v9175656751loop->length - 1; ?><?php foreach ($v9175656751iterator as $dir) { ?><?php $v9175656751loop->first = ($v9175656751incr == 0); $v9175656751loop->index = $v9175656751incr + 1; $v9175656751loop->index0 = $v9175656751incr; $v9175656751loop->revindex = $v9175656751loop->length - $v9175656751incr; $v9175656751loop->revindex0 = $v9175656751loop->length - ($v9175656751incr + 1); $v9175656751loop->last = ($v9175656751incr == ($v9175656751loop->length - 1)); ?>
			<a href="images/gallery/<?php echo $dir; ?>" data-content="<?php echo $dir; ?>">
			 	<img class="lazy" src="public/img/icons/placeholder_300x300.png" data-src="img/portfolio/<?php echo $dir; ?>/thumbs/<?php echo $images_side[$v9175656751loop->index0]; ?>">
			</a>
		<?php $v9175656751incr++; } ?>
	</div>
</div>
<div id="gal-wrapper">
	<h2><?php echo $dir_name; ?></h2>
	<div class="galleria">
	    <?php $v9175656751iterator = $images; $v9175656751incr = 0; $v9175656751loop = new stdClass(); $v9175656751loop->length = count($v9175656751iterator); $v9175656751loop->index = 1; $v9175656751loop->index0 = 1; $v9175656751loop->revindex = $v9175656751loop->length; $v9175656751loop->revindex0 = $v9175656751loop->length - 1; ?><?php foreach ($v9175656751iterator as $image) { ?><?php $v9175656751loop->first = ($v9175656751incr == 0); $v9175656751loop->index = $v9175656751incr + 1; $v9175656751loop->index0 = $v9175656751incr; $v9175656751loop->revindex = $v9175656751loop->length - $v9175656751incr; $v9175656751loop->revindex0 = $v9175656751loop->length - ($v9175656751incr + 1); $v9175656751loop->last = ($v9175656751incr == ($v9175656751loop->length - 1)); ?>
				 <a href="img/portfolio/<?php echo $dir_name; ?>/thumbs_normal/<?php echo $image; ?>" >
				 	<img src="img/portfolio/<?php echo $dir_name; ?>/thumbs_small/<?php echo $image; ?>">
				</a>
		<?php $v9175656751incr++; } ?>
	</div>
	<a href="javascript:;" id="fullscreen_toggler"><img src="img/icons/appbar.fullscreen.png" title="Fullscreen"></a>
	<a  class="toggle" id="gal_add" href="images/add/<?php echo $dir_name; ?>"><img src="img/icons/appbar.layer.add.png" title="Add Images"></a>
	<a  class="toggle" id="gal_delete_img" href="images/delete/<?php echo $dir_name; ?>"><img src="img/icons/appbar.layer.delete.png" title="Delete Images"></a>
	<a  class="toggle" id="gal_delete" href="javascript:;"><img src="img/icons/appbar.delete.png" title="Delete Album"></a>
	<a  class="toggle" id="gal_download" href="javascript:;"><img src="img/icons/appbar.social.dropbox.download.png" title="Download"></a>
	<a  id="gal_options" href="javascript:;"><img src="img/icons/appbar.cog.png" title="Optionen"></a>
</div>
<?php echo $this->getContent(); ?>

<script>
	$("<link/>", {
	   rel: "stylesheet",
	   type: "text/css",
	   href: "public/css/jquery-impromptu.min.css"
	}).appendTo("head");

	$('#gal_delete').click(function(){

		var statesdemo1 = {
			state0: {
				title: 'Wollen Sie wirklich das gesamte Album Löschen?',
				buttons: { 'Löschen' : 1, 'Abbrechen': -1 },
				//focus: ":input:first",
				submit:function(e,v,m,f){ 
					if(v==1) window.location.href = "images/delete/<?php echo $dir_name; ?>/true";
					//if(v==-1);
					//e.preventDefault();
				}
			}
		};
		
		$.prompt(statesdemo1);
		
	});

	jQuery("div#gal-nav-images img.lazy").lazy({
		effect: "fadeIn", 
		effectTime: 1500,
		combined: true,
		delay: 15000,
		appendScroll: jQuery("div#gal-nav-images"),
		afterLoad: function(element) { // this will be called after the image is finally loaded 
			element.parent().addClass("after");
		},
	});
	
	setGalHeight();

	$( window ).resize(function() {
		setGalHeight();
	});
	
	$('#gal_options').click(function(){
		if(!$('#gal_options').hasClass('aktiviertx')){
			$('#gal_options').addClass('aktiviertx');
			$('#gal-wrapper .toggle').css({'display' : 'block'});
		}
		else{
			$('#gal_options').removeClass('aktiviertx');
			$('#gal-wrapper .toggle').css({'display' : 'none'});
		}
	});

	$('#gal_download').click(function(){

		var statesdemo = {
			state0: {
				title: 'Download Format auswählen:',
				html:	'<label><input type="radio" name="dl_format" value="1600x900"> 1600x900</label><br />'+
						'<label><input type="radio" name="dl_format" value="1200x750"> 1200x750</label><br>'+
						'<label><input type="radio" name="dl_format" value="550x300"> 550x300</label>',
				buttons: { 'Download' : 1, 'Abbrechen': -1 },
				//focus: ":input:first",
				submit:function(e,v,m,f){ 
					if(v==1) window.location.href = "images/download/<?php echo $dir_name; ?>/"+f.dl_format;
					//if(v==-1);
					//e.preventDefault();
				}
			}
		};
		
		$.prompt(statesdemo);
	});

	$('#fullscreen_toggler').click(function(){
		$('.galleria').data('galleria').enterFullscreen();
	});

    Galleria.loadTheme('public/js/galleria/themes/classic/galleria.classic.min.js');
    Galleria.run('.galleria', {
    	//imageCrop: 'landscape'
    });

    function setGalHeight(){
    	if($('header').height() < $(window).height()/2.5){
    		$('.galleria').height($(window).height()-$('header').height()-50);
    		$('#gal-nav-images').height($(window).height()-$('header').height()-50);
    	} else {
    		$('.galleria').height($(window).height()-70);
    		$('#gal-nav-images').height($(window).height()-70);
    	}
    }
</script>