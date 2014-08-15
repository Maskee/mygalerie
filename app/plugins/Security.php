<?php
use Phalcon\Events\Event,
Phalcon\Mvc\User\Plugin,
Phalcon\Mvc\Dispatcher,
Phalcon\Acl;


/**
 * Security
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class Security extends Plugin
{

	public function __construct($dependencyInjector)
	{
		$this->_dependencyInjector = $dependencyInjector;
	}

	public function getAcl()
	{
		if (!isset($this->persistent->acl)) {

			$acl = new Phalcon\Acl\Adapter\Memory();
			
			$acl->setDefaultAction(Phalcon\Acl::DENY);
			
			//Register roles
			$roles = array(
				'users' => new Phalcon\Acl\Role('Users'),
				'guests' => new Phalcon\Acl\Role('Guests'),
				'admins' => new Phalcon\Acl\Role('Admins')
			);
			foreach ($roles as $role) {
				$acl->addRole($role);
			}
			
			//Private area resources
			$privateResources = array(
				'images' => array('resize', 'upload', 'add', 'download')
			);
			foreach ($privateResources as $resource => $actions) {
				$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
			}
			//Public area resources
			$publicResources = array(
				'index' => array('*'),
				'service' => array('*'),
				'projects' => array('*'),
				'images' => array('index', 'login', 'gallery', 'logout', 'download')
			);
			foreach ($publicResources as $resource => $actions) {
				$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
			}
			// Admin areas
			$acl->addResource(new Phalcon\Acl\Resource('images'), array('delete', 'signup'));
			
			//Grant access to public areas to both users and guests
			foreach ($roles as $role) {
				foreach ($publicResources as $resource => $actions) {
					$acl->allow($role->getName(), $resource, $actions);
				}
			}
			
			//Grant acess to private area to role Users
			foreach ($privateResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Users', $resource, $action);
					$acl->allow('Admins', $resource, $action);
				}
			}
			// Grant acess to admin area to role Admins
			$acl->allow('Admins', 'images', 'delete');
			$acl->allow('Admins', 'images', 'signup');
			
			//The acl is stored in session, APC would be useful here too
			$this->persistent->acl = $acl;
		}
			
		return $this->persistent->acl;
	}

	/**
	 * This action is executed before execute any action in the application
	 */
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{
		unset($this->persistent->acl);
		
		$auth = $this->session->get('auth');
		if (!$auth){
			$role = 'Guests';
		} elseif ($auth['name'] == 'Admin' || $auth['name'] == 'admin') {
			$role = 'Admins';
		} else {
			$role = 'Users';
		}

		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();
		
		$acl = $this->getAcl();
		$allowed = $acl->isAllowed($role, $controller, $action);
		
		if ($allowed != Acl::ALLOW) {
			($role == 'Users') ? $admin = "als Admin" : $admin = "";
			echo '<div id="infobox" style="background-color:tomato;">Für diesen Bereich müssen Sie sich '.$admin.' anmelden!</div>';
			$dispatcher->forward(
					array(
							'controller' => 'images',
							'action' => 'login'
					)
			);
			return false;
		}

	}

}