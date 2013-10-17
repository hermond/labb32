<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-15
 * Time: 14:57
 * To change this template use File | Settings | File Templates.
 */

namespace signup\view;


class SignUpView {
    private static $REGISTER = "register";
    private static $USERNAME = "LoginView::UserName";
    private static $PASSWORD = "Password";
    private static $PASSWORDR = "PasswordR";


    private $message = "";
    /*
     * Messages
     */
    private static $passworLengthError = "Ditt lösenord måste vara minst 6 tecken.";
    private static $usernameLengthError = "Ditt användarnamn måste vara minst 3 tecken.";
    private static $passwordDoesntMatch = "Lösenorden matchar inte. Vänligen försök igen!";
    private static $usernameHasTags = "Användarnamnet innehåller otillåtna tecken";


    public function getSignUpBox() {


        //$user = $this->getUserName();
        //$checked = $this->userWantsToBeRemembered() ? "checked=checked" : "";
        if(isset($_POST[self::$USERNAME]))
        {
        $username = $_POST[self::$USERNAME];
        }
        else {
            $username = "";
        }
        $html = "
        <p><a href='./'>Tillbaka</a></p>
			<form action='?" . self::$REGISTER . "' method='post' enctype='multipart/form-data'>
				<fieldset>
					<legend>Signup - Skriv in användarnamn och lösenord</legend>
					<p style='color: red;'>" . $this->message . "</p>
					<label>Användarnamn :</label>
					<input type='text' size='20' name='" . self::$USERNAME . "' id='UserNameID' value='" .$username."' />
					<label>Lösenord  :</label>
					<input type='password' size='20' name='" . self::$PASSWORD . "' value='' />
					<label>Repetera lösenordet :</label>
					<input type='password' size='20' name='" . self::$PASSWORDR . "' value='' />

					<input type='submit' name=''  value='Registrera' />
				</fieldset>
			</form>";

        return $html;

    }

    public function isRegistering()
    {
        return isset($_GET[self::$REGISTER]);
    }

    public function passwordStringsMatch()
    {
        $password1 = "1";
        $password2 = "2";

        if (isset($_POST[self::$PASSWORD]))
        {
            $password1 = $_POST[self::$PASSWORD];
        }
        if (isset($_POST[self::$PASSWORDR]))
        {
           $password2 = $_POST[self::$PASSWORDR];
        }

        if ($password1 == $password2)
        {
            return true;
        }
        else
        {
            $this->message = self::$passwordDoesntMatch;
            return false;
        }

    }

    public function usernameHasNoTags()
    {

        if($_POST[self::$USERNAME] != strip_tags($_POST[self::$USERNAME])) {
            $this->message = self::$usernameHasTags;
            $this->sanitize();
            return false;
        }
        else{
            return true;
        }
    }

    private function sanitize()
    {
        $_POST[self::$USERNAME] = trim($_POST[self::$USERNAME]);
        $_POST[self::$USERNAME] = strip_tags($_POST[self::$USERNAME]);
    }

    public function getUsername(){
        if (isset($_POST[self::$USERNAME])){

            return $_POST[self::$USERNAME];
        }
    }

    public function getPassword(){
        if (isset($_POST[self::$PASSWORD])){

            return $_POST[self::$PASSWORD];
        }
    }


    public function checkStringLength()
    {
        if(strlen($_POST[self::$USERNAME]) <= 3 && strlen($_POST[self::$PASSWORD]) <= 6)
        {
            $this->message = self::$usernameLengthError . " " . self::$passworLengthError;

        }
        else if (strlen($_POST[self::$PASSWORD]) < 6)
        {
           $this->message = self::$passworLengthError;
        }
        else if (strlen($_POST[self::$USERNAME]) < 3)
        {
           $this->message = self::$usernameLengthError;
        }
        else{
            return true;
        }
    }

    public function setUsernameExistsMessage()
    {
        $this->message = "Användarnamnet finns redan";
    }


}
