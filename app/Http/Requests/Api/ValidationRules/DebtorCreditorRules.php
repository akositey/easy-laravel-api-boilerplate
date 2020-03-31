<?php

namespace App\Http\Requests\Api\ValidationRules;

class DebtorCreditorRules implements ValidationRulesInterface
{
  /**
   * Rules for store method
   * 
   * @return array
   */
  public function get(string $method): array
  {
    return $method === 'store' ? //for store method
      [
        'code' => 'required',
        'description' => 'required',
        'address' => 'required',
        'contact_number' => 'required',
        // 'owner' => 'nullable',
      ] : [ //for update
        'code' => 'required',
        'description' => 'required',
      ];
  }
}