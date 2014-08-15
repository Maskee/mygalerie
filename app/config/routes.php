<?php

$router = new \Phalcon\Mvc\Router();

$router->add(
		"/([Kk])ontakt", 
		array(        
			    'controller' => 'index',
			    'action' => 'kontakt',
		)
);

$router->add(
		"/([Ii])mpressum",
		array(
				'controller' => 'index',
				'action' => 'impressum',
		)
);

?>