<?php

class ProjectService
{

  public $_connection;

  public function __construct($db)
  {

    $this->_connection = $db;
  }

  function Add(Project $project)
  {

    $sql = "INSERT INTO " . $project->table_name . " SET id=NULL, enteid=:enteid, responsibleid=:responsibleid, name=:name, description=:description, estimatedbudget=:estimatedbudget, estimatedduration=:estimatedduration, createdBy=:createdBy, modifiedBy=:modifiedBy";

    $projectgetenteid = htmlspecialchars(strip_tags($project->getenteid()));

    $projectgetresponsibleid = htmlspecialchars(strip_tags($project->getresponsibleid()));

    $projectgetname = htmlspecialchars(strip_tags($project->getname()));

    $projectgetdescription = htmlspecialchars(strip_tags($project->getdescription()));

    $projectgetestimatedbudget = htmlspecialchars(strip_tags($project->getestimatedbudget()));

    $projectgetestimatedduration = htmlspecialchars(strip_tags($project->getestimatedduration()));

    $projectgetcreatedBy = $project->getcreatedBy();

    $stmt = $this->_connection->prepare($sql);

    $stmt->bindParam(":enteid", $projectgetenteid);

    $stmt->bindParam(":responsibleid", $projectgetresponsibleid);

    $stmt->bindParam(":name", $projectgetname);

    $stmt->bindParam(":description", $projectgetdescription);

    $stmt->bindParam(":estimatedbudget", $projectgetestimatedbudget);

    $stmt->bindParam(":estimatedduration", $projectgetestimatedduration);

    $stmt->bindParam(":createdBy", $projectgetcreatedBy);

    $stmt->bindParam(":modifiedBy", $projectgetcreatedBy);

    if ($stmt->execute()) return $this->_connection->lastInsertId();

    return false;
  }

  function Edit(Project $project)
  {

    if ($project->getid()) {

      $sql = "UPDATE " . $project->table_name . " SET enteid=:enteid, responsibleid=:responsibleid, name=:name, description=:description, estimatedbudget=:estimatedbudget, estimatedduration=:estimatedduration, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

      $projectgetenteid = htmlspecialchars(strip_tags($project->getenteid()));

      $projectgetresponsibleid = htmlspecialchars(strip_tags($project->getresponsibleid()));

      $projectgetname = htmlspecialchars(strip_tags($project->getname()));

      $projectgetdescription = htmlspecialchars(strip_tags($project->getdescription()));

      $projectgetestimatedbudget = htmlspecialchars(strip_tags($project->getestimatedbudget()));

      $projectgetestimatedduration = htmlspecialchars(strip_tags($project->getestimatedduration()));

      $projectgetmodifiedBy = $project->getmodifiedBy();

      $projectgetid = $project->getid();

      $stmt = $this->_connection->prepare($sql);

      $stmt->bindParam(":enteid", $projectgetenteid);

      $stmt->bindParam(":responsibleid", $projectgetresponsibleid);

      $stmt->bindParam(":name", $projectgetname);

      $stmt->bindParam(":description", $projectgetdescription);

      $stmt->bindParam(":estimatedbudget", $projectgetestimatedbudget);

      $stmt->bindParam(":estimatedduration", $projectgetestimatedduration);

      $stmt->bindParam(":modifiedBy", $projectgetmodifiedBy);

      $stmt->bindParam(":id", $projectgetid);

      if ($stmt->execute()) {

        return true;
      }

      return false;
    }
  }

  function EditStatus(Project $project)
  {

    if ($project->getid()) {

      $sql = "UPDATE " . $project->table_name . " SET status=:status, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

      $projectgetstatus = $project->getstatus();

      $projectgetmodifiedBy = $project->getmodifiedBy();

      $projectgetid = $project->getid();

      $stmt = $this->_connection->prepare($sql);

      $stmt->bindParam(":status", $projectgetstatus);

      $stmt->bindParam(":modifiedBy", $projectgetmodifiedBy);

      $stmt->bindParam(":id", $projectgetid);

      if ($stmt->execute()) return true;

      return false;
    }
  }

  function EditProgress(Project $project)
  {

    if ($project->getid()) {

      $sql = "UPDATE " . $project->table_name . " SET progress=:progress, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

      $projectgetprogress = $project->getprogress();

      $projectgetmodifiedBy = $project->getmodifiedBy();

      $projectgetid = $project->getid();

      $stmt = $this->_connection->prepare($sql);

      $stmt->bindParam(":progress", $projectgetprogress);

      $stmt->bindParam(":modifiedBy", $projectgetmodifiedBy);

      $stmt->bindParam(":id", $projectgetid);

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

  function GetOneName(string $table_name, string $name)
  {

    $sql = "SELECT id FROM " . $table_name . " WHERE name = ? LIMIT 1";

    $stmt = $this->_connection->prepare($sql);

    $stmt->bindParam(1, $name);

    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) return true;

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

  function GetActives(string $table_name)
  {

    $sql = "SELECT p.*, e.fullname, u.image AS uimage FROM " . $table_name . " p LEFT JOIN ente e ON e.id = p.enteid LEFT JOIN user u ON u.id = p.responsibleid WHERE p.status!='cancelado' ORDER BY p.id DESC";

    $stmt = $this->_connection->prepare($sql);

    if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

    return false;
  }

  function GetInactives(string $table_name)
  {

    $sql = "SELECT p.*, e.fullname, u.image AS uimage FROM " . $table_name . " p LEFT JOIN ente e ON e.id = p.enteid LEFT JOIN user u ON u.id = p.responsibleid WHERE status=0 ORDER BY p.id DESC";

    $stmt = $this->_connection->prepare($sql);

    if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

    return false;
  }

  function GetCountPeriod(string $table_name, int $days = 90)
  {

    $sql = "SELECT COUNT(*) as count FROM " . $table_name . " WHERE status != 'cancelado' AND createdDT >= (DATE(NOW()) - INTERVAL " . $days . " DAY)";

    $stmt = $this->_connection->prepare($sql);

    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($data)) return $data['count'];

    return 0;
  }

  function GetCountAll(string $table_name)
  {

    $sql = "SELECT COUNT(*) as count FROM " . $table_name . " WHERE status != 'cancelado'";

    $stmt = $this->_connection->prepare($sql);

    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($data)) return $data['count'];

    return 0;
  }

  function GetRecentlyAdded(string $table_name)
  {

    $sql = "SELECT p.*, e.fullname, e.image FROM " . $table_name . " p LEFT JOIN ente c ON p.enteid=e.id ORDER BY p.id DESC LIMIT 5";

    $stmt = $this->_connection->prepare($sql);

    if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

    return false;
  }

  function GetRecentlyModified(string $table_name)
  {

    $sql = "SELECT p.*, e.fullname, e.image FROM " . $table_name . " p LEFT JOIN ente c ON p.enteid=e.id ORDER BY modifiedDT DESC LIMIT 5";

    $stmt = $this->_connection->prepare($sql);

    if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

    return false;
  }

  function GetRecentlyAddedtograph(string $table_name, int $days = 90)
  {

    $sql = "SELECT count(*) as total, month(createdDT) as month, day(createdDT) as day FROM " . $table_name .

      " WHERE createdDT >= (DATE(NOW()) - INTERVAL " . $days . " DAY) GROUP BY day(createdDT) ORDER BY month, day";

    $stmt = $this->_connection->prepare($sql);

    if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

    return false;
  }

  function GetAll(string $table_name)
  {

    $sql = "SELECT p.*, e.fullname AS efullname, e.email AS eemail, e.image AS eimage, u.fullname AS ufullname, u.email AS uemail, u.image AS uimage FROM " . $table_name .

      " p LEFT JOIN ente e ON e.id = p.enteid LEFT JOIN user u ON u.id = p.responsibleid ORDER BY p.id DESC";

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
