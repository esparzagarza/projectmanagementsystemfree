<?php
class EnteService
{
  public $_connection;

  public function __construct($db)
  {
    $this->_connection = $db;
  }

  function quickAdd(Ente $ente)
  {
    $sql = "INSERT INTO " . $ente->table_name . " SET
		id=NULL, fullname=:fullname, email=:email, phone=:phone, website=:website, type=:type, level=:level, createdBy=:createdBy, modifiedBy=:modifiedBy";

    $entegetcreatedBy = $ente->getcreatedBy();
    $entegetmodifiedBy = $ente->getmodifiedBy();

    $entegetfullname = htmlspecialchars(strip_tags($ente->getfullname()));
    $entegetemail = htmlspecialchars(strip_tags($ente->getemail()));
    $entegetphone = htmlspecialchars(strip_tags($ente->getphone()));
    $entegetwebsite = htmlspecialchars(strip_tags($ente->getwebsite()));
    $entegettype = htmlspecialchars(strip_tags($ente->gettype()));
    $entegetlevel = htmlspecialchars(strip_tags($ente->getlevel()));

    $stmt = $this->_connection->prepare($sql);

    $stmt->bindParam(":fullname", $entegetfullname);
    $stmt->bindParam(":email", $entegetemail);
    $stmt->bindParam(":phone", $entegetphone);
    $stmt->bindParam(":website", $entegetwebsite);
    $stmt->bindParam(":type", $entegettype);
    $stmt->bindParam(":level", $entegetlevel);

    $stmt->bindParam(":createdBy", $entegetcreatedBy);
    $stmt->bindParam(":modifiedBy", $entegetmodifiedBy);

    if ($stmt->execute()) return $this->_connection->lastInsertId();

    return false;
  }

  function Add(Ente $ente)
  {
    $sql = "INSERT INTO " . $ente->table_name . " SET
		id=NULL, enteid=:enteid, fullname=:fullname, email=:email, phone=:phone, website=:website, address=:address, rfc=:rfc, razonsocial=:razonsocial, fiscaladdress=:fiscaladdress, type=:type, level=:level, createdBy=:createdBy, modifiedBy=:modifiedBy";

    $entegetcreatedBy = $ente->getcreatedBy();
    $entegetmodifiedBy = $ente->getmodifiedBy();

    $entegetfullname = htmlspecialchars(strip_tags($ente->getfullname()));
    $entegetemail = htmlspecialchars(strip_tags($ente->getemail()));
    $entegetphone = htmlspecialchars(strip_tags($ente->getphone()));
    $entegetwebsite = htmlspecialchars(strip_tags($ente->getwebsite()));
    $entegetaddress = htmlspecialchars(strip_tags($ente->getaddress()));
    $entegetrfc = htmlspecialchars(strip_tags($ente->getrfc()));
    $entegetrazonsocial = htmlspecialchars(strip_tags($ente->getrazonsocial()));
    $entegetfiscaladdress = htmlspecialchars(strip_tags($ente->getfiscaladdress()));
    $entegettype = htmlspecialchars(strip_tags($ente->gettype()));
    $entegetlevel = htmlspecialchars(strip_tags($ente->getlevel()));


    $stmt = $this->_connection->prepare($sql);

    $stmt->bindParam(":fullname", $entegetfullname);
    $stmt->bindParam(":email", $entegetemail);
    $stmt->bindParam(":phone", $entegetphone);
    $stmt->bindParam(":website", $entegetwebsite);
    $stmt->bindParam(":address", $entegetaddress);
    $stmt->bindParam(":rfc", $entegetrfc);
    $stmt->bindParam(":razonsocial", $entegetrazonsocial);
    $stmt->bindParam(":fiscaladdress", $entegetfiscaladdress);
    $stmt->bindParam(":type", $entegettype);
    $stmt->bindParam(":level", $entegetlevel);

    $stmt->bindParam(":createdBy", $entegetcreatedBy);
    $stmt->bindParam(":modifiedBy", $entegetmodifiedBy);

    if ($stmt->execute()) return $this->_connection->lastInsertId();

    return false;
  }

  function Edit(Ente $ente)
  {
    if ($ente->getid()) {

      $sql = "UPDATE " . $ente->table_name . " SET
			fullname=:fullname, email=:email, phone=:phone, website=:website, address=:address, rfc=:rfc, razonsocial=:razonsocial, fiscaladdress=:fiscaladdress, type=:type, level=:level, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

      $entegetid = $ente->getid();
      $entegetmodifiedBy = $ente->getmodifiedBy();

      $entegetfullname = htmlspecialchars(strip_tags($ente->getfullname()));
      $entegetemail = htmlspecialchars(strip_tags($ente->getemail()));
      $entegetphone = htmlspecialchars(strip_tags($ente->getphone()));
      $entegetwebsite = htmlspecialchars(strip_tags($ente->getwebsite()));
      $entegetaddress = htmlspecialchars(strip_tags($ente->getaddress()));
      $entegetrfc = htmlspecialchars(strip_tags($ente->getrfc()));
      $entegetrazonsocial = htmlspecialchars(strip_tags($ente->getrazonsocial()));
      $entegetfiscaladdress = htmlspecialchars(strip_tags($ente->getfiscaladdress()));
      $entegettype = htmlspecialchars(strip_tags($ente->gettype()));
      $entegetlevel = htmlspecialchars(strip_tags($ente->getlevel()));


      $stmt = $this->_connection->prepare($sql);

      $stmt->bindParam(":fullname", $entegetfullname);
      $stmt->bindParam(":email", $entegetemail);
      $stmt->bindParam(":phone", $entegetphone);
      $stmt->bindParam(":website", $entegetwebsite);
      $stmt->bindParam(":address", $entegetaddress);
      $stmt->bindParam(":rfc", $entegetrfc);
      $stmt->bindParam(":razonsocial", $entegetrazonsocial);
      $stmt->bindParam(":fiscaladdress", $entegetfiscaladdress);
      $stmt->bindParam(":type", $entegettype);
      $stmt->bindParam(":level", $entegetlevel);

      $stmt->bindParam(":modifiedBy", $entegetmodifiedBy);
      $stmt->bindParam(":id", $entegetid);

      if ($stmt->execute()) return true;

      return false;
    }
  }

  function EditImage(Ente $ente)
  {
    if ($ente->getid()) {

      $sql = "UPDATE " . $ente->table_name . " SET
			image=:image, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

      $entegetimage = htmlspecialchars(strip_tags($ente->getimage()));
      $entegetmodifiedBy = $ente->getmodifiedBy();
      $entegetid = $ente->getid();

      $stmt = $this->_connection->prepare($sql);

      $stmt->bindParam(":image", $entegetimage);
      $stmt->bindParam(":modifiedBy", $entegetmodifiedBy);
      $stmt->bindParam(":id", $entegetid);

      if ($stmt->execute()) return true;

      return false;
    }
  }

  function EditStatus(Ente $ente)
  {
    if ($ente->getid()) {

      $sql = "UPDATE " . $ente->table_name . " SET
			status=:status, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

      $entegetstatus = $ente->getstatus();
      $entegetmodifiedBy = $ente->getmodifiedBy();
      $entegetid = $ente->getid();

      $stmt = $this->_connection->prepare($sql);

      $stmt->bindParam(":status", $entegetstatus);
      $stmt->bindParam(":modifiedBy", $entegetmodifiedBy);
      $stmt->bindParam(":id", $entegetid);

      if ($stmt->execute()) return true;

      return false;
    }
  }

  function CheckExist(string $table_name, int $id)
  {
    $sql = "SELECT id FROM " . $table_name . " WHERE id = ?";

    $stmt = $this->_connection->prepare($sql);

    $stmt->bindParam(1, $id);

    if ($stmt->execute()) return $stmt->fetch(PDO::FETCH_ASSOC);

    return false;
  }

  function GetActives(string $table_name)
  {
    $sql = "SELECT id, fullname, email, phone, address, image, type, level FROM " . $table_name . " WHERE status=1 ORDER BY fullname";

    $stmt = $this->_connection->prepare($sql);

    if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

    return false;
  }

  function GetType(string $table_name, string $type)
  {
    $sql = "SELECT * FROM " . $table_name . " WHERE type = ? ORDER BY fullname";

    $stmt = $this->_connection->prepare($sql);

    $stmt->bindParam(1, $type);

    if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

    return false;
  }

  function GetOne(string $table_name, int $id)
  {
    $sql = "SELECT * FROM " . $table_name . " WHERE id = ?";

    $stmt = $this->_connection->prepare($sql);

    $stmt->bindParam(1, $id);

    if ($stmt->execute()) return $stmt->fetch(PDO::FETCH_ASSOC);

    return false;
  }

  function GetCountPeriod(string $table_name, int $days = 7)
  {
    $sql = "SELECT COUNT(*) as count FROM " . $table_name . " WHERE createdDT >= (DATE(NOW()) - INTERVAL " . $days . " DAY)";

    $stmt = $this->_connection->prepare($sql);

    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($data)) return $data['count'];

    return 0;
  }

  function GetCountAll(string $table_name)
  {
    $sql = "SELECT COUNT(*) as count FROM " . $table_name;

    $stmt = $this->_connection->prepare($sql);

    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($data)) return $data['count'];

    return 0;
  }

  function GetAll(string $table_name)
  {
    $sql = "SELECT * FROM " . $table_name . " ORDER BY fullname";

    $stmt = $this->_connection->prepare($sql);

    if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

    return false;
  }

  function HardDelete(string $table_name, int $id)
  {
    $sql = "DELETE FROM " . $table_name . " WHERE id = ?";

    $stmt = $this->_connection->prepare($sql);

    $stmt->bindParam(1, $id);

    if ($stmt->execute()) return true;

    return false;
  }
}
