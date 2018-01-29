<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace LeonardoAD\Form\Form\Element;

use LeonardoAD\Form\Form\Element;

class Textarea extends Element
{
    public function view()
    {
        return view('form::' . $this->theme . '.element.textarea', [
            'name'        => $this->name,
            'help'        => $this->help,
            'elementName' => $this->elementName,
            'error'       => $this->error,
            'label'       => $this->label,
            'value'       => $this->value,
            'placeholder' => $this->placeholder,
            'class'       => $this->class,
            'attributes'  => $this->attributes
        ]);
    }

}