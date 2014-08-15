<?php
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\Password,
Phalcon\Forms\Element\Textarea,
Phalcon\Validation\Validator\PresenceOf;

class IndexController extends ControllerBase
{
	public function initialize()
	{
		//$this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_LAYOUT);
    }
    
    private function _registerSession($user)
    {
    	$this->session->set('auth', array(
    			'name' => $user->name
    	));
    }
	
    public function indexAction()
    {
    	$start_dir = dirname(__FILE__)."/../../public/img/portfolio";

    	$dirs = array_filter(glob($start_dir.'/*'), 'is_dir');
    	
    	$dir_names = array();
    	$images = array();
    	
    	foreach ($dirs as $dir){
    		$files = glob($dir.'/*');
    		$dir_name = basename($dir);
			array_push($dir_names, $dir_name);
    		foreach($files as $file){
    			$file = basename($file);
    			if(is_file($dir.'/'.$file)){
	    			if(is_image($start_dir.'/'.$dir_name.'/thumbs/'.$file)){
	    				array_push($images, $file);
	    				break;
	    			}
    			}
    		}
    	}
    	$this->view->setVar("dir_names", $dir_names);
    	$this->view->setVar("images", $images);
    }
    
    public function galleryAction($dir_name){
    	
    	$start_dir = dirname(__FILE__)."/../../public/img/portfolio";
    	$dir = $start_dir.'/'.$dir_name;
    	
    	$images = array();
    	$files = scandir($dir);

    	foreach($files as $file){
    		if(is_file($dir.'/'.$file)){
    			if(is_image($start_dir.'/'.$dir_name.'/'.$file)){
    					array_push($images, $file);
    			}
    		}
    	}
    	
    	$this->view->setVar("images", $images);
    	$this->view->setVar("dir_name", $dir_name);
    	
    	// Bilder für Naviagtion and der Seite holen
    	$dirs = array_filter(glob($start_dir.'/*'), 'is_dir');
    	 
    	$dir_names = array();
    	$images = array();
    	 
    	foreach ($dirs as $dir){
    		$dir_nameX = basename($dir);
    		if($dir_name != $dir_nameX){
	    		$files = glob($dir.'/*');
	    		array_push($dir_names, $dir_nameX);
	    		foreach($files as $file){
	    			$file = basename($file);
	    			if(is_file($dir.'/'.$file)){
	    				if(is_image($start_dir.'/'.$dir_nameX.'/thumbs/'.$file)){
	    					array_push($images, $file);
	    					break;
	    				}
	    			}
	    		}
    		}
    	}
    	$this->view->setVar("dir_names", $dir_names);
    	$this->view->setVar("images_side", $images);
    	
    }
    
    public function resizeAction($dir_name = False){
    	error_reporting(E_ALL);
    	if($dir_name){
    		echo "<br><h3>Thumbs erstellen des Album: ".$dir_name."</h3>";
	    	resizeDir($dir_name);
	    			
	    } else {
    		echo "<h3>Kein Verzeichnis angegeben!</h3>";
    	}
    	
    }
    
    
    public function uploadAction(){
    	
    	set_time_limit(600); // 10 Minuten
    	error_reporting(E_ALL);
    	
    	$bytes = disk_free_space("/");
	    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
	    $base = 1024;
	    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
	    $space = 'Freier Speicher: '.sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '<br />';
	    $this->view->setVar("space", $space);
	    
    	if($this->request->isPost() == true){
    	
	    	$dir = dirname(__FILE__).'/../../public/img/portfolio/';
	    	
	    	$filter = new Phalcon\Filter();
	    	
	    	$titel = $filter->sanitize($this->request->getPost("titel"), 'string');
	    	
	    	if (!file_exists($dir.'/'.$titel)) {
	    	
		    	#check if there is any file
		    	if($this->request->hasFiles() == true){
		    		
		    		mkdir($dir.'/'.$titel, 0777, true);
		    		
		    		$uploads = $this->request->getUploadedFiles();
		    		$isUploaded = false;
		    		$i = 1;
		    		#do a loop to handle each file individually
		    		foreach($uploads as $upload){
		    			#define a "unique" name and a path to where our file must go
		    			$path = $dir.'/'.$titel.'/'.$i.'-'.strtolower($upload->getname());
		    			$i++;
		    			#move the file and simultaneously check if everything was ok
		    			($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
		    		}
		    		#if any file couldn't be moved, then throw an message
		    		if($isUploaded){
		    			resizeDir($titel);
		    			echo '<div id="infobox"><a href="images/gallery/'.$titel.'">Album</a> erfolgreich hochgeladen!</div>';
		    		} else { 
		    			echo '<div id="infobox">Fehler beim Upload eines Bild.</div>';
		    		}
		    	} else {
		    		#if no files were sent, throw a message warning user
		    		echo '<div id="infobox">Bitte mindestens eine Datei auswählen!</div>';
		    	}
	    	} else {
	    		echo '<div id="infobox" style="background-color:tomato;">Titel Bereits vorhanden!</div>';
	    	}
    	}
    }
    
    public function addAction($album){
    	
    	$this->view->setVar("album", $album);
    	 
    	set_time_limit(180);
    	 
    	$bytes = disk_free_space("/");
    	$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    	$base = 1024;
    	$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
    	$space = 'Freier Speicher: '.sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '<br />';
    	$this->view->setVar("space", $space);
    	 
    	if($this->request->isPost() == true){
    		 
    		$dir = dirname(__FILE__).'/../../public/img/portfolio/';
    
    		$titel = $album;
    		
    		$files = scandir($dir.'/'.$titel);
    		
    		$i = count($files)-4;
    		
			#check if there is any file
    		if($this->request->hasFiles() == true){
   
    			$uploads = $this->request->getUploadedFiles();
    			$isUploaded = false;
    			
    			#do a loop to handle each file individually
    			foreach($uploads as $upload){
    				#define a "unique" name and a path to where our file must go
    				$path = $dir.'/'.$titel.'/'.$i.'-'.strtolower($upload->getname());
    				$i++;
    				#move the file and simultaneously check if everything was ok
    				($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
    			}
    			#if any file couldn't be moved, then throw an message
    			if($isUploaded){
    			resizeDir($titel);
    			echo '<div id="infobox"><a href="images/gallery/'.$titel.'">Bilder</a> erfolgreich hinzugefügt!</div>';
    			} else {
		    		echo '<div id="infobox">Fehler beim Upload eines Bildes.</div>';
		    	}
   			} else {
   				#if no files were sent, throw a message warning user
	    		echo '<div id="infobox">Bitte mindestens eine Datei auswählen!</div>';
   			}
    	}
    }
    
    public function deleteAction($dir_name = False, $delete_all = false){
    	
    	$dir = dirname(__FILE__)."/../../public/img/portfolio/".$dir_name;
    	$images = array();
    	$this->view->setVar("dir_name", $dir_name);
    	
    	if(file_exists($dir) && !$delete_all){
	    	 
	   		$files = glob($dir.'/*');
	   		
	   		foreach($files as $file){
	   			$file = basename($file);
	   			if(is_file($dir.'/'.$file)){
	   				if(is_image($dir.'/thumbs/'.$file)){
	   					array_push($images, $file);
	   				}
	   			}
	   		}
	    	
	    	if($this->request->isPost() == true){
	    		
	    		$del_images = $this->request->getPost("del_images");
	
		    	$dir = dirname(__FILE__).'/../../public/img/portfolio/';
		    	
		    	foreach($del_images as $del_image){
		    		unlink($dir.$dir_name.'/thumbs/'.$del_image);
		    		unlink($dir.$dir_name.'/thumbs_small/'.$del_image);
		    		unlink($dir.$dir_name.'/thumbs_normal/'.$del_image);
		    		unlink($dir.$dir_name.'/'.$del_image);
		    	}
		    	
		    	$this->response->redirect('images/delete/'.$dir_name);
	    	}
    	} elseif($dir_name && $delete_all){
    		//$this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
    		rrmdir($dir);
    		echo '<br><div id="infobox" style="background-color:tomato;">Album "'.$dir_name.'" wurde gelöscht.</div>';
    	} else {
    		//$this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
    		echo '<br><div id="infobox" style="background-color:tomato;">Das Album "'.$dir_name.'" existiert nicht!</div>';
    	}
    	$this->view->setVar("images", $images);
    }
    
     public function signupAction(){
     	$form = new Form();
     	 
     	$name = new Text("name" , array('placeholder' => 'Ihr Benutzername'));
     	$name->addValidator(new PresenceOf(array(
     			'message' => 'Sie müssen Ihren Benutzername eintragen!'
     	)));
     	 
     	$form->add($name);
     	
     	$pw = new Password("passwort" , array('placeholder' => 'Ihr Passwort'));
     	$pw->addValidator(new PresenceOf(array(
     			'message' => 'Sie müssen ein Passwort eingeben!'
     	)));
     	 
     	$form->add($pw);
     	
     	$this->view->setVar("form", $form);
     	
     	if ($this->request->isPost() == true) {
     		if (!$form->isValid($_POST)) {
     			foreach ($form->getMessages() as $message) {
     				echo $message, '<br>';
     			}
     		} else {
     			// Valide Form Werte
     			$name = $this->request->getPost("name");
     			$passwort = $this->request->getPost("passwort");
     			
     			$user = new user();
     			$user->name = $name;
     			$user->passwort = $this->security->hash($passwort);
     			
	     		if ($user->save() == false) {
				    echo '<div id="infobox" style="background-color:tomato;">Anmeldung fehlgeschlagen!</div>';
				    foreach ($user->getMessages() as $message) {
				        echo $message, "\n";
				    }
				} else {
				    echo '<div id="infobox" >Anmeldung erfolgreich!</div>';
				}
     		}
     	}
     }
     
     public function loginAction(){
     	
     	$form = new Form();
     	 
     	$name = new Text("name" , array('placeholder' => 'Ihr Benutzername'));
     	$name->addValidator(new PresenceOf(array(
     			'message' => 'Sie müssen Ihren Benutzername eintragen!'
     	)));
     	 
     	$form->add($name);
     
     	$pw = new Password("passwort" , array('placeholder' => 'Ihr Passwort'));
     	$pw->addValidator(new PresenceOf(array(
     			'message' => 'Sie müssen ein Passwort eingeben!'
     	)));
     	 
     	$form->add($pw);
     
     	$this->view->setVar("form", $form);
     
     	if ($this->request->isPost() == true) {
     		if (!$form->isValid($_POST)) {
     			foreach ($form->getMessages() as $message) {
     				echo $message, '<br>';
     			}
     		} else {
     			// Valide Form Werte
     			$name = $this->request->getPost("name");
     			$passwort = $this->request->getPost("passwort");
     
     			$user = user::findFirstByName($name);
     			if ($user) {
     				//if ($this->security->checkHash($passwort, $user->passwort)) {
     					//The password is valid
     					echo '<div id="infobox">Willkommen '.$name.'!</div>';
     					$this->_registerSession($user);
     					
     					$controller = $this->dispatcher->getPreviousControllerName();
     					$action = $this->dispatcher->getPreviousActionName();
     					
     					if($controller && $action){
     						//$this->dispatcher->forward(array('controller' => $controller, 'action' => $action));
     						header('Location: ' . $_SERVER['HTTP_REFERER']);
     					}
     				//}
     			} else
     				echo '<div id="infobox" style="background-color:tomato;">Anmeldung fehlgeschlagen!</div>';
     		}
     	}
     }
     
     public function logoutAction(){
     	//Destroy the whole session
     	$this->session->destroy();
     	header('Location: ' . $_SERVER['HTTP_REFERER']);
     }
     
     public function downloadAction($dir, $format = ''){
     	//Get the directory to zip
     	$thumb_dir = "";
     	
     	if($format == "1200x750")
     		$thumb_dir = 'thumbs_normal';
     	if($format == "550x300")
     		$thumb_dir = 'thumbs';
     	
     	$dir_files= dirname(__FILE__).'/../../public/img/portfolio/'.$dir.'/'.$thumb_dir;
     	
     	$files = glob($dir_files.'/*');
     	
     	$zip = new ZipArchive();
     	$zip_name = mt_rand(1,50)."_ErhartIT_Album_".$dir."_".$format.".zip"; // Zip name
     	$zip->open($zip_name,  ZipArchive::CREATE);
     	foreach ($files as $file) {
     		echo $path = $file;
     		if(file_exists($path) && is_image($path)){
     			$zip->addFromString(basename($path),  file_get_contents($path));
     		}
     		else{
     			echo"<br>file does not exist<br>";
     		}
     	}
     	$zip->close();
     	//then send the headers to foce download the zip file
     	header("Content-type: application/zip");
     	header("Content-Disposition: attachment; filename=$zip_name");
     	header("Pragma: no-cache");
     	header("Expires: 0");
     	readfile("$zip_name");
     	exit;
     }
    
}

function is_image($path){
	$a = getimagesize($path);
	$image_type = $a[2];
    
	if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))){
       return true;
	}
	return false;
}

function resizeDir($dir_name){
	
	$dir = dirname(__FILE__).'/../../public/img/portfolio/'.$dir_name;
	$images = array();
	try{
		$files = scandir($dir);
	} catch (Exception $e) {
		echo "Ordner fehler : ".$e;
	}
	
	foreach($files as $file){
		if(is_file($dir.'/'.$file)){
			if(is_image($dir.'/'.$file)){
				array_push($images, $file);
			} else {
				unlink($dir.'/'.$file);
			}
		}
	}
	if (!file_exists($dir.'/thumbs')) {
		mkdir($dir.'/thumbs', 0777, true);
	}
	
	if (!file_exists($dir.'/thumbs_small')) {
		mkdir($dir.'/thumbs_small', 0777, true);
	}
	
	if (!file_exists($dir.'/thumbs_normal')) {
		mkdir($dir.'/thumbs_normal', 0777, true);
	}
	
	foreach($images as $image){
		if(!file_exists($dir.'/thumbs_small/'.$image)){

			$imageX = new Phalcon\Image\Adapter\GD($dir.'/'.$image);
			
			if($imageX->getWidth() > 1600){
				$imageX->resize(1600, 900);
				$imageX->save($dir.'/'.$image);
			}
			 
			$imageX->resize(1200, 750);
			$imageX->save($dir.'/thumbs_normal/'.$image);
			
			if($imageX->getWidth() < $imageX->getHeight())
				$imageX->resize(550, null)->crop(550, 300);
			else
				$imageX->resize(null, 300)->crop(550, 300);
			$imageX->save($dir.'/thumbs/'.$image);
			
			$imageX->resize(null , 100)->crop(100, 100);
			$imageX->save($dir.'/thumbs_small/'.$image);
		}
	}
}

function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
}