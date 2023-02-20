<?php

class Category
{
    private $id;
    private $name;
    private $parent_id;
    private $children = array();
    private $parents = array();

    public function __construct($categoryInfo)
    {
        $this->id = $categoryInfo['category_id'];
        $this->name = $categoryInfo['name'];
        $this->parent_id = $categoryInfo['parentcategory_id'];
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

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public function setChildren(&$children) {
        foreach ($children as $key => $child) {
            if ($this->id == $child->parent_id) {
                $this->children[] = $child;
                unset($children[$key]);
            }
        }
    }

    public function isParent(){
        return (bool)$this->children;
    }

    public function isChild() {
        return (bool)$this->parents;
    }

    public function printAsCheckSelect() {
        echo '<fieldset><legend>'.$this->name.'</legend>';

        foreach ($this->children as $child) {
            if (!$child->isParent()) {
                echo '<label><input data-parents="'.$child->getAllParents().'" data-id="'.$child->id.'" name="categories[]" value="'.$child->name.'" type="checkbox">'.$child->name.'</label>';
            } else {
                $child->printAsCheckSelect();
            }
        }
        echo '</fieldset>';

    }

    public function getAllParents() {
        $parents = "";
        foreach ($this->parents as $key => $parent) {
            $parents .= $parent;
            if ($key+1 != count($this->parents))
                $parents .= ' ';
        }
        return $parents;
    }

    public function setAllParents() {
        foreach ($this->children as $child) {
            foreach ($this->parents as $parent){
                $child->parents[] = $parent;
            }
            $child->parents[] = $this->id;
            $child->setAllParents();
        }
    }

}