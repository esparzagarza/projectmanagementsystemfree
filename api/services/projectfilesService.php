<?php

class ProjectfilesService

{

	public $_connection;

	public function __construct($db)
	{

		$this->_connection = $db;
	}

	function Add(Projectfiles $projectfiles)
	{

		$sql = "INSERT INTO " . $projectfiles->table_name . " SET	id=NULL, projectid=:projectid, title=:title, src=:src, createdBy=:createdBy, modifiedBy=:modifiedBy";

		$projectfilesgetprojectid = htmlspecialchars(strip_tags($projectfiles->getprojectid()));

		$projectfilesgettitle = htmlspecialchars(strip_tags($projectfiles->gettitle()));

		$projectfilesgetsrc = htmlspecialchars(strip_tags($projectfiles->getsrc()));

		$projectfilesgetcreatedBy = $projectfiles->getcreatedBy();

		$stmt = $this->_connection->prepare($sql);

		$stmt->bindParam(":projectid", $projectfilesgetprojectid);

		$stmt->bindParam(":title", $projectfilesgettitle);

		$stmt->bindParam(":src", $projectfilesgetsrc);

		$stmt->bindParam(":createdBy", $projectfilesgetcreatedBy);

		$stmt->bindParam(":modifiedBy", $projectfilesgetcreatedBy);

		if ($stmt->execute()) return $this->_connection->lastInsertId();

		return false;
	}

	function EditStatus(Projectfiles $projectfiles)
	{

		if ($projectfiles->getid()) {

			$sql = "UPDATE " . $projectfiles->table_name . " SET status=:status, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$projectfilesgetstatus = $projectfiles->getstatus();

			$projectfilesgetmodifiedBy = $projectfiles->getmodifiedBy();

			$projectfilesgetid = $projectfiles->getid();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":status", $projectfilesgetstatus);

			$stmt->bindParam(":modifiedBy", $projectfilesgetmodifiedBy);

			$stmt->bindParam(":id", $projectfilesgetid);

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

		$sql = "SELECT * FROM " . $table_name . " WHERE status=1";

		$stmt = $this->_connection->prepare($sql);

		if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

		return false;
	}

	function GetInactives(string $table_name)
	{

		$sql = "SELECT * FROM " . $table_name . " WHERE status=0";

		$stmt = $this->_connection->prepare($sql);

		if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

		return false;
	}

	function GetProjectFiles(string $table_name, int $projectid)
	{

		$sql = "SELECT * FROM " . $table_name . " WHERE projectid = " . $projectid . " ORDER BY id DESC";

		$stmt = $this->_connection->prepare($sql);

		if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

		return false;
	}

	function GetAll(string $table_name)
	{

		$sql = "SELECT * FROM " . $table_name;

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
