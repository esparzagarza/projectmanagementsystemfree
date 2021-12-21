<?php

class Project
{

    public $table_name = 'project';
    public $id;
    public $enteid;
    public $responsibleid;
    public $name;
    public $description;
    public $estimatedbudget;
    public $totalamount;
    public $estimatedduration;
    public $progress;
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
    public function getresponsibleid()
    {
        return $this->responsibleid;
    }
    public function getname()
    {
        return $this->name;
    }
    public function getdescription()
    {
        return $this->description;
    }
    public function getestimatedbudget()
    {
        return $this->estimatedbudget;
    }
    public function gettotalamount()
    {
        return $this->totalamount;
    }
    public function getestimatedduration()
    {
        return $this->estimatedduration;
    }
    public function getprogress()
    {
        return $this->progress;
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
    public function setresponsibleid($responsibleid)
    {
        $this->responsibleid = $responsibleid;
    }
    public function setname($name)
    {
        $this->name = $name;
    }
    public function setdescription($description)
    {
        $this->description = $description;
    }
    public function setestimatedbudget($estimatedbudget)
    {
        $this->estimatedbudget = $estimatedbudget;
    }
    public function settotalamount($totalamount)
    {
        $this->totalamount = $totalamount;
    }
    public function setestimatedduration($estimatedduration)
    {
        $this->estimatedduration = $estimatedduration;
    }
    public function setprogress($progress)
    {
        $this->progress = $progress;
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
