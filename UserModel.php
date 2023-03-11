<?php
namespace lexuanphat\phpmvc; 

use lexuanphat\phpmvc\db\DbModel;

abstract class UserModel extends DbModel{

    abstract public function getDisplayName() : string;
}