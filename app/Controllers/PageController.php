<?php

class PageController extends Controller
{
    /**
     * Página Sobre
     */
    public function about(): void
    {
        $this->view('pages/about', [
            'pageTitle' => 'Sobre Nós',
            'aboutFeatures' => SectionCard::getBySection('about_features'),
            'gallery' => Gallery::getActive(),
            'seo' => [
                'title' => 'Sobre a SOLYRA - Brindes Personalizados & Luminárias',
                'description' => 'Conheça a SOLYRA, especialista em brindes personalizados, luminárias decorativas, peças 3D e presentes criativos. Qualidade e inovação em cada detalhe.',
            ],
        ]);
    }

    /**
     * Página Contato
     */
    public function contact(): void
    {
        $this->view('pages/contact', [
            'pageTitle' => 'Contato',
            'seo' => [
                'title' => 'Contato - SOLYRA',
                'description' => 'Entre em contato com a SOLYRA. Atendimento via WhatsApp, e-mail e redes sociais. Faça seu orçamento.',
            ],
        ]);
    }
}
