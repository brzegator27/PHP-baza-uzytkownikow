<?php

/*
 * Kontroler wylogowywania
 */

class LogoutController extends Controller {

    public function __construct() {
        parent::__construct();
        //echo "Kontroller logowania<br />";

        // Tworzymy nowy widok:
        $view = new LogoutView();
        
        // Próbujemy usunąć sesję:
        $isSuccessful = Session::logOut();
        
        // Sprawdzamy, czy nam się udało usunąć sesję:
        if ($isSuccessful) {
            $view->generatePage('loggedout');
        } else {
            $view->generatePage('failed');
        }
    }
}
