<?php

namespace Controllers;

class SiteController
{
    public function home()
    {
        return 'Home Page';
    }

    public function handleContact(): string
    {
        return 'Handling the submitted data';
    }
}