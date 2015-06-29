<?php

/*
 * Kontroler usuwania konta - delete account
 */

class DeleteaccController extends Controller {

    public function __construct() {
        parent::__construct();
        
        // Tworzymy model:
        $model = new DeleteaccModel();
        
        // Tworzymy nowy widok:
        $view = new DeleteaccView($model);
        
        // Sprawdzamy, czy użytkownik jest zalogowany
        if (!Session::isLogged()) {
            $view->generatePage('access_violation');
            // Wychodzimy z funkcji:
            return;
        }
        
        // Jeśli dane nie zostały nam przesłane:
        if ($model->checkIfBlank()) {
            $view->generatePage('blank');
        } 
        // Jeśli dane zostały nam przesłane:
        else {
            // Próbujemy usunąć konto:
            $ifDeleted = $model->deleteUser();
            
            if ($ifDeleted) {
                Session::logOut();
                $view->generatePage('deleted');
            }
            // Jeśli się nie udało, to wyświetlamy komunikat o błędzie:
            else {
                $view->generatePage('failed');
            }
        }
    }
}