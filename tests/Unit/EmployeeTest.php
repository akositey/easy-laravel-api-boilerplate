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
        //check if response is 201 - and that the response contains the created record
        $response->assertStatus(201)->assertJson($employee);
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
        //check if response is 200 and has the same keys and values as the updated data
        $response->assertStatus(200)->assertJson($newData);
    }

    /**
     *Test failed updating of employee
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
        //Assert that it has failed: error 422
        if ($response->status() !== 422) {
            dd($response->getContent());
        }
        //check if response is 422 - (Unprocessable entity) because it fails the validation
        $response->assertStatus(422);
    }

    /**
     *Test successfully find a record
     */
    public function test_find_an_employee()
    {
        $createdEmployee = factory(Employee::class, 1)->create()->first();
        //send post request
        $response = $this->json('GET', "api/employees/" . $createdEmployee->id);
        //Assert that it is successful
        if ($response->status() !== 200) {
            dd($response->getContent());
        }
        //check if response is 200
        $response->assertStatus(200)->assertJson($createdEmployee->toArray());
    }

    /**
     *Test failed finding records that do not exist
     */
    public function test_find_nonexistent_employees_should_fail()
    {
        for ($i = 0; $i <= 10; $i++) {
            //send post request
            $response = $this->json('GET', "api/employees/" . rand(1, 100));
            //Assert that it is successful
            if ($response->status() !== 404) {
                dd($response->getContent());
            }
            //check if response is 404
            $response->assertStatus(404);
        }
    }

    /**
     *Test successfully deleting a record
     */
    public function test_deleting_a_record()
    {
        $createdEmployee = factory(Employee::class, 1)->create()->first();
        //send post request
        $response = $this->json('DELETE', "api/employees/" . $createdEmployee->id);
        //Assert that it is successful
        if ($response->status() !== 204) {
            dd($response->getContent());
        }
        //check if response is 204- no content
        $response->assertStatus(204);
        //try to look for it
        $getResponse = $this->json('GET', "api/employees/" . $createdEmployee->id);
        //it should not find the record anymore
        $getResponse->assertStatus(404);
    }

    /**
     *Test successfully deleting a deleted record
     */
    public function test_restoring_a_deleted_record()
    {
        $createdEmployee = factory(Employee::class, 1)->create()->first();
        //send post request
        $response = $this->json('DELETE', "api/employees/" . $createdEmployee->id);
        //Assert that it is successful
        if ($response->status() !== 204) {
            dd($response->getContent());
        }
        //check if response is 204- no content
        $response->assertStatus(204);
        //try to restore it
        $restoreResponse = $this->json('PATCH', "api/employees/{$createdEmployee->id}/restore");
        //it should not find the record anymore
        $restoreResponse->assertStatus(200)->assertJson($createdEmployee->toArray());
    }
}