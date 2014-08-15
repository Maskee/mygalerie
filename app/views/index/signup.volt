<div id="content-body">
	<h2>Anmeldeformular</h2>
	<form method="post" id="signup_form">
	    <div id="note" style="">{{ content() }}</div>
	    <p>
	        <label>Name:</label><br>
	        <?php echo $form->render("name") ?><br>
	        <label>Passwort:</label><br>
	        <?php echo $form->render("passwort") ?><br>
	        <label></label><input type="submit" value="Registrieren" />
	    </p>
	</form>
</div>