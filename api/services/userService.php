<?php

class UserService
{

	public $_connection;

	public function __construct($db)
	{

		$this->_connection = $db;
	}

	function Add(User $user)
	{

		$sql = "INSERT INTO " . $user->table_name . " SET id=NULL, email=:email, password=:password, fullname=:fullname, role=:role, createdBy=:createdBy, modifiedBy=:modifiedBy";

		$usergetemail = htmlspecialchars(strip_tags($user->getemail()));

		$usergetpassword = $user->getpassword();

		$usergetfullname = htmlspecialchars(strip_tags($user->getfullname()));

		$usergetrole = $user->getrole();

		$usergetcreatedBy = $user->getcreatedBy();

		$usergetmodifiedBy = $user->getcreatedBy();

		$stmt = $this->_connection->prepare($sql);

		$stmt->bindParam(":email", $usergetemail);

		$stmt->bindParam(":password", $usergetpassword);

		$stmt->bindParam(":fullname", $usergetfullname);

		$stmt->bindParam(":role", $usergetrole);

		$stmt->bindParam(":createdBy", $usergetcreatedBy);

		$stmt->bindParam(":modifiedBy", $usergetmodifiedBy);

		if ($stmt->execute()) return $this->_connection->lastInsertId();

		return false;
	}

	function Edit(User $user)
	{

		if ($user->getid()) {

			$sql = "UPDATE " . $user->table_name . " SET fullname=:fullname, role=:role, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$usergetfullname = htmlspecialchars(strip_tags($user->getfullname()));

			$usergetrole = $user->getrole();

			$usergetmodifiedBy = $user->getmodifiedBy();

			$usergetid = $user->getid();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":fullname", $usergetfullname);

			$stmt->bindParam(":role", $usergetrole);

			$stmt->bindParam(":modifiedBy", $usergetmodifiedBy);

			$stmt->bindParam(":id", $usergetid);

			if ($stmt->execute()) return true;

			return false;
		}
	}

	function EditImage(User $user)
	{

		if ($user->getid()) {

			$sql = "UPDATE " . $user->table_name . " SET image=:image, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$usergetimage = htmlspecialchars(strip_tags($user->getimage()));

			$usergetmodifiedBy = $user->getmodifiedBy();

			$usergetid = $user->getid();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":image", $usergetimage);

			$stmt->bindParam(":modifiedBy", $usergetmodifiedBy);

			$stmt->bindParam(":id", $usergetid);

			if ($stmt->execute()) return true;

			return false;
		}
	}

	function EditPassword(User $user)
	{

		if ($user->getid()) {

			$sql = "UPDATE " . $user->table_name . " SET password=:password, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$usergetpassword = $user->getpassword();

			$usergetmodifiedBy = $user->getmodifiedBy();

			$usergetid = $user->getid();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":password", $usergetpassword);

			$stmt->bindParam(":modifiedBy", $usergetmodifiedBy);

			$stmt->bindParam(":id", $usergetid);

			if ($stmt->execute()) return true;

			return false;
		}
	}

	function EditStatus(User $user)
	{

		if ($user->getid()) {

			$sql = "UPDATE " . $user->table_name . " SET status=:status, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$usergetstatus = $user->getstatus();

			$usergetmodifiedBy = $user->getmodifiedBy();

			$usergetid = $user->getid();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":status", $usergetstatus);

			$stmt->bindParam(":modifiedBy", $usergetmodifiedBy);

			$stmt->bindParam(":id", $usergetid);

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

	function GetCountAll(string $table_name)
	{

		$sql = "SELECT COUNT(*) as count FROM " . $table_name;

		$stmt = $this->_connection->prepare($sql);

		$stmt->execute();

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($data)) return $data['count'];

		return 0;
	}

	function GetOneemail(string $table_name, string $email)
	{

		$sql = "SELECT id FROM " . $table_name . " WHERE email = ? LIMIT 1";

		$stmt = $this->_connection->prepare($sql);

		$stmt->bindParam(1, $email);

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
