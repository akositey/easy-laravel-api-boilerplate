<?php

namespace App\Http\Requests\Api\ValidationRules;

class EmployeeRules implements ValidationRulesInterface
{
  /**
   * Rules for store method
   * 
   * @return array
   */
  public function get(string $method): array
  {
    //for this one, regardless of the method, return:
    return [
      'employee_number' => 'required|numeric',
      'last_name' => 'required',
      'first_name' => 'required',
      // 'middleName' => 'required',
    ];
  }
}