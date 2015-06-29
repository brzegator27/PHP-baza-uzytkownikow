<?php

/*
 * Kontroller głównej strony:
 */

class MainpageController extends Controller {

    public function __construct() {
        parent::__construct();

        // Tworzymy nowy widok:
        $view = new MainpageView();
        
        // Sprawdzamy, czy użytkownik jest zalogowany:
        $isLogged = Session::isLogged();
        
        if ($isLogged) {
            $view->generatePage('logged');
        } else {
            $view->generatePage('');
        }
    }
}
