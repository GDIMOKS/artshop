<?php

class Form
{
    protected $inputs = [];
    protected $form;

    public  function __construct($name) {
        $this->form = $name;
    }

    public function print()
    {
        foreach ($this->inputs as $input) {
            switch ($input->type) {
                case 'checkbox':
                    echo '<div class="for_checkbox">
                            <input class="custom_checkbox" type="'.$input->type.'" name="'.$input->name.'" placeholder="'.$input->placeholder.'">
                            <label>'.$input->label.'</label>
                        </div>';
                    break;

                case 'file':
                    '<div class="for_image">
                        <label>'.$input->label.'</label>
                        <input type="'.$input->type.'" name="'.$input->name.'" placeholder="'.$input->placeholder.'"'.$input->parameter.'>
                        <p class="error_block"></p>
                        </div>';
                    break;
//
//                case 'file':
//                    break;
//
//                case 'file':
//                    break;

                default:
                    echo '<div class="for_input">
                        <label>'.$input->label.'</label>
                        <input type="'.$input->type.'" name="'.$input->name.'" placeholder="'.$input->placeholder.'"'.$input->parameter.'>
                        <p class="error_block"></p>
                        </div>';
                    break;
            }

        }
    }

    public function setInput($label, $type, $name, $placeholder, $parameter='', $class='') {
        $this->inputs[] = new Input($label, $type, $name, $placeholder, $parameter, $class);
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
}

class ProductForm extends Form {
    private $class;
    private $button;
    private $categories = array();
    private $pairInputs = array();

    public  function __construct($name, $class, $submit_name) {
        $this->class = $class;
        $this->button = $submit_name;
        parent::__construct($name);
    }

    public function fillForm($connection) {
        $this->setInput('??????????????????????', 'file', 'imageHREF', '???????????????? ??????????????????????', '', 'grid-item photo');
        $this->setInput('???????????????? ??????????????*', 'text', 'name', '?????????????? ????????????????', '', 'grid-item name');
        $this->setInput('???????? ????????????????', 'number', 'creation_date', '?????????????? ?????? ????????????????', '', 'grid-item date');

        $this->setPairInput('prices',
            new Input('???????? ??????????????*', 'number', 'purchase_price', '?????????????? ???????? ??????????????', '', 'grid-item purchase_price'),
            new Input('???????? ??????????????*', 'number', 'selling_price', '?????????????? ???????? ??????????????', '', 'grid-item selling_price'));

//        $this->setAuthors($connection);
        $this->setCategories($connection);
    }

    public function setCategories($connection) {
        $query = "SELECT * FROM categories";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($categories as $category) {
            $this->categories[] = new Category($category);
        }

        foreach ($this->categories as $category) {
            $category->setChildren($this->categories);
            $category->setAllParents();
        }
    }


    public function setPairInput($class, $input1, $input2) {
        $pairInput = [
                'class'=>$class,
                'input1'=>$input1,
                'input2'=>$input2];

        $this->pairInputs[] = $pairInput;
    }


    public function printCategoriesSelect() {
        echo '<div class="grid-item category">
                <label>??????????????????*</label>
                <div class="checkselect">
                    <div class="checkselect-control">
                        <select name="categories" class="form-control"><option></option></select>
                        <div class="checkselect-over"></div>
                    </div>
                    <div class="checkselect-popup">';
        foreach ($this->categories as $category) {
            if (!$category->isChild()) {
                $category->printAsCheckSelect();
            }
        }
        echo '    </div>
                    <p class="error_block"></p>
                </div>
              </div>';
    }

    public function printPairInputs(){
        foreach ($this->pairInputs as $input) {
            echo '<div class="'.$input['class'].'">';
            $input['input1']->print();
            $input['input2']->print();
            echo '</div>';
        }
    }

    public function print() {
        global $connection;
        $this->fillForm($connection);

        echo '<form class="'.$this->class.'" name="'.$this->form.'">';
        echo '<div class="grid-container">';
        foreach ($this->inputs as $input) {
            $input->print();
        }

        $this->printPairInputs();

        $this->printCategoriesSelect($connection);
        echo '    </div>
                <input class="button" type="submit" value="'.$this->button.'">
                <div class="error_block"></div>
              </form>';
    }
}

class ClientForm extends Form {
    private $class;
    private $button;

    public  function __construct($name, $class, $submit_name) {
        $this->class = $class;
        $this->button = $submit_name;
        parent::__construct($name);
    }

    public function fillForm() {
        $this->setInput('??????*', 'text', 'first_name', '?????????????? ??????', '', 'grid-item first_name');
        $this->setInput('??????????????', 'text', 'last_name', '?????????????? ??????????????', '', 'grid-item last_name');
        $this->setInput('????????????????', 'text', 'patronymic_name', '?????????????? ????????????????', '', 'grid-item patronymic_name');
        $this->setInput('?????????????????????? ??????????*', 'email', 'email', '?????????????? ?????????????????????? ??????????', '', 'grid-item email');
        $this->setInput('???????? ????????????????', 'date', 'birthday', '???????????????? ???????? ????????????????', '', 'grid-item birthday');
        $this->setInput('?????????? ????????????????', 'text', 'phone', '?????????????? ?????????? ????????????????', '', 'grid-item phone');
    }

    public function print() {
        $this->fillForm();

        echo '<form class="'.$this->class.'" name="'.$this->form.'">';
        echo '<div class="grid-container">';
        foreach ($this->inputs as $input) {
            $input->print();
        }

        echo '    </div>
                <input class="button" type="submit" value="'.$this->button.'" style="margin-top: 30px">
                <div class="error_block"></div>
              </form>';
    }
}

class Input
{
    private $label;
    private $class;
    private $type;
    private $name;
    private $placeholder;
    private $parameter;

    public function __construct($label, $type, $name, $placeholder, $parameter='', $class='')
    {
        $this->label = $label;
        $this->type = $type;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->parameter = $parameter;
        $this->class = $class;
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

    public function print(): void
    {
        switch ($this->type) {

            case 'file':
                echo '<div class="'.$this->class.'">
                        <div class="image_container">
                            <img class="picture" src="" alt="'.$this->label.'" >
                        </div>
                      </div>
                      <div class="grid-item '.$this->type.'">
                        <label>'.$this->label.'</label>
                        <input type="'.$this->type.'" name="'.$this->name.'">
                        <p class="error_block"></p>
                      </div>';
                break;

            default:
                echo '<div class="' . $this->class . '">
                        <label>' . $this->label . '</label>
                        <input type="' . $this->type . '" name="' . $this->name . '" placeholder="' . $this->placeholder . '"' . $this->parameter . '>
                        <p class="error_block"></p>
                      </div>';
                break;
        }
    }
}



