<?php
require_once __DIR__ . '/../models/Productos.php';

class ProductController {
    private $productModel;

    public function __construct($db) {
        $this->productModel = new Product($db);
    }

    public function index() {
        return $this->productModel->getAll();
    }

    // Mostrar detalles de un producto
    public function getById($id) {
        return $this->productModel->getById($id);
    }

    public function store($name, $category_id, $stock, $price) {
        return $this->productModel->create($name, $category_id, $stock, $price);
    }

    public function update($id, $name, $category_id, $stock, $price) {
        return $this->productModel->update($id, $name, $category_id, $stock, $price);
    }

    public function destroy($id) {
        return $this->productModel->delete($id);
    }
}
