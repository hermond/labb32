<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-15
 * Time: 15:53
 * To change this template use File | Settings | File Templates.
 */
namespace signup\model;


use common\model\PHPFileStorage;
use login\model\Password;
use login\model\UserCredentials;
use login\model\UserList;
use login\model\UserName;

class SignUpModel {

    public $userExistMessage = "";
    private $filePath = "data/admin.php";
    public function addUser($username, $password)
    {
        if($this->DoesUserNameExist($username) == false)
        {
            $UserName = new UserName($username);
            $Password = Password::fromCleartext($password);
            $usercredentials = UserCredentials::create($UserName, $Password);
            $phpFileStorage = new PHPFileStorage("data/admin.php");
            $phpFileStorage->writeItem("Admin", $usercredentials->toString());
        }
        else{
            throw new \Exception ("Username already exists");
        }





    }

    private function DoesUserNameExist($username)
    {

        $fileContents = file_get_contents($this->filePath);
        $fileLines = explode("\n", $fileContents);
        $numLines = count($fileLines);

        for ($i = 1; $i < $numLines; $i++) {
            $line = &$fileLines[$i];

            $letters = mb_substr($line , 11);
            $letters = explode("%", $letters);
            if ($letters[0] == $username)
            {
                return true;
            }

        }
        return false;
    }

}