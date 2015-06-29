<?php

/*
 * Kontroler logowania
 */

class LoggingController extends Controller {

    public function __construct() {
        parent::__construct();
        
        // Tworzymy model:
        $model = new LoggingModel();
        
        // Tworzymy nowy widok:
        $view = new LoggingView($model);
        
        // Jeśli jest już zalogowany:
        if (Session::isLogged()) {
            $view->generatePage('logged');
        }
        // Jeśli formularz jest niewypełniony w ogóle, to wyświetlamy go pustym:
        elseif ($model->checkIfBlank()) {
            
            $view->generatePage('logging');
        } 
        // W przeciwnym wypadku sprawdzamy, czy przesłane dane są poprawne
        else {
            // Mówimy modelowi by pobrał dane:
            $model->fillFromTable();
            
            // Próbujemy zalogować użytkownika:
            $ifLogged = $model->loginUser();
            
            if ($ifLogged) {
                $view->generatePage('just_logged');
            }
            // Jeśli się nie udało, to wyświetlamy komunikat o błędzie:
            else {
                $view->generatePage('no_such_user');
            }
        }
    }
}