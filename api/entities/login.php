<?php

class Login
{
    public $table_name = 'user';
    public $id;
    public $email;
    public $password;
    public $fullname;
    public $image;
    public $status;
    public $createdBy;
    public $createdDT;
    public $modifiedBy;
    public $modifiedDT;

    public function getid()
    {
        return $this->id;
    }
    public function getemail()
    {
        return $this->email;
    }
    public function getpassword()
    {
        return $this->password;
    }
    public function getfullname()
    {
        return $this->fullname;
    }
    public function getimage()
    {
        return $this->image;
    }
    public function getstatus()
    {
        return $this->status;
    }
    public function getcreatedBy()
    {
        return $this->createdBy;
    }
    public function getmodifiedBy()
    {
        return $this->modifiedBy;
    }
    public function setid($id)
    {
        $this->id = $id;
    }
    public function setemail($email)
    {
        $this->email = $email;
    }
    public function setpassword($password)
    {
        $this->password = $password;
    }
    public function setfullname($fullname)
    {
        $this->fullname = $fullname;
    }
    public function setimage($image)
    {
        $this->image = $image;
    }
    public function setstatus($status)
    {
        $this->status = $status;
    }
    public function setcreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    public function setmodifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
    }
}
