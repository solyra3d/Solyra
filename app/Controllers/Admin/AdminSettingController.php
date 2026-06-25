<?php

class AdminSettingController extends Controller
{
    protected string $layout = 'admin';

    /**
     * Configurações disponíveis organizadas por grupo
     */
    private array $settingGroups = [
        'Informações da Empresa' => [
            'site_name' => ['label' => 'Nome da Empresa', 'type' => 'text'],
            'site_slogan' => ['label' => 'Slogan', 'type' => 'text'],
            'site_email' => ['label' => 'E-mail', 'type' => 'email'],
            'site_phone' => ['label' => 'Telefone', 'type' => 'text'],
            'site_whatsapp' => ['label' => 'WhatsApp (com DDD)', 'type' => 'text'],
            'site_address' => ['label' => 'Endereço', 'type' => 'textarea'],
            'site_hours' => ['label' => 'Horário de Atendimento', 'type' => 'text'],
        ],
        'Redes Sociais' => [
            'social_instagram' => ['label' => 'Instagram (URL)', 'type' => 'url'],
            'social_facebook' => ['label' => 'Facebook (URL)', 'type' => 'url'],
            'social_tiktok' => ['label' => 'TikTok (URL)', 'type' => 'url'],
            'site_youtube' => ['label' => 'YouTube (URL do canal ou vídeo)', 'type' => 'url'],
        ],
        'SEO' => [
            'seo_title' => ['label' => 'Meta Title (Home)', 'type' => 'text'],
            'seo_description' => ['label' => 'Meta Description (Home)', 'type' => 'textarea'],
            'google_analytics' => ['label' => 'Google Analytics ID', 'type' => 'text'],
            'google_tag_manager' => ['label' => 'Google Tag Manager ID', 'type' => 'text'],
        ],
        'Aparência' => [
            'site_logo' => ['label' => 'Logo da Empresa', 'type' => 'file', 'preview' => 'circle'],
            'site_favicon' => ['label' => 'Favicon (URL ou upload)', 'type' => 'text'],
            'hero_image' => ['label' => 'Imagem Fixa do Hero (Home)', 'type' => 'file', 'preview' => 'rect'],
        ],
    ];

    public function index(): void
    {
        // Carregar todas as configurações atuais
        $rows = Database::fetchAll("SELECT setting_key, setting_value FROM settings");
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        $this->view('admin/settings/index', [
            'settings' => $settings,
            'settingGroups' => $this->settingGroups,
            'pageTitle' => 'Configurações',
        ]);
    }

    public function update(): void
    {
        $this->validateCsrf();

        // Iterar por todos os campos definidos e salvar
        foreach ($this->settingGroups as $fields) {
            foreach ($fields as $key => $config) {
                // Handle file upload
                if ($config['type'] === 'file') {
                    if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
                        $result = Upload::file($_FILES[$key], 'logo');
                        if ($result['success']) {
                            $value = $result['path'];
                        } else {
                            continue; // Skip if upload failed
                        }
                    } else {
                        continue; // Keep existing value if no new file
                    }
                } else {
                    $value = $this->input($key, '');
                }

                // Verificar se já existe
                $existing = Database::fetchOne(
                    "SELECT id FROM settings WHERE setting_key = ?",
                    [$key]
                );

                if ($existing) {
                    Database::update('settings', ['setting_value' => $value], 'setting_key = ?', [$key]);
                } else {
                    Database::insert('settings', [
                        'setting_key' => $key,
                        'setting_value' => $value,
                    ]);
                }
            }
        }

        Session::flash('success', 'Configurações salvas com sucesso!');
        redirect('/admin/configuracoes');
    }
}
