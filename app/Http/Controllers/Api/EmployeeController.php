<?php

namespace App\Http\Controllers\Api;

use App\Employee;
use App\Http\Requests\Api\ValidationRules\EmployeeRules as Rules;

class EmployeeController extends ApiController
{
    /**
     * Inject Model and Rules here
     *
     * @param Model $entity
     * @param RulesInterface $rules
     * @return void
     */
    public function __construct(Employee $entity, Rules $rules)
    {
        $this->entity = $entity;
        $this->rules = $rules;
    }
}