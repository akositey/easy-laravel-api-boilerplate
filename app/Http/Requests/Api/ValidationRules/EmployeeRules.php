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
    //method can be store or update, for this one
    //i have the same required fields for creating and updating
    //so I will just return 
    return [
      'number' => 'required|numeric',
      'last_name' => 'required',
      'first_name' => 'required',
    ];
  }
}