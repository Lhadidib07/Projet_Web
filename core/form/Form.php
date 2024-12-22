<?php

namespace form;

class Form
{
    public static function begin($action, $method)
    {
        echo "<form action='$action' method='$method'>";
        return new Form();
    }

    public static function end()
    {
        echo "</form>";
    }

    public function field(BaseField $field)
    {
        echo $field->render();
    }

}