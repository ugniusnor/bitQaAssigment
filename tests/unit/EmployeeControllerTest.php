<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEquals;

use Controller\EmployeeController;
use Model\Employee;
use Repository\EmployeeRepository;

class EmployeeContollerTest extends TestCase
{
    //stubing 
    public function testGetAllJsonReturnsJson()
    {
        // given
        $stub = $this->createStub(EmployeeRepository::class);
        $stub->method('getAll')->willReturn(array(
            new Employee(1, "Jonas"),
            new Employee(2, "Petras")
        ));
        $employeeController = new EmployeeController($stub);
        // when
        $res = $employeeController->getAllJson();
        // then
        assertEquals('[{"id":1,"name":"Jonas"},{"id":2,"name":"Petras"}]', $res);
    }


    //mocking

    public function testGetAllJsonReturnsJsonWithMocking()
    {
        $mock = $this->getMockBuilder(EmployeeRepository::class)->getMock();
        $employeeController = new EmployeeController($mock);
        $mock->expects($this->exactly(1))
            ->method('getAll')
            ->willReturn(array(new Employee(1, "Jonas")));

        // when
        $res = $employeeController->getAllJson();
        // then
        assertEquals('[{"id":1,"name":"Jonas"}]', $res);
    }

    //stubing getAllJsonWIthCount
    public function testGetAllJsonReturnsJsonWithCount()
    {
        $stub = $this->createStub(EmployeeRepository::class);
        $stub->method('getAll')->willReturn(array(
            new Employee(1, "Jonas"),
            new Employee(2, "Petras"),
        ));
        $employeeController = new EmployeeController($stub);
        $res = $employeeController->getAllWithCount();
        assertEquals('[{"id":1,"name":"Jonas"},{"id":2,"name":"Petras"},{"count":2}]', $res);
    }
    public function testGetAllJsonReturnsJsonWitWronghCount()
    {
        $stub = $this->createStub(EmployeeRepository::class);
        $stub->method('getAll')->willReturn(array(
            new Employee(1, "Jonas"),
            new Employee(2, "Petras"),
        ));
        $employeeController = new EmployeeController($stub);
        $res = $employeeController->getAllWithCount();
        assertNotEquals('[{"id":1,"name":"Jonas"},{"id":2,"name":"Petras"},{"count":3}]', $res);
        assertNotEquals('[{"id":1,"name":"Jonas"},{"id":2,"name":"Petras"},{"count":0}]', $res);
        assertNotEquals('[{"id":1,"name":"Jonas"},{"id":2,"name":"Petras"},{"count":1}]', $res);
    }

    public function testReturnEmployeeById()
    {
        $testId = 10;
        $testName = "Petraitis";
        $repo = new EmployeeRepository();
        print_r((new EmployeeController($repo))->getById(3));
        $stub = $this->createStub(EmployeeRepository::class);
        $stub->method('getById')->willReturn(array(
            new Employee($testId, $testName)
        ));
        $employeeController = new EmployeeController($stub);
        $res = $employeeController->getById($testId);
        assertEquals('[{"id":10,"name":"Petraitis"}]', $res);
    }

    public function testReturnEmployeeByIdFailsWithWrongdId()
    {
        $testId = 10;
        $testName = "Petraitis";
        $stub = $this->createStub(EmployeeRepository::class);
        $stub->method('getById')->willReturn(array(
            new Employee($testId, $testName)
        ));
        $employeeController = new EmployeeController($stub);
        $res = $employeeController->getById($testId);
        assertNotEquals('[{"id":9,"name":"Petraitis"}]', $res);
        assertNotEquals('[{"id":-1,"name":"Petraitis"}]', $res);
        assertNotEquals('[{"id":10,"name":"Jonaitis"}]', $res);
    }
}
