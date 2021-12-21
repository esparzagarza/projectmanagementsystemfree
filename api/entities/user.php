<?php

class User
{
  public $table_name = 'user';
  public $id;
  public $email;
  public $password;
  public $fullname;
  public $image;
  public $lastlogin;
  public $role;
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
    return password_hash($this->password, 1);
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
  public function getlastlogin()
  {
    return $this->lastlogin;
  }
  public function getrole()
  {
    return $this->role;
  }
  public function getcreatedBy()
  {
    return $this->createdBy;
  }
  public function getcreatedDT()
  {
    return $this->createdDT;
  }
  public function getmodifiedBy()
  {
    return $this->modifiedBy;
  }
  public function getmodifiedDT()
  {
    return $this->modifiedDT;
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
  public function setlastlogin($lastlogin)
  {
    $this->lastlogin = $lastlogin;
  }
  public function setrole($role)
  {
    $this->role = $role;
  }
  public function setcreatedBy($createdBy)
  {
    $this->createdBy = $createdBy;
  }
  public function setcreatedDT($createdDT)
  {
    $this->createdDT = $createdDT;
  }
  public function setmodifiedBy($modifiedBy)
  {
    $this->modifiedBy = $modifiedBy;
  }
  public function setmodifiedDT($modifiedDT)
  {
    $this->modifiedDT = $modifiedDT;
  }
}
