<?php

class Projectfiles
{

    public $table_name = 'projectfiles';
    public $id;
    public $projectid;
    public $title;
    public $src;
    public $status;
    public $createdBy;
    public $createdDT;
    public $modifiedBy;
    public $modifiedDT;

    public function getid()
    {
        return $this->id;
    }
    public function getprojectid()
    {
        return $this->projectid;
    }
    public function gettitle()
    {
        return $this->title;
    }
    public function getsrc()
    {
        return $this->src;
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
    public function setprojectid($projectid)
    {
        $this->projectid = $projectid;
    }
    public function settitle($title)
    {
        $this->title = $title;
    }
    public function setsrc($src)
    {
        $this->src = $src;
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
