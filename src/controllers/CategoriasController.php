<?php
require_once __DIR__ . '/../models/Categorias.php';

class CategoryController {
    private $categoryModel;

    public function __construct($db) {
        $this->categoryModel = new Category($db);
    }

    public function index() {
        return $this->categoryModel->getAll();
    }

    public function store($name) {
        return $this->categoryModel->create($name);
    }

    // Método show en CategoryController.php
    public function show($id) {
        return $this->categoryModel->getById($id);
    }

    public function update($id, $name) {
        return $this->categoryModel->update($id, $name);
    }

    public function destroy($id) {
        return $this->categoryModel->delete($id);
    }
}
