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
    public function getErrorMessages(Form $form)
    {
        $errors = [];
        foreach ($form as $fieldName => $formField) {
            if (!$formField->isValid()) {
                $formErrorIterator = $formField->getErrors(); // formField = form itself (not recursive)

                // saves object keys as array entries and exchanges these entries with their result of getMessage()
                $fieldErrors = array_map(
                    function ($field) {return $field->getMessage();},
                    iterator_to_array($formErrorIterator)
                );
                $errors[$fieldName] = $fieldErrors;
            }
        }

        return $errors;
    }
}
