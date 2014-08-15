<?php

namespace Barra\BackBundle\Service;

use Symfony\Component\Form\Form;

class FormValidation
{
    public function __construct($param)
    {
        $this->unusedParam = $param;
    }

    /**
     * @param Form $form
     * @return array[fieldName][number] e.g. array['name'][0]
     */
    public function getErrorMessages(Form $form) {
        $errors = array();
        $formErrors = $form->getErrors();

        foreach ($formErrors as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid())
                $errors[$child->getName()] = $this->getErrorMessages($child);
        }
        return $errors;
    }
}