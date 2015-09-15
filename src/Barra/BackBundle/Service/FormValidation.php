<?php

namespace Barra\BackBundle\Service;

use Symfony\Component\Form\Form;

/**
 * Class FormValidation
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Service
 */
class FormValidation
{
    /**
     * @param mixed $param
     */
    public function __construct($param)
    {
        $this->unusedParam = $param;
    }

    /**
     * returns [fieldName][number] e.g. array['name'][0]
     * @param Form $form
     * @return array
     */
    public function getErrorMessages(Form $form)
    {
        $errors = [];
        foreach ($form as $fieldName => $formField) {
            if (!$formField->isValid()) {
                $formErrorIterator = $formField->getErrors(); // formField = form itself (not recursive)

                // saves object keys as array entries and exchanges these entries with their result of getMessage()
                $fieldErrors = array_map(
                    function ($field) {
                        return $field->getMessage();
                    },
                    iterator_to_array($formErrorIterator)
                );
                $errors[$fieldName] = $fieldErrors;
            }
        }

        return $errors;
    }
}
