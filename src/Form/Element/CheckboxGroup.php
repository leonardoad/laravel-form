<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace LeonardoAD\Form\Form\Element;

use LeonardoAD\Form\Form\Element;

class CheckboxGroup extends Element
{
    protected $options = [];

    public function view()
    {
        return view('form::' . $this->theme . '.element.checkbox-group', [
            'name'        => $this->name,
            'help'        => $this->help,
            'elementName' => $this->elementName,
            'error'       => $this->error,
            'label'       => $this->label,
            'checked'     => $this->value,
            'options'     => $this->options,
            'class'       => $this->class,
            'attributes'  => $this->attributes
        ]);
    }

    public function setOptions($options = [])
    {
        $this->options = $options;

        return $this;
    }

    public function value()
    {
        return $this->value ? : [];
    }
}