<?php

/**
 * Created by PhpStorm.
 * User: codeator
 * Date: 27.04.16
 * Time: 15:38
 */

namespace LeonardoAD\Form;

use Illuminate\Support\HtmlString;
use LeonardoAD\Form\Form\Element;
use LeonardoAD\Form\Form\Element\Checkbox;
use LeonardoAD\Form\Form\Element\Hidden;
use LeonardoAD\Form\Form\Element\Password;
use LeonardoAD\Form\Form\Element\Select;
use LeonardoAD\Form\Form\Element\Text;
use LeonardoAD\Form\Form\Element\Submit;
use LeonardoAD\Form\Form\Element\Textarea;

class Form {

    protected $method;
    protected $action;
    protected $theme;
    protected $class;
    protected $elements = [];
    protected $errors = [];
    protected $validated = false;
    protected $name = false;
    protected $isAjax = false;
    protected $enctype;
    protected $template;
    protected $html_elements;

    public function __construct() {
        $this->theme = config('merkeleon.form.theme');
    }

    public static function form() {
        return new static();
    }

    public function method($method = null) {
        $this->method = $method;
        return $this;
    }

    public function isAjax($isAjax) {
        $this->isAjax = $isAjax;
        return $this;
    }

    public function template($tpl) {
        $this->template = $tpl;
        return $this;
    }

    public function route($routeName, $parameters = []) {
        $this->action = route($routeName, $parameters);
        return $this;
    }

    public function action($action) {
        $this->action = $action;
        return $this;
    }

    public function view() {
        return view('form::' . $this->theme . '.form', [
            'elements' => $this->elements,
            'html_elements' => $this->html_elements,
            'method' => $this->method,
            'action' => $this->action,
            'name' => $this->name,
            'class' => $this->class,
            'isAjax' => $this->isAjax,
            'enctype' => $this->enctype,
        ]);
    }

    public function render() {
        $this->setupFormName();
        $this->addElementHidden($this->name)->setValue($this->name);
        $this->renderElements();
        return new HtmlString($this->view()->render());
    }

    public function renderElements() {
        if (!empty($this->template)) {
            foreach ($this->elements as $key => $element) {
                $this->elements[$key] = $element->view()->render();
            }

            $this->html_elements = view($this->template, [
                'elements' => $this->elements
                    ])->render();
        }
    }

    public function isSubmitted() {
        $this->setupFormName();

        return request()->has($this->name) || old($this->name);
    }

    public function setTranslationMask($translationMask = '') {
        $this->translationMask = $translationMask;
        return $this;
    }

    public function setPlaceholderTranslationMask($placeholderTranslationMask = '') {
        $this->placeholderTranslationMask = $placeholderTranslationMask;
        return $this;
    }

    public function setName($name = '') {
        $this->name = $name;
        return $this;
    }

    public function setClass($class = '') {
        $this->class = $class;
        return $this;
    }

    public function addClass($class) {
        $this->class .= ' ' . $class;
        return $this;
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\Text
     */
    public function addElementText($name, $validators = '') {
        $element = new Text($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\DateTime
     */
    public function addElementDateTime($name, $validators = '') {
        $element = new Element\DateTime($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\Date
     */
    public function addElementDate($name, $validators = '') {
        $element = new Element\Date($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\Range
     */
    public function addElementRange($name, $validators = '') {
        $element = new Element\Range($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\File
     */
    public function addElementFile($name, $validators = '') {
        $element = new Element\File($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        $this->enctype = 'multipart/form-data';

        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $view
     * @param array $data
     * @return \LeonardoAD\Form\Form\Element\Delimiter
     */
    public function addElementDelimiter($name, $view = '', $data = []) {
        $element = new Element\Delimiter($name, '');
        $element->setTheme($this->theme)
                ->setContent($view, $data);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    public function addElement(Element $element) {
        $this->elements[$element->getName()] = $element;
        return $this->elements[$element->getName()];
    }

    /**
     * @param $name
     * @param string $content
     * @return \LeonardoAD\Form\Form\Element\Html
     */
    public function addElementHtml($name, $content = '') {
        $element = new Element\Html($name, $content);

        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\Textarea
     */
    public function addElementTextarea($name, $validators = '') {
        $element = new Textarea($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\Hidden
     */
    public function addElementHidden($name, $validators = '') {
        $element = new Hidden($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\Checkbox
     */
    public function addElementCheckbox($name, $validators = '') {
        $element = new Checkbox($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\CheckboxGroup
     */
    public function addElementCheckboxGroup($name, $validators = '') {
        $element = new Element\CheckboxGroup($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\Password
     */
    public function addElementPassword($name, $validators = '') {
        $element = new Password($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\Select
     */
    public function addElementSelect($name, $validators = '') {
        $element = new Select($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;

        return $this->elements[$name];
    }

    /**
     * @param $name
     * @param string $validators
     * @return \LeonardoAD\Form\Form\Element\Radio
     */
    public function addElementRadio($name, $validators = '') {
        $element = new Element\Radio($name, $validators);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;

        return $this->elements[$name];
    }

    /**
     * @param string $name
     * @return \LeonardoAD\Form\Form\Element\Submit
     */
    public function addElementSubmit($name = 'submit') {
        $element = new Submit($name);
        $element->setTheme($this->theme);

        $this->elements[$name] = $element;
        return $this->elements[$name];
    }

    public function getElement($name) {
        return isset($this->elements[$name]) ? $this->elements[$name] : null;
    }

    public function getElements($names = null) {
        if ($names === null) {
            return $this->elements;
        }
        if (!is_array($names)) {
            $names = func_get_args();
        }
        return array_only($this->elements, $names);
    }

    public function validate($force = false) {
        if (!$this->isSubmitted() && !$force) {
            return false;
        }

        if (!$this->validated) {
            $keys = array_keys($this->elements);
            foreach ($this->elements as $name => $element) {
                if (!$element->isIgnored()) {
                    if (!$element->validate($keys)) {
                        array_set($this->errors, $name, $element->error());
                    }
                }
            }
            $this->validated = true;
        }

        return count($this->errors) < 1;
    }

    public function errors() {
        if (!$this->validated) {
            $this->validate();
        }
        return $this->errors;
    }

    public function values($skipEmptyString = false) {
        $data = [];
        foreach ($this->elements as $name => $element) {
            if (!$element->isIgnored()) {
                $value = $element->value();
                if (!$skipEmptyString || $skipEmptyString && $value !== '') {
                    array_set($data, $name, $value);
                }
            }
        }

        return $data;
    }

    public function value($name, $default = null) {
        return array_get($this->values(), $name, $default);
    }

    public function setValues($values = []) {
        foreach ($this->elements as $name => $element) {
            $value = array_get($values, $name);

            if ($value !== null) {
                $element->setValue($value);
            }
        }

        return $this;
    }

    public function setTheme($theme = '') {
        $this->theme = $theme;
        return $this;
    }

    public function redirectToRoute($route, $attributes = []) {
        return redirect()->route($route, $attributes)->withErrors($this->errors)->withInput();
    }

    public function redirectBack($additionalErrors = []) {
        $errors = array_merge($additionalErrors, $this->errors());

        return redirect()->back()->withErrors($errors)->withInput();
    }

    private function setupFormName() {
        if (!$this->name) {
            $this->name = md5(implode('.', array_keys($this->elements)));
        }
    }

}
