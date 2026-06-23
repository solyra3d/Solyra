<?php

class AdminSectionCardController extends Controller
{
    protected string $layout = 'admin';

    private array $validSections = ['home_process', 'home_differentials', 'about_features'];

    /**
     * Listar cards de uma seção
     */
    public function index(string $section): void
    {
        if (!in_array($section, $this->validSections)) {
            redirect(baseUrl('admin/paginas'));
            return;
        }

        $cards = SectionCard::getAllBySection($section);

        $this->view('admin/cards/index', [
            'cards' => $cards,
            'section' => $section,
            'sectionLabel' => SectionCard::getSectionLabel($section),
            'pageTitle' => 'Cards - ' . SectionCard::getSectionLabel($section),
        ]);
    }

    /**
     * Formulário de criação
     */
    public function create(string $section): void
    {
        if (!in_array($section, $this->validSections)) {
            redirect(baseUrl('admin/paginas'));
            return;
        }

        $this->view('admin/cards/form', [
            'card' => null,
            'section' => $section,
            'sectionLabel' => SectionCard::getSectionLabel($section),
            'pageTitle' => 'Novo Card - ' . SectionCard::getSectionLabel($section),
        ]);
    }

    /**
     * Salvar novo card
     */
    public function store(string $section): void
    {
        $this->validateCsrf();

        if (!in_array($section, $this->validSections)) {
            redirect(baseUrl('admin/paginas'));
            return;
        }

        $maxPos = Database::fetchOne(
            "SELECT MAX(order_position) as max_pos FROM section_cards WHERE section = ?",
            [$section]
        );

        SectionCard::create([
            'section' => $section,
            'icon' => $_POST['icon'] ?? '',
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'order_position' => ($maxPos['max_pos'] ?? 0) + 1,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        Session::flash('success', 'Card criado com sucesso!');
        redirect(baseUrl('admin/cards/' . $section));
    }

    /**
     * Formulário de edição
     */
    public function edit(string $id): void
    {
        $card = SectionCard::find((int) $id);
        if (!$card) {
            Session::flash('error', 'Card não encontrado.');
            redirect(baseUrl('admin/paginas'));
            return;
        }

        $this->view('admin/cards/form', [
            'card' => $card,
            'section' => $card['section'],
            'sectionLabel' => SectionCard::getSectionLabel($card['section']),
            'pageTitle' => 'Editar Card - ' . $card['title'],
        ]);
    }

    /**
     * Atualizar card
     */
    public function update(string $id): void
    {
        $this->validateCsrf();

        $card = SectionCard::find((int) $id);
        if (!$card) {
            Session::flash('error', 'Card não encontrado.');
            redirect(baseUrl('admin/paginas'));
            return;
        }

        SectionCard::update((int) $id, [
            'icon' => $_POST['icon'] ?? '',
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'order_position' => (int) ($_POST['order_position'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        Session::flash('success', 'Card atualizado com sucesso!');
        redirect(baseUrl('admin/cards/' . $card['section']));
    }

    /**
     * Excluir card
     */
    public function delete(string $id): void
    {
        $this->validateCsrf();

        $card = SectionCard::find((int) $id);
        if (!$card) {
            Session::flash('error', 'Card não encontrado.');
            redirect(baseUrl('admin/paginas'));
            return;
        }

        $section = $card['section'];
        SectionCard::delete((int) $id);

        Session::flash('success', 'Card removido!');
        redirect(baseUrl('admin/cards/' . $section));
    }
}
