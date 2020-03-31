<?php

namespace App\Http\Controllers\Api;

use App\Debtor;
use App\Http\Requests\Api\ValidationRules\DebtorCreditorRules as Rules;


class DebtorController extends ApiController
{
    /**
     * Inject Model and Rules here
     *
     * @param Model $entity
     * @param RulesInterface $rules
     * @return void
     */
    public function __construct(Debtor $entity, Rules $rules)
    {
        $this->entity = $entity;
        $this->rules = $rules;
    }
}