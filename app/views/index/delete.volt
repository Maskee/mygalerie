{{ content() }}
<form id="delete_form" action="index/delete/{{ dir_name }}" method="post">
	<h2>Bilder aus <a href="index/gallery/{{ dir_name }}">{{ dir_name }}</a> löschen</h2>
	{% for image in images %}
		<div>
			<input type="checkbox" name="del_images[]" value="{{ image }}">
			<img src="img/portfolio/{{ dir_name }}/thumbs/{{ image }}">
		</div>
	{% endfor %}
	<input type="submit" value="Bilder löschen">
	<div style="float:none; height:0px;" class="clear"></div>
</form>
<script>
	$('#delete_form > div > img').click(function(){
		$(this).prev().click();

		if($(this).prev().is(':checked')){
			$(this).parent().addClass('selected');
		} else {
			$(this).parent().removeClass('selected');
		}
	});

	$('#delete_form > div > input').click(function(){
		if($(this).is(':checked')){
			$(this).parent().addClass('selected');
		} else {
			$(this).parent().removeClass('selected');
		}
	});
</script>