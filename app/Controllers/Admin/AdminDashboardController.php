<?php

class AdminDashboardController extends Controller
{
    protected string $layout = 'admin';

    public function index(): void
    {
        $data = [
            'totalProducts' => Database::count('products'),
            'totalCategories' => Database::count('categories'),
            'totalReviews' => Database::count('reviews'),
            'featuredProducts' => Database::count('products', 'is_featured = 1'),
            'newProducts' => Database::count('products', 'is_new = 1'),
            'activeProducts' => Database::count('products', 'is_active = 1'),
            'latestProducts' => Database::fetchAll(
                "SELECT p.*, c.name as category_name 
                 FROM products p 
                 LEFT JOIN categories c ON c.id = p.category_id 
                 ORDER BY p.created_at DESC LIMIT 5"
            ),
            'pageTitle' => 'Dashboard',
        ];

        $this->view('admin/dashboard', $data);
    }
}
