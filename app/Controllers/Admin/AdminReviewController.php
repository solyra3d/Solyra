<?php

class AdminReviewController extends Controller
{
    protected string $layout = 'admin';
    private Review $review;

    public function __construct()
    {
        $this->review = new Review();
    }

    public function index(): void
    {
        $reviews = $this->review->findAll('created_at DESC');

        $this->view('admin/reviews/index', [
            'reviews' => $reviews,
            'pageTitle' => 'Avaliações',
        ]);
    }

    public function create(): void
    {
        $this->view('admin/reviews/form', [
            'review' => null,
            'pageTitle' => 'Nova Avaliação',
        ]);
    }

    public function store(): void
    {
        $this->validateCsrf();

        $data = [
            'client_name' => $this->input('client_name'),
            'company' => $this->input('company'),
            'text' => $this->input('text'),
            'rating' => max(1, min(5, (int) $this->input('rating', '5'))),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        // Upload de avatar
        if (!empty($_FILES['avatar']['name'])) {
            $result = Upload::file($_FILES['avatar'], 'reviews');
            if ($result['success']) {
                $data['avatar'] = $result['path'];
            }
        }

        $this->review->create($data);

        Session::flash('success', 'Avaliação criada com sucesso!');
        redirect('/admin/avaliacoes');
    }

    public function edit(string $id): void
    {
        $review = $this->review->findById((int) $id);
        if (!$review) {
            Session::flash('error', 'Avaliação não encontrada.');
            redirect('/admin/avaliacoes');
        }

        $this->view('admin/reviews/form', [
            'review' => $review,
            'pageTitle' => 'Editar Avaliação',
        ]);
    }

    public function update(string $id): void
    {
        $this->validateCsrf();

        $review = $this->review->findById((int) $id);
        if (!$review) {
            Session::flash('error', 'Avaliação não encontrada.');
            redirect('/admin/avaliacoes');
        }

        $data = [
            'client_name' => $this->input('client_name'),
            'company' => $this->input('company'),
            'text' => $this->input('text'),
            'rating' => max(1, min(5, (int) $this->input('rating', '5'))),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        // Upload de novo avatar
        if (!empty($_FILES['avatar']['name'])) {
            $result = Upload::file($_FILES['avatar'], 'reviews');
            if ($result['success']) {
                if ($review['avatar']) {
                    Upload::deleteFile($review['avatar']);
                }
                $data['avatar'] = $result['path'];
            }
        }

        $this->review->update((int) $id, $data);

        Session::flash('success', 'Avaliação atualizada com sucesso!');
        redirect('/admin/avaliacoes/editar/' . $id);
    }

    public function delete(string $id): void
    {
        $this->validateCsrf();

        $review = $this->review->findById((int) $id);
        if (!$review) {
            Session::flash('error', 'Avaliação não encontrada.');
            redirect('/admin/avaliacoes');
        }

        if ($review['avatar']) {
            Upload::deleteFile($review['avatar']);
        }

        $this->review->delete((int) $id);

        Session::flash('success', 'Avaliação excluída com sucesso!');
        redirect('/admin/avaliacoes');
    }
}
