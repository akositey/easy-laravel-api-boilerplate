<?php
namespace App\Http\Requests\Api\ValidationRules;

interface ValidationRulesInterface
{
    /**
     * Rules for a method
     * 
     * @return array
     */
    public function get(string $method): array;
}
