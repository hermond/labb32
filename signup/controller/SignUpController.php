<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-15
 * Time: 14:27
 * To change this template use File | Settings | File Templates.
 */


namespace signup\controller;

require_once("./signup/model/SignUpModel.php");
require_once("./signup/view/SignUpView.php");

class SignUpController {

    private $model;
    private $view;
    private $registrationSucceeded = false;

    public function __construct(\signup\view\SignUpView $view) {
        $this->model = new \signup\model\SignUpModel();
        $this->view = $view;
    }

    public function doSignUpCheck()
    {
        if($this->view->isRegistering())
        {
            if($this->view->passwordStringsMatch() && $this->view->usernameHasNoTags())
            {
                if ($this->view->checkStringLength()){
                try{
                $username = $this->view->getUsername();
                $password = $this->view->getPassword();

                $this->model->addUser($username, $password);
                $this->registrationSucceeded = true;
                }
                catch (\Exception $e)
                {
                    $this->view->setUsernameExistsMessage();
                }
                }
            }
        }

    }

    public function registrationSucceeded()
    {
        return $this->registrationSucceeded;
    }

    public function isRegistrering()
    {
        return $this->view->isRegistering();
    }
}