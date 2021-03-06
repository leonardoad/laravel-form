<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 24.06.16
 * Time: 17:50
 */

namespace LeonardoAD\Form\Form\Element;


use LeonardoAD\Form\Form\Element;

class Html extends Element
{
    protected $content   = '';
    protected $isIgnored = true;

    public function __construct($name, $content)
    {
        parent::__construct($name);
        $this->name    = $name;
        $this->content = $content;
    }

    public function validate($keys)
    {
        return true;
    }

    public function view()
    {
        if(empty($this->content)){
            $this->content = $this->value();
        }
        return view('form::' . $this->theme . '.element.html', [
            'label'   => $this->label,
            'content' => $this->content
        ]);
    }
}