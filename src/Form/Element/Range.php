<?php

namespace LeonardoAD\Form\Form\Element;

use LeonardoAD\Form\Form\Element;

class Range extends Element
{
    public function view()
    {
        return view('form::' . $this->theme . '.element.range', [
            'name'        => $this->name,
            'help'        => $this->help,
            'elementName' => $this->elementName,
            'error'       => $this->error,
            'label'       => $this->label,
            'value'       => $this->value,
            'placeholder' => $this->placeholder,
            'postfix'     => $this->postfix,
            'class'       => $this->class,
            'attributes'  => $this->attributes
        ]);
    }

}