
<form action="index/add/{{ album }}" method="post" enctype="multipart/form-data" id="upload-form">
	{{ content() }}
	<label>{{ album }}</label><br><br>
	<label>Bilder auswählen (max. 20 Bilder)</label><br>
	<input type="file" name="files[]" multiple><br>
	<input type="submit" value="Album Hochladen"><br>
	{{ space }}
</form>
<div id="resultLoading" style="display:none"><div><img src="public/img/icons/spinn.gif"><div>Upload der Bilder... Album wird erweitert...</div></div><div class="bg"></div></div>