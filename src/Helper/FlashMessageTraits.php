<?php
namespace Alura\Mvc\Helper;

trait FlashMessageTraits
{

    private function addErrorMessage(string $errorMessage)
    {
        $_SESSION['error_message'] = $errorMessage;
    }

}