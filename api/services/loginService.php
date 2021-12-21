<?php

class LoginService
{

	public $_connection;

	public function __construct($db)
	{

		$this->_connection = $db;
	}

	function Lastlogin(Login $login)
	{

		if ($login->getId()) {

			$sql = "UPDATE " . $login->table_name . " SET lastlogin=now() WHERE id=:id AND email=:email";

			$logingetId = $login->getId();

			$logingetEmail = htmlspecialchars(strip_tags($login->getEmail()));

			$stmt = $this->_connection->prepare($sql);

			$stmt->bindParam(":id", $logingetId);

			$stmt->bindParam(":email", $logingetEmail);

			if ($stmt->execute())  return true;

			return false;
		}
	}

	function GetOneEmail(string $table_name, string $email)
	{

		$sql = "SELECT * FROM " . $table_name . " WHERE email = ? LIMIT 1";

		$stmt = $this->_connection->prepare($sql);

		$stmt->bindParam(1, $email);

		if ($stmt->execute()) return $stmt->fetch(PDO::FETCH_ASSOC);

		return false;
	}
}
