<?php

namespace KayStrobach\Contact\SecurityCenter\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class LowerCaseViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('value', 'string', 'the string to convert', false, null);
    }

    public function render(): string
    {
        $value = $this->arguments['value'];
        if ($value === null) {
            $value = $this->renderChildren();
        }
        return strtolower($value);
    }
}
