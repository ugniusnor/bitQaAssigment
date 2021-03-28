<?php

namespace Repository;

use Model\Employee;
use mysqli;

class EmployeeRepository
{
    private $server;
    private $username;
    private $password;
    private $database;
    private $conn;

    public function __construct()
    {
        $this->server = "127.0.0.1";
        $this->username = "root";
        $this->password = "";
        $this->database = "phpUnitPractical";
        $this->conn = mysqli_connect($this->server, $this->username, $this->password, $this->database);
    }
    public function connectToDb()
    {
        $conn =  mysqli_connect($this->server, $this->username, $this->password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";
    }
    public function getAll(): array
    {
        $result = mysqli_query($this->conn, "SELECT id, name FROM employee");

        $employees = array();
        if (mysqli_num_rows($result) > 0)
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($employees, new Employee($row['id'], $row['name']));
            }

        mysqli_close($this->conn);
        return $employees;
    }
    public function getAllWithCount()
    {
        $employees = $this->getAll();
        $count = count($employees);
        $employees[] = (object) ['count' => $count];
        return $employees;
    }
    public function getById()
    {
    }
    public function save(Employee $e)
    {
    }
}
