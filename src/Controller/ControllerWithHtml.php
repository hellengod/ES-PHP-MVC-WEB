<?php

namespace Alura\Mvc\Controller;
abstract class ControllerWithHtml
{

    private const TEMPLATE_PATH = __DIR__ .   '/../../View/';
    protected function renderTamplate(string $templateName, array $context = [])
    {

        extract($context);

        require_once self::TEMPLATE_PATH . $templateName . '.php';
    }
}