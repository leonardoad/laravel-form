<?php
/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 28.04.16
 * Time: 11:33
 */

namespace LeonardoADForm\Form\Element;

use LeonardoADForm\Form\Element;

class Hidden extends Element
{

    public function view()
    {
        return view('form::' . $this->theme . '.element.hidden', [
            'name'        => $this->name,
            'elementName' => $this->elementName,
            'error'       => $this->error,
            'value'       => $this->value,
            'class'       => $this->class,
            'attributes'  => $this->attributes
        ]);
    }

}