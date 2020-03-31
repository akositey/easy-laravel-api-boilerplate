<?php

namespace Tests\Unit;

use App\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     *Test successful creation of employee
     */
    public function test_creating_an_employee_should_succeed()
    {
        $employee = [
            "number" => $this->faker->unique()->randomNumber(4),
            "last_name" => $this->faker->lastName,
            "first_name" => $this->faker->firstName,
        ];
        //send post request
        $response = $this->json('POST', route('employees.store'), $employee);
        //Assert that it is successful
        if ($response->status() !== 201) {
            dd($response->getContent());
        }
        //check if response is 201 - Successfully Created
        $response->assertStatus(201);
        //check response
        foreach ($employee as $key => $value) {
            $this->assertArrayHasKey($key, $response->json());
            $this->assertSame($value, $response->json()[$key]);
        }
    }

    /**
     *Test failed creation of employee
     */
    public function test_creating_an_employee_with_incomplete_data_should_fail()
    {
        $employees = [
            [
                "number" => $this->faker->unique()->randomNumber(4),
                "last_name" => $this->faker->lastName,
            ], [
                "number" => $this->faker->unique()->randomNumber(4),
                "first_name" => $this->faker->firstName,
            ],
        ];

        foreach ($employees as $employee) {
            //send post request
            $response = $this->json('POST', route('employees.store'), $employee);
            //Assert that it is successful
            if ($response->status() !== 422) {
                dd($response->getContent());
            }
            //check if response is 422 - Error
            $response->assertStatus(422);
        }
    }

    /**
     *Test successful updating of employee
     */
    public function test_updating_an_employee_should_succeed()
    {
        $createdEmployee = factory(Employee::class, 1)->create()->first();
        $newData = [
            "number" => $this->faker->unique()->randomNumber(4),
            "last_name" => $this->faker->lastName,
            "first_name" => $this->faker->firstName,
        ];
        //send post request
        $response = $this->json('PUT', "api/employees/" . $createdEmployee->id, $newData);
        //Assert that it is successful
        if ($response->status() !== 200) {
            dd($response->getContent());
        }
        //check if response is 200 - Success
        $response->assertStatus(200);
        //check response
        foreach ($newData as $key => $value) {
            $this->assertArrayHasKey($key, $response->json());
            $this->assertSame($value, $response->json()[$key]);
            $this->assertNotSame($value, $createdEmployee->$key);
        }
    }

    /**
     *Test successful updating of employee
     */
    public function test_updating_an_employee_with_incomplete_data_should_fail()
    {
        $createdEmployee = factory(Employee::class, 1)->create()->first();
        $newData = [
            "last_name" => $this->faker->lastName,
            "first_name" => $this->faker->firstName,
        ];
        //send post request
        $response = $this->json('PUT', "api/employees/" . $createdEmployee->id, $newData);
        //Assert that it is successful
        if ($response->status() !== 422) {
            dd($response->getContent());
        }
        //check if response is 422 - (Unprocessable entity) because it fails the validation
        $response->assertStatus(422);
    }
}