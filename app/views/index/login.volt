<div id="content-body">
	<form method="post" id="signup_form">
	<div id="note" style="">{{ content() }}</div>
	<h2>Login</h2>
	    <p>
	        <label>Name:</label><br>
	        <?php echo $form->render("name") ?><br>
	        <label>Passwort:</label><br>
	        <?php echo $form->render("passwort") ?><br>
	        <label></label><input type="submit" value="Einloggen" />
	    </p>
	</form>
</div>