<?php


require_once __DIR__ . '/./core/Application.php';




$app = new Application(__DIR__);

$app->db->applyMigrations();

?>

