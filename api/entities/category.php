<?php

class Category
{
    public $table_name = 'category';
    public $id;
    public $categoryid;
    public $name;
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

    public function getcategoryid()
    {
        return $this->categoryid;
    }

    public function getname()
    {
        return $this->name;
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

    public function setcategoryid($categoryid)
    {
        $this->categoryid = $categoryid;
    }

    public function setname($name)
    {
        $this->name = $name;
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
