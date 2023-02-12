<?php

class Form
{
    private $inputs = [];

//    public  function __construct() {
//
//    }
//    public function __construct(array $inputs)
//    {
//        foreach ($inputs as $input) {
//            $this->inputs[] = new Input($input['label'], $input['type'], $input['name'], $input['placeholder'], $input['parameter']);
//        }
//    }

    public function print(): void
    {
        foreach ($this->inputs as $input) {
            echo '<div class="for_input">
                <label>'.$input->label.'</label>
                <input type="'.$input->type.'" name="'.$input->name.'" placeholder="'.$input->placeholder.'"'.$input->parameter.'>
                <p class="error_block"></p>
            </div>';
        }
    }

    public function setInput($label, $type, $name, $placeholder, $parameter='') {
        $this->inputs[] = new Input($label, $type, $name, $placeholder, $parameter);
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

}

class Input
{
    private $label;
    private $type;
    private $name;
    private $placeholder;
    private $parameter;

    public function __construct($label, $type, $name, $placeholder, $parameter='')
    {
        $this->label = $label;
        $this->type = $type;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->parameter = $parameter;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

}



