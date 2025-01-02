<?php

namespace Models;

use API\GridApi;
use Application;
use Exception;
use Model;
use Request;

class Grid extends Model
{
    const RULE_NUMERIC = 'numeric';
    const RULE_JSON_VALID = 'json_valid';
    const RULE_GRID_STRUCTURE = 'grid_structure';
    public $user_id;
    public $title;
    public $description;
    public $row_size;
    public $col_size;
    public $grid_data;

    public $gridApi;

    public function __construct()
    {
        $this->gridApi = new GridApi();
    }


    public function getAllGrids()
    {
        $grids = $this->gridApi->getGrids();
        return $grids;
    }

    public function getGridById($id)
    {
        $grid = $this->gridApi->getGridById($id);
        return $grid;
    }

    public function create(): void
    {
        if ($this->title === null || $this->description === null || $this->row_size === null || $this->col_size === null || $this->grid_data === null) {
            http_response_code(422);
            echo json_encode(['message' => 'Missing required fields']);
            return;
        }

        $data = [
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'row_size' => $this->row_size,
            'col_size' => $this->col_size,
            'grid_data' => $this->grid_data,
        ];

        try {
             $this->gridApi->addGrid($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    function deleteById($id)        
    {
        return $this->gridApi->deleteGrid($id);
    }

    function validate(): bool
    { 
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_NUMERIC && !is_numeric($value)) {
                    $this->addError($attribute, self::RULE_NUMERIC);
                }
                if ($ruleName === self::RULE_JSON_VALID && json_last_error() !== JSON_ERROR_NONE) {
                    $this->addError($attribute, self::RULE_JSON_VALID);
                }
                if ($ruleName === self::RULE_GRID_STRUCTURE && !$this->validateGridStructure($value)) {
                    $this->addError($attribute, self::RULE_GRID_STRUCTURE);
                }
            }
        }
        return empty($this->errors);
    }

    function validateGridStructure($value): bool
    {
        $grid = json_decode($value, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        if (!isset($grid['rows']) || !isset($grid['cols']) || !isset($grid['cells'])) {
            return false;
        }
        if (!is_numeric($grid['rows']) || !is_numeric($grid['cols']) || !is_array($grid['cells'])) {
            return false;
        }
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
            'title' => [self::RULE_REQUIRED],
            'description' => [self::RULE_REQUIRED],
            'row_size' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
            'col_size' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
            'grid_data' => [self::RULE_REQUIRED, self::RULE_JSON_VALID, self::RULE_GRID_STRUCTURE],
        ];
    }
}
