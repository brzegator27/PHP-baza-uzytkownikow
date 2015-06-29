<?php

/*
 * Kontroler zarządzający wyświetlaniem profilu użytkownika
 */

class ProfileController extends Controller {

    public function __construct() {
        parent::__construct();

        // Tworzymy model:
        $model = new ProfileModel();
        
        // Tworzymy nowy widok:
        $view = new ProfileView($model);
        
        // Sprawdzamy, czy użytkownik jest zalogowany:
        $isLogged = Session::isLogged();
        
        if ($isLogged) {
            $model->loadUserData(Session::getUsername());
            
            // Jeśli ktoś jest zalogowany, to wyświetlamy o nim jego dane:
            $view->generatePage('user_data');
        } else {
            // Próba wejścia przez nieupoważnioną osobę, która nie jest zalogowana
            $view->generatePage('access_violation');
        }
    }
}

