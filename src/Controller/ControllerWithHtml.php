<?php

namespace Alura\Mvc\Controller;
abstract class ControllerWithHtml implements Controller
{

    private const TEMPLATE_PATH = __DIR__ . '/../../View/';
    protected function renderTemplate(string $templateName, array $context = [])
    {

        extract($context);
        ob_start();
        require_once self::TEMPLATE_PATH . $templateName . '.php';
        return ob_get_clean();
    }
}