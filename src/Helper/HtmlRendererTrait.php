<?php

namespace Alura\Mvc\Helper;

trait HtmlRendererTrait
{
    private function renderTemplate(string $templateName, array $context = [])
    {
        $templatePath = __DIR__ . '/../../View/';
        extract($context);
        ob_start();
        require_once $templatePath . $templateName . '.php';
        return ob_get_clean();
    }
}