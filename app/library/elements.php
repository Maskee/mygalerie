<?php

use Phalcon\Mvc\User\Component;

class Elements extends Component
{

    public function getLogin()
    {
	    $auth = $this->session->get('auth');
	    $html = "";
		if (!$auth){
			$html .= '<form id="login_form" action="index/login">';
			$html .= '<lable>Login:</lable><br>';
			$html .= '<input type="text" name="name" placeholder="Benutzername"><br>';
			$html .= '<input type="text" name="name" placeholder="Passwort">';
			$html .= '</form>';
		} else {
			$html .= "";
		}
		return $html;
    }
    
    public function getLoggedInAs()
    {
    	$auth = $this->session->get('auth');
    	$html = "";
    	if (!$auth){
    		//$html .= 'Willkommen Gast';
    	} else {
    		$html .= 'Willkommen '.$auth['name'];
    	}
    	return $html;
    }

    public function getOptions()
    {
        $auth = $this->session->get('auth');
	    $html = "";
		if (!$auth){
			$html .= '<li><a href="images">Startseite-Archiv</a></li>';
			$html .= '<li><a href="index/login">Login</a></li>';
		} else {
			$html .= '<li><a href="images">Startseite-Archiv</a></li>';
			$html .= '<li><a href="index/logout">Logout</a></li>';
			$html .= '<li><a href="index/upload">Neues Album</a></li>';
			$html .= '<li><a href="index/signup">Neuer Benuter</a></li>';
		}
		return $html;
    }

}

?>