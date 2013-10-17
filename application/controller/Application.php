<?php

namespace application\controller;

require_once("application/view/View.php");
require_once("login/controller/LoginController.php");
require_once("signup/controller/SignUpController.php");



class Application {
	private $view;

	private $loginController;
	private $signUpController;

	public function __construct() {

		$this->loginView = new \login\view\LoginView();
        $signUpView = new \signup\view\SignUpView();
		$this->signUpController = new \signup\controller\SignUpController($signUpView);
		$this->loginController = new \login\controller\LoginController($this->loginView);
		$this->view = new \application\view\View($this->loginView, $signUpView);
	}
	
	public function doFrontPage() {

        $this->signUpController->doSignUpCheck();
		$this->loginController->doToggleLogin();

		if ($this->loginController->isLoggedIn()) {
			$loggedInUserCredentials = $this->loginController->getLoggedInUser();
			return $this->view->getLoggedInPage($loggedInUserCredentials);	
		}
        else if($this->view->isSigningUp()){

            return $this->view->getSignUpPage();
        }
        else if ($this->signUpController->registrationSucceeded())
        {
           $this->loginView->setRegistrationSuccessMessage();
            return $this->view->getLoggedOutPage();
        }
        else if ($this->signUpController->isRegistrering())
        {
            return $this->view->getSignUpPage();
        }
        else {
			return $this->view->getLoggedOutPage();
		}

	}
}
