<?php

class Database
{

	public $_connection;

	public function getConnection()
	{

		$this->_connection = null;

		try {

			$this->_connection = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
		} catch (PDOException $exception) {

			echo "Connection error: " . $exception->getMessage();
		}

		return $this->_connection;
	}
}
