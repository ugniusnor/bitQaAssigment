<?php

namespace Controller;

use Repository\EmployeeRepository;

class EmployeeController
{
    private $employeeRepository;
    public function __construct(EmployeeRepository $er)
    {
        $this->employeeRepository = $er;
    }
    public function getAll()
    {
    }
    public function getAllById()
    {
    }
    public function getAllJson(): string
    {
        return json_encode($this->employeeRepository->getAll());
    }
    public function getAllWithCount()
    {
        $employeeArr = $this->employeeRepository->getAll();
        $count = count($employeeArr);
        $employeeArr[] = (object) ['count' => $count];
        return json_encode($employeeArr);
    }
}
