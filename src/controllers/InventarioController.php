<?php
require_once __DIR__ . '/../models/Inventario.php';

class InventarioController {
    private $inventarioModel;

    public function __construct($db) {
        $this->inventarioModel = new Inventario($db);
    }

    public function store($product_id, $type, $quantity) {
        return $this->inventarioModel->create($product_id, $type, $quantity);
    }

    // Obtener todos los movimientos
    public function index() {
        return $this->inventarioModel->getAll();
    }
}
