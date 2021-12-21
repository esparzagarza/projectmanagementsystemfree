<?php

class Ente
{
  public $table_name = 'ente';
  public $id;
  public $enteid;
  public $fullname;
  public $email;
  public $phone;
  public $website;
  public $address;
  public $rfc;
  public $razonsocial;
  public $fiscaladdress;
  public $image;
  public $type;
  public $level;
  public $status;
  public $createdBy;
  public $createdDT;
  public $modifiedBy;
  public $modifiedDT;

  public function getid()
  {
    return $this->id;
  }
  public function getenteid()
  {
    return $this->enteid;
  }
  public function getfullname()
  {
    return $this->fullname;
  }
  public function getemail()
  {
    return $this->email;
  }
  public function getphone()
  {
    return $this->phone;
  }
  public function getwebsite()
  {
    return $this->website;
  }
  public function getaddress()
  {
    return $this->address;
  }
  public function getrfc()
  {
    return $this->rfc;
  }
  public function getrazonsocial()
  {
    return $this->razonsocial;
  }
  public function getfiscaladdress()
  {
    return $this->fiscaladdress;
  }
  public function getimage()
  {
    return $this->image;
  }
  public function gettype()
  {
    return $this->type;
  }
  public function getlevel()
  {
    return $this->level;
  }
  public function getstatus()
  {
    return $this->status;
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
  public function setenteid($enteid)
  {
    $this->enteid = $enteid;
  }
  public function setfullname($fullname)
  {
    $this->fullname = $fullname;
  }
  public function setemail($email)
  {
    $this->email = $email;
  }
  public function setphone($phone)
  {
    $this->phone = $phone;
  }
  public function setwebsite($website)
  {
    $this->website = $website;
  }
  public function setaddress($address)
  {
    $this->address = $address;
  }
  public function setrfc($rfc)
  {
    $this->rfc = $rfc;
  }
  public function setrazonsocial($razonsocial)
  {
    $this->razonsocial = $razonsocial;
  }
  public function setfiscaladdress($fiscaladdress)
  {
    $this->fiscaladdress = $fiscaladdress;
  }
  public function setimage($image)
  {
    $this->image = $image;
  }
  public function settype($type)
  {
    $this->type = $type;
  }
  public function setlevel($level)
  {
    $this->level = $level;
  }
  public function setstatus($status)
  {
    $this->status = $status;
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
