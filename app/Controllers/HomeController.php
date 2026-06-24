<?php

class HomeController extends Controller
{
    private Product $product;
    private Category $category;
    private Banner $banner;
    private Review $review;

    private Portfolio $portfolio;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
        $this->banner = new Banner();
        $this->review = new Review();
        $this->portfolio = new Portfolio();
    }

    public function index(): void
    {
        $data = [
            'banners' => $this->banner->findActiveOrdered(),
            'categories' => $this->category->findActiveOrdered(),
            'featured' => $this->product->findFeatured(8),
            'newProducts' => $this->product->findNew(4),
            'readyProducts' => $this->product->findFeaturedReady(4),
            'portfolio' => $this->portfolio->findActiveWithImages(6),
            'reviews' => $this->review->findActiveOrdered(6),
            'processCards' => SectionCard::getBySection('home_process'),
            'differentialCards' => SectionCard::getBySection('home_differentials'),
            'gallery' => Gallery::getActive(),
            'seo' => [
                'title' => setting('seo_title', 'SOLYRA - Soluções para Impressão 3D'),
                'description' => setting('seo_description', ''),
            ],
        ];

        $this->view('home/index', $data);
    }
}
