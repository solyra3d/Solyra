<?php

class AdminPageController extends Controller
{
    protected string $layout = 'admin';

    /**
     * Lista de páginas editáveis
     */
    public function index(): void
    {
        $pages = [
            ['slug' => 'home', 'name' => 'Página Inicial', 'desc' => 'Hero, títulos de seções, CTA'],
            ['slug' => 'sobre', 'name' => 'Sobre', 'desc' => 'Quem somos, diferenciais, CTA'],
            ['slug' => 'footer', 'name' => 'Rodapé e Contato', 'desc' => 'Descrição da marca, título do contato'],
        ];

        $this->view('admin/pages/index', [
            'pages' => $pages,
            'pageTitle' => 'Páginas',
        ]);
    }

    /**
     * Editar conteúdo da Home
     */
    public function editHome(): void
    {
        $sections = [
            'hero' => ['label' => 'Hero (Banner Principal)', 'fields' => [
                'badge' => ['label' => 'Badge (tag superior)', 'type' => 'text'],
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Título (palavra em destaque/gradiente)', 'type' => 'text'],
                'description' => ['label' => 'Descrição', 'type' => 'textarea'],
                'btn_primary' => ['label' => 'Botão Principal', 'type' => 'text'],
                'btn_secondary' => ['label' => 'Botão Secundário', 'type' => 'text'],
            ]],
            'categories' => ['label' => 'Seção Categorias', 'fields' => [
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Palavra em destaque', 'type' => 'text'],
                'subtitle' => ['label' => 'Subtítulo', 'type' => 'text'],
            ]],
            'featured' => ['label' => 'Seção Produtos em Destaque', 'fields' => [
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Palavra em destaque', 'type' => 'text'],
                'subtitle' => ['label' => 'Subtítulo', 'type' => 'text'],
            ]],
            'ready' => ['label' => 'Seção Pronta Entrega', 'fields' => [
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Palavra em destaque', 'type' => 'text'],
                'subtitle' => ['label' => 'Subtítulo', 'type' => 'text'],
            ]],
            'process' => ['label' => 'Seção Como Funciona', 'fields' => [
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Palavra em destaque', 'type' => 'text'],
                'subtitle' => ['label' => 'Subtítulo', 'type' => 'text'],
            ]],
            'differentials' => ['label' => 'Seção Diferenciais', 'fields' => [
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Palavra em destaque', 'type' => 'text'],
                'title_suffix' => ['label' => 'Texto após destaque (ex: ?)', 'type' => 'text'],
                'subtitle' => ['label' => 'Subtítulo', 'type' => 'text'],
            ]],
            'reviews' => ['label' => 'Seção Avaliações', 'fields' => [
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Palavra em destaque', 'type' => 'text'],
                'subtitle' => ['label' => 'Subtítulo', 'type' => 'text'],
            ]],
            'cta' => ['label' => 'CTA Final', 'fields' => [
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Palavra em destaque', 'type' => 'text'],
                'title_suffix' => ['label' => 'Texto após destaque (ex: ?)', 'type' => 'text'],
                'description' => ['label' => 'Descrição', 'type' => 'textarea'],
                'btn_primary' => ['label' => 'Botão Principal', 'type' => 'text'],
                'btn_secondary' => ['label' => 'Botão Secundário', 'type' => 'text'],
            ]],
        ];

        // Carregar valores atuais
        $contents = [];
        foreach ($sections as $sectionKey => $section) {
            $contents[$sectionKey] = PageContent::getSection('home', $sectionKey);
        }

        $this->view('admin/pages/home', [
            'sections' => $sections,
            'contents' => $contents,
            'pageTitle' => 'Editar Página Inicial',
        ]);
    }

    /**
     * Salvar conteúdo da Home
     */
    public function updateHome(): void
    {
        $this->validateCsrf();

        $sectionKeys = ['hero', 'categories', 'featured', 'ready', 'process', 'differentials', 'reviews', 'cta'];

        foreach ($sectionKeys as $section) {
            if (isset($_POST[$section]) && is_array($_POST[$section])) {
                PageContent::updateSection('home', $section, $_POST[$section]);
            }
        }

        Session::flash('success', 'Conteúdo da Home atualizado com sucesso!');
        redirect(baseUrl('admin/paginas/home'));
    }

    /**
     * Editar conteúdo do Sobre
     */
    public function editAbout(): void
    {
        $sections = [
            'hero' => ['label' => 'Cabeçalho', 'fields' => [
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Palavra em destaque', 'type' => 'text'],
                'subtitle' => ['label' => 'Subtítulo', 'type' => 'textarea'],
            ]],
            'content' => ['label' => 'Conteúdo Principal', 'fields' => [
                'title' => ['label' => 'Título da seção', 'type' => 'text'],
                'paragraph1' => ['label' => 'Parágrafo 1', 'type' => 'textarea'],
                'paragraph2' => ['label' => 'Parágrafo 2', 'type' => 'textarea'],
                'paragraph3' => ['label' => 'Parágrafo 3', 'type' => 'textarea'],
            ]],
            'cta' => ['label' => 'Chamada para Ação', 'fields' => [
                'title' => ['label' => 'Título', 'type' => 'text'],
                'description' => ['label' => 'Descrição', 'type' => 'textarea'],
                'btn_text' => ['label' => 'Texto do Botão', 'type' => 'text'],
            ]],
        ];

        $contents = [];
        foreach ($sections as $sectionKey => $section) {
            $contents[$sectionKey] = PageContent::getSection('about', $sectionKey);
        }

        $this->view('admin/pages/about', [
            'sections' => $sections,
            'contents' => $contents,
            'pageTitle' => 'Editar Página Sobre',
        ]);
    }

    /**
     * Salvar conteúdo do Sobre
     */
    public function updateAbout(): void
    {
        $this->validateCsrf();

        $sectionKeys = ['hero', 'content', 'cta'];

        foreach ($sectionKeys as $section) {
            if (isset($_POST[$section]) && is_array($_POST[$section])) {
                PageContent::updateSection('about', $section, $_POST[$section]);
            }
        }

        // Upload de imagem do "Sobre"
        if (isset($_FILES['about_image']) && $_FILES['about_image']['error'] === UPLOAD_ERR_OK) {
            $result = Upload::file($_FILES['about_image'], 'pages');
            if ($result['success']) {
                PageContent::updateSection('about', 'content', ['image' => $result['path']]);
            }
        }

        Session::flash('success', 'Conteúdo do Sobre atualizado com sucesso!');
        redirect(baseUrl('admin/paginas/sobre'));
    }

    /**
     * Editar Footer e Contato
     */
    public function editFooter(): void
    {
        $sections = [
            'brand' => ['label' => 'Rodapé - Marca', 'fields' => [
                'description' => ['label' => 'Descrição da empresa', 'type' => 'textarea'],
            ]],
        ];

        $contents = [];
        $contents['brand'] = PageContent::getSection('footer', 'brand');

        // Contato
        $contactSections = [
            'hero' => ['label' => 'Página Contato - Cabeçalho', 'fields' => [
                'title' => ['label' => 'Título (parte normal)', 'type' => 'text'],
                'title_highlight' => ['label' => 'Palavra em destaque', 'type' => 'text'],
                'subtitle' => ['label' => 'Subtítulo', 'type' => 'text'],
            ]],
        ];
        $contactContents = [];
        $contactContents['hero'] = PageContent::getSection('contact', 'hero');

        $this->view('admin/pages/footer', [
            'sections' => $sections,
            'contents' => $contents,
            'contactSections' => $contactSections,
            'contactContents' => $contactContents,
            'pageTitle' => 'Editar Rodapé e Contato',
        ]);
    }

    /**
     * Salvar Footer e Contato
     */
    public function updateFooter(): void
    {
        $this->validateCsrf();

        if (isset($_POST['brand']) && is_array($_POST['brand'])) {
            PageContent::updateSection('footer', 'brand', $_POST['brand']);
        }
        if (isset($_POST['contact_hero']) && is_array($_POST['contact_hero'])) {
            PageContent::updateSection('contact', 'hero', $_POST['contact_hero']);
        }

        Session::flash('success', 'Conteúdo atualizado com sucesso!');
        redirect(baseUrl('admin/paginas/footer'));
    }
}
