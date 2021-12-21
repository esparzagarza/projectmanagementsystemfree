<?php

class CategoryService
{

	public $_connection;

	public function __construct($db)
	{

		$this->_connection = $db;
	}

	function Add(Category $category)
	{

		$sql = "INSERT INTO " . $category->table_name . " SET id=NULL, name=:name, categoryid=:categoryid, createdBy=:createdBy, modifiedBy=:modifiedBy";

		$categorygetname = htmlspecialchars(strip_tags($category->getname()));

		$categorygetcategoryid = htmlspecialchars(strip_tags($category->getcategoryid()));

		$categorygetcreatedBy = $category->getcreatedBy();

		$stmt = $this->_connection->prepare($sql);

		$stmt->bindParam(":name", $categorygetname);

		$stmt->bindParam(":categoryid", $categorygetcategoryid);

		$stmt->bindParam(":createdBy", $categorygetcreatedBy);

		$stmt->bindParam(":modifiedBy", $categorygetcreatedBy);

		if ($stmt->execute()) return $this->_connection->lastInsertId();

		return false;
	}

	function Edit(Category $category)
	{

		if ($category->getid()) {

			$sql = "UPDATE " . $category->table_name . " SET name=:name, categoryid=:categoryid, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$categorygetname = htmlspecialchars(strip_tags($category->getname()));

			$categorygetcategoryid = htmlspecialchars(strip_tags($category->getcategoryid()));

			$categorygetmodifiedBy = $category->getmodifiedBy();

			$categorygetid = $category->getid();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":name", $categorygetname);

			$stmt->bindParam(":categoryid", $categorygetcategoryid);

			$stmt->bindParam(":modifiedBy", $categorygetmodifiedBy);

			$stmt->bindParam(":id", $categorygetid);

			if ($stmt->execute()) return true;

			return false;
		}
	}

	function EditImage(Category $category)
	{

		if ($category->getid()) {

			$sql = "UPDATE " . $category->table_name . " SET image=:image, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$categorygetimage = htmlspecialchars(strip_tags($category->getimage()));

			$categorygetmodifiedBy = $category->getmodifiedBy();

			$categorygetid = $category->getid();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":image", $categorygetimage);

			$stmt->bindParam(":modifiedBy", $categorygetmodifiedBy);

			$stmt->bindParam(":id", $categorygetid);

			if ($stmt->execute()) return true;

			return false;
		}
	}

	function EditStatus(Category $category)
	{

		if ($category->getid()) {

			$sql = "UPDATE " . $category->table_name . " SET status=:status, modifiedBy=:modifiedBy, modifiedDT=now() WHERE id=:id";

			$categorygetstatus = $category->getstatus();

			$categorygetmodifiedBy = $category->getmodifiedBy();

			$categorygetid = $category->getid();

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":status", $categorygetstatus);

			$stmt->bindParam(":modifiedBy", $categorygetmodifiedBy);

			$stmt->bindParam(":id", $categorygetid);

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

	function GetOnename(string $table_name, string $name)
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

		$sql = "SELECT id, name, image FROM " . $table_name . " WHERE status=1 ORDER BY name";

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

	function GetAll(string $table_name)
	{

		$sql = "SELECT c1.*, c2.name as parent, c2.image AS parentimage FROM " . $table_name . " c1 LEFT JOIN " . $table_name . " c2 on c1.categoryid = c2.id ORDER BY c1.name";

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
