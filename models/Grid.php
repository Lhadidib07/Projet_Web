<?php

namespace Models;

use API\GridApi;
use Application;
use Exception;
use Model;

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

    public function create(): bool
    {
        try {
            $data = [
                'user_id' => $this->user_id,
                'title' => $this->title,
                'description' => $this->description,
                'row_size' => $this->row_size,
                'col_size' => $this->col_size,
                'grid_data' => json_encode($this->grid_data)
            ];

            return $this->gridApi->addGrid($data);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de la grille : " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $grid = $this->gridApi->delete('grids/' . $id);
        return $grid;
    }

    public function loadData($data)
    {
        $this->user_id = $_SESSION['user_id'] ?? null;
        $this->title = filter_var($data['title'] ?? null, FILTER_SANITIZE_STRING);
        $this->description = filter_var($data['description'] ?? null, FILTER_SANITIZE_STRING);
        $this->row_size = filter_var($data['row_size'] ?? null, FILTER_SANITIZE_STRING);
        $this->col_size = filter_var($data['col_size'] ?? null, FILTER_SANITIZE_STRING);
        $this->grid_data = json_decode($data['grid_data'] ?? null, true);

    }

/*
    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED],[self::RULE_MAX, 'max' => 24],
            'title' => [self::RULE_REQUIRED],
            'description' => [self::RULE_REQUIRED],
            'row_size' => [self::RULE_REQUIRED],
            'col_size' => [self::RULE_REQUIRED],
            'grid_data' => [self::RULE_REQUIRED]
        ];
    }
*/
    public function rules(): array
    {
        return [
            'user_id' => [
                [self::RULE_REQUIRED],
                [self::RULE_NUMERIC],
                [self::RULE_MAX, 'max' => 24]
            ],
            'title' => [self::RULE_REQUIRED],
            'description' => [self::RULE_REQUIRED],
            'row_size' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
            'col_size' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
            'grid_data' => [self::RULE_REQUIRED, self::RULE_JSON_VALID, self::RULE_GRID_STRUCTURE]
        ];
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Ce champ est requis.',
            self::RULE_MAX => 'Ce champ ne doit pas dépasser {max} caractères.',
            self::RULE_NUMERIC => 'Ce champ doit être un nombre.',
            self::RULE_JSON_VALID => 'Le champ doit contenir un JSON valide.',
            self::RULE_GRID_STRUCTURE => 'La structure du JSON est invalide.'
        ];
    }

    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->data[$attribute] ?? null;
            foreach ($rules as $rule) {
                $ruleName = $rule[0] ?? $rule;

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_NUMERIC && !is_numeric($value)) {
                    $this->addError($attribute, self::RULE_NUMERIC);
                }
                if ($ruleName === self::RULE_JSON_VALID && !$this->isValidJson($value)) {
                    $this->addError($attribute, self::RULE_JSON_VALID);
                }
                if ($ruleName === self::RULE_GRID_STRUCTURE && !$this->validateGridStructure($value)) {
                    $this->addError($attribute, self::RULE_GRID_STRUCTURE);
                }
            }
        }

        return empty($this->errors);
    }

    protected function isValidJson(string $json): bool
    {
        return json_validate($json);
    }

    protected function validateGridStructure(string $json): bool
    {
        $data = json_decode($json, true);
        if (!$data || !isset($data['grid'], $data['words'])) {
            return false;
        }

        if (!is_array($data['grid']) || !is_array($data['words'])) {
            return false;
        }

        foreach ($data['words'] as $word) {
            if (!isset($word['word'], $word['position'], $word['direction'], $word['clue'])) {
                return false;
            }
            if (!is_array($word['position']) || count($word['position']) !== 2) {
                return false;
            }
        }

        return true;
    }

}