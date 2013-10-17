<?php

namespace application\view;

require_once("common/view/Page.php");
require_once("SwedishDateTimeView.php");



class View {
	private $loginView;
    private $signUpView;
	private $timeView;
	
	public function __construct(\login\view\LoginView $loginView, \signup\view\SignUpView $signUpView) {
		$this->loginView = $loginView;
        $this->signUpView = $signUpView;
		$this->timeView = new SwedishDateTimeView();
	}
	
	public function getLoggedOutPage() {
		$html = $this->getHeader(false);
		$loginBox = $this->loginView->getLoginBox(); 
        $signUpLink = "<a href='?signup'>Registrera dig</a>";
		$html .= "<h2>Ej Inloggad</h2>
				  	$loginBox
				  	$signUpLink
				 ";
		$html .= $this->getFooter();

		return new \common\view\Page("Laboration. Inte inloggad", $html);
	}
	
	public function getLoggedInPage(\login\model\UserCredentials $user) {
		$html = $this->getHeader(true);
		$logoutButton = $this->loginView->getLogoutButton(); 
		$userName = $user->getUserName();

		$html .= "
				<h2>$userName är inloggad</h2>
				 	$logoutButton
				 ";
		$html .= $this->getFooter();

		return new \common\view\Page("Laboration. Inloggad", $html);
	}

    public function getSignUpPage()
    {
        $html = $this->getHeader("Registrering");
        $signUpBox = $this->signUpView->getSignUpBox();
        $html .= "<h2>Ej Inloggad</h2>
				  	$signUpBox
				 ";
        $html .= $this->getFooter();


        return new \common\view\Page("Laboration. Registrering", $html);
    }
	
	private function getHeader($isLoggedIn) {
		$ret =  "<h1>Laborationskod xx222aa</h1>";
		return $ret;
		
	}

	private function getFooter() {
		$timeString = $this->timeView->getTimeString(time());
		return "<p>$timeString<p>";
	}
	
	public function isSigningUp()
    {
        return isset($_GET["signup"]);
    }
	
}
