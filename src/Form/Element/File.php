<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace LeonardoAD\Form\Form\Element;

use LeonardoAD\Form\Form\Element;

class File extends Element
{
    protected $isMultiple = false;

    public function setMultiple($multiple = true)
    {
        $this->isMultiple = $multiple;

        return $this;
    }

    public function view()
    {
        return view('form::' . $this->theme . '.element.file', [
            'name'        => $this->name,
            'help'        => $this->help,
            'elementName' => $this->elementName,
            'error'       => $this->error,
            'label'       => $this->label,
            'placeholder' => $this->placeholder,
            'class'       => $this->class,
            'multiple'    => $this->isMultiple,
            'attributes'  => $this->attributes
        ]);
    }

}