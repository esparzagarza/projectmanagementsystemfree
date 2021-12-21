<?php

class Task
{
    public $table_name = "task";
    public $id;
    public $projectid;
    public $enteid;
    public $userid;
    public $categoryid;
    public $type;
    public $name;
    public $description;
    public $duedate;
    public $prio;
    public $notes;
    public $tags;
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
    public function getenteid()
    {
        return $this->enteid;
    }
    public function getuserid()
    {
        return $this->userid;
    }
    public function getcategoryid()
    {
        return $this->categoryid;
    }
    public function gettype()
    {
        return $this->type;
    }
    public function getname()
    {
        return $this->name;
    }
    public function getdescription()
    {
        return $this->description;
    }
    public function getduedate()
    {
        return $this->duedate;
    }
    public function getprio()
    {
        return $this->prio;
    }
    public function getnotes()
    {
        return $this->notes;
    }
    public function gettags()
    {
        return $this->tags;
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
    public function setenteid($enteid)
    {
        $this->enteid = $enteid;
    }
    public function setuserid($userid)
    {
        $this->userid = $userid;
    }
    public function setcategoryid($categoryid)
    {
        $this->categoryid = $categoryid;
    }
    public function settype($type)
    {
        $this->type = $type;
    }
    public function setdescription($description)
    {
        $this->description = $description;
    }
    public function setname($name)
    {
        $this->name = $name;
    }
    public function setduedate($duedate)
    {
        $this->duedate = $duedate;
    }
    public function setprio($prio)
    {
        $this->prio = $prio;
    }
    public function setnotes($notes)
    {
        $this->notes = $notes;
    }
    public function settags($tags)
    {
        $this->tags = $tags;
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
