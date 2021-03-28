<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
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
        // $repo = new EmployeeRepository();
        // print_r((new EmployeeController($repo))->getAllWithCount());


        $stub = $this->createStub(EmployeeRepository::class);
        $stub->method('getAllWithCount')->willReturn(array(
            new Employee(1, "Jonas"),
            new Employee(2, "Petras"),
            (object) ['count' => 2]
        ));
        $employeeController = new EmployeeController($stub);
        $res = $employeeController->getAllWithCount();
        assertEquals('[{"id":1,"name":"Jonas"},{"id":2,"name":"Petras"},{"count":2}]', $res);
    }
}
