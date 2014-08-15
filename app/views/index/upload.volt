
<form action="index/upload" method="post" enctype="multipart/form-data" id="upload-form">
	{{ content() }}
	<label>Titel des Albums</label><br>
	<input type="text" name="titel" placeholder="Titel des Albums eingeben . . ."><br>
	<label>Bilder auswählen (max. 20 Bilder)</label><br>
	<input type="file" name="files[]" multiple><br>
	<input type="submit" value="Album Hochladen"><br>
	{{ space }}
</form>
<div id="resultLoading" style="display:none"><div><img src="public/img/icons/spinn.gif"><div>Upload der Bilder... Album wird erstellt...</div></div><div class="bg"></div></div>