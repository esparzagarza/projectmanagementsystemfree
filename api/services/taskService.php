<?php

class TaskService
{

	public $_connection;

	public function __construct($db)
	{

		$this->_connection = $db;
	}

	function Add(Task $task)
	{

		$sql = "INSERT INTO " . $task->table_name . " SET id=NULL, projectid=:projectid, enteid=:enteid, userid=:userid, categoryid=:categoryid, type=:type, name=:name, description=:description, duedate=:duedate, prio=:prio, notes=:notes, tags=:tags, createdBy=:createdBy, modifiedBy=:modifiedBy";

		$taskgetprojectid = htmlspecialchars(strip_tags($task->getprojectid()));

		$taskgetenteid = htmlspecialchars(strip_tags($task->getenteid()));

		$taskgetuserid = htmlspecialchars(strip_tags($task->getuserid()));

		$taskgetcategoryid = htmlspecialchars(strip_tags($task->getcategoryid()));

		$taskgettype = htmlspecialchars(strip_tags($task->gettype()));

		$taskgetname = htmlspecialchars(strip_tags($task->getname()));

		$taskgetdescription = htmlspecialchars(strip_tags($task->getdescription()));

		$taskgetduedate = htmlspecialchars(strip_tags($task->getduedate()));

		$taskgetprio = htmlspecialchars(strip_tags($task->getprio()));

		$taskgetnotes = htmlspecialchars(strip_tags($task->getnotes()));

		$taskgettags = htmlspecialchars(strip_tags($task->gettags()));

		$taskgetcreatedBy = $task->getcreatedBy();

		$stmt = $this->_connection->prepare($sql);

		$stmt->bindparam(":projectid", $taskgetprojectid);

		$stmt->bindparam(":enteid", $taskgetenteid);

		$stmt->bindparam(":userid", $taskgetuserid);

		$stmt->bindparam(":categoryid", $taskgetcategoryid);

		$stmt->bindparam(":type", $taskgettype);

		$stmt->bindparam(":name", $taskgetname);

		$stmt->bindparam(":description", $taskgetdescription);

		$stmt->bindparam(":duedate", $taskgetduedate);

		$stmt->bindparam(":prio", $taskgetprio);

		$stmt->bindparam(":notes", $taskgetnotes);

		$stmt->bindparam(":tags", $taskgettags);

		$stmt->bindParam(":createdBy", $taskgetcreatedBy);

		$stmt->bindParam(":modifiedBy", $taskgetcreatedBy);

		if ($stmt->execute()) return $this->_connection->lastInsertId();

		return false;
	}

	function Edit(Task $task)
	{

		if ($task->getid()) {

			$sql = "UPDATE " . $task->table_name . " SET projectid=:projectid, enteid=:enteid, userid=:userid, categoryid=:categoryid, type=:type, name=:name, description=:description, duedate=:duedate, prio=:prio, notes=:notes, tags=:tags, status=:status, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$taskgetid = $task->getid();

			$taskgetmodifiedBy = $task->getmodifiedBy();

			$taskgetprojectid = htmlspecialchars(strip_tags($task->getprojectid()));

			$taskgetenteid = htmlspecialchars(strip_tags($task->getenteid()));

			$taskgetuserid = htmlspecialchars(strip_tags($task->getuserid()));

			$taskgetcategoryid = htmlspecialchars(strip_tags($task->getcategoryid()));

			$taskgettype = htmlspecialchars(strip_tags($task->gettype()));

			$taskgetname = htmlspecialchars(strip_tags($task->getname()));

			$taskgetdescription = htmlspecialchars(strip_tags($task->getdescription()));

			$taskgetduedate = htmlspecialchars(strip_tags($task->getduedate()));

			$taskgetprio = htmlspecialchars(strip_tags($task->getprio()));

			$taskgetnotes = htmlspecialchars(strip_tags($task->getnotes()));

			$taskgettags = htmlspecialchars(strip_tags($task->gettags()));

			$taskgetstatus = $task->getstatus();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindparam(":projectid", $taskgetprojectid);

			$stmt->bindparam(":enteid", $taskgetenteid);

			$stmt->bindparam(":userid", $taskgetuserid);

			$stmt->bindparam(":categoryid", $taskgetcategoryid);

			$stmt->bindparam(":type", $taskgettype);

			$stmt->bindparam(":name", $taskgetname);

			$stmt->bindparam(":description", $taskgetdescription);

			$stmt->bindparam(":duedate", $taskgetduedate);

			$stmt->bindparam(":prio", $taskgetprio);

			$stmt->bindparam(":notes", $taskgetnotes);

			$stmt->bindparam(":tags", $taskgettags);

			$stmt->bindParam(":status", $taskgetstatus);

			$stmt->bindParam(":modifiedBy", $taskgetmodifiedBy);

			$stmt->bindParam(":id", $taskgetid);

			if ($stmt->execute()) return true;

			return false;
		}
	}

	function EditStatus(Task $task)
	{

		if ($task->getid()) {

			$sql = "UPDATE " . $task->table_name . " SET status=:status, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$taskgetstatus = $task->getstatus();

			$taskgetmodifiedBy = $task->getmodifiedBy();

			$taskgetid = $task->getid();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":status", $taskgetstatus);

			$stmt->bindParam(":modifiedBy", $taskgetmodifiedBy);

			$stmt->bindParam(":id", $taskgetid);

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

	function GetCountPeriod(string $table_name, int $days = 7)
	{

		$sql = "SELECT COUNT(*) as count FROM " . $table_name . " WHERE status != 'cancelada' AND duedate >= (DATE(NOW()) - INTERVAL " . $days . " DAY)";

		$stmt = $this->_connection->prepare($sql);

		$stmt->execute();

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($data)) return $data['count'];

		return 0;
	}

	function GetCountAll(string $table_name)
	{

		$sql = "SELECT COUNT(*) as count FROM " . $table_name . " WHERE status != 'cancelada'";

		$stmt = $this->_connection->prepare($sql);

		$stmt->execute();

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($data)) return $data['count'];

		return 0;
	}

	function GetRecentlyAddedtograph(string $table_name, int $days = 0)
	{

		$sql = "SELECT count(*) as total, month(duedate) as month, day(duedate) as day FROM " . $table_name . " WHERE status != 'cancelada' AND duedate >= (DATE(NOW()) - INTERVAL " . $days . " DAY) GROUP BY day(duedate) ORDER BY month, day";

		$stmt = $this->_connection->prepare($sql);

		if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

		return false;
	}

	function GetProjectTask(string $table_name, int $projectid)
	{

		$sql = "SELECT t.*, e.fullname AS efullname, e.email AS eemail, e.image AS eimage, c.name as cname, p.name AS pname, u.fullname AS ufullname, u.email AS uemail, u.image AS uimage FROM " . $table_name .
			" t LEFT JOIN ente e ON e.id = t.enteid LEFT JOIN category c ON c.id = t.categoryid LEFT JOIN project p ON p.id = t.projectid LEFT JOIN user u ON u.id = t.userid WHERE projectid = " . $projectid . " ORDER BY id DESC";

		$stmt = $this->_connection->prepare($sql);

		if ($stmt->execute()) return $stmt->fetchAll(PDO::FETCH_ASSOC);

		return false;
	}

	function GetProjectTaskClosed(string $table_name, int $projectid)
	{

		$sql = "SELECT COUNT(*) AS count FROM " . $table_name . " t WHERE t.projectid = " . $projectid . " AND t.status = 'finalizada'";

		$stmt = $this->_connection->prepare($sql);

		$stmt->execute();

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($data)) return $data['count'];

		return 0;
	}

	function GetProjectTaskActive(string $table_name, int $projectid)
	{

		$sql = "SELECT COUNT(*) AS count FROM " . $table_name . " t WHERE t.projectid = " . $projectid . " AND t.status != 'cancelada'";

		$stmt = $this->_connection->prepare($sql);

		$stmt->execute();

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($data)) return $data['count'];

		return 0;
	}

	function GetAll(string $table_name)
	{

		$sql = "SELECT t.*, e.fullname AS efullname, e.email AS eemail, e.image AS eimage, c.name as cname, p.name AS pname, u.fullname AS ufullname, u.email AS uemail, u.image AS uimage FROM " . $table_name .
			" t LEFT JOIN ente e ON e.id = t.enteid LEFT JOIN category c ON c.id = t.categoryid LEFT JOIN project p ON p.id = t.projectid LEFT JOIN user u ON u.id = t.userid";

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
