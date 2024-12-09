<?php
require_once __DIR__ . '/../models/Productos.php';
require_once __DIR__ . '/../models/Inventario.php';

class DashboardController {
    private $productModel; 
    private $inventarioModel;

    public function __construct($db) {
        $this->productModel = new Product($db);
        $this->inventarioModel = new Inventario($db);
    }

    public function getGeneralStats() {
        return [
            'total_products' => $this->productModel->getTotalCount(),
            'total_categories' => $this->productModel->getCategoryCount(),
            'total_movements' => $this->inventarioModel->getMovementCount(),
        ];
    }

    public function getLowStockProducts($threshold = 10) {
        return $this->productModel->getLowStock($threshold);
    }

    public function getTopSellingProducts($limit = 5) {
        return $this->inventarioModel->getTopSelling($limit);
    }
}
