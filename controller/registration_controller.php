<?php

/*
 * Kontroler rejestracji do systemu
 */

class RegistrationController extends Controller {
    
    function __construct($param = '') {
        parent::__construct();
        
        // Tworzymy model:
        $model = new RegistrationModel();
        
        // Tworzymy nowy widok:
        $view = new RegistrationView($model);
        
        // W zależności od tego, czy i jakie dane przekazał użytkownik
        // wyświetlamy odpowiednie rzeczy
        
        // Jeśli użytkownik jest zalogowany nie wyświetlamy mu formularza:
        if (Session::isLogged()) {
            $view->generatePage('logged');
        }      
        // Jeśli formularz jest niewypełniony w ogóle, to wyświetlamy go pustym:
        elseif ($model->checkIfBlank()) {
            echo "Formularz początkowy";
            $view->generatePage('registration');
        } 
        // W przeciwnym wypadku sprawdzamy, czy przesłane dane są poprawne
        else {
            // Mówimy modelowi by pobrał dane:
            $model->fillFromTable();
            
            // Sprawdzamy, czy wprowadzone dane są poprawdne:
            if ($model->checkAll()) {
                // Jeśli są, to dodajemy użytkownika do bazy:
                $ifAddedToDB = $model->addUser();
                
                // Jeśli rejestracja się udała informujemy o tym:
                if ($ifAddedToDB) {
                    $view->generatePage('registered');
                }
                // Jeśli się nie udało, to wyświetlamy komunikaty o błędach:
                else {
                    $view->generatePage('bad_data');
                }
            }
            // Jeśli wprowadzone dane nie są poprawne, to wyświetlamy formularz jeszcze raz z uwagami:
            else {
                $view->generatePage('bad_data');
            }
        }  
    }
}