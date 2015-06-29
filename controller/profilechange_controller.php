<?php

/*
 * Kontroler zmiany danych profilowych
 */

class ProfilechangeController extends Controller {
    
    function __construct($param = '') {
        parent::__construct();
        
        // Tworzymy model:
        $model = new ProfilechangeModel();
        
        // Tworzymy nowy widok:
        $view = new ProfilechangeView($model);
        
        // Sprawdzamy, czy użytkownik jest zalogowany
        if (!Session::isLogged()) {
            // Jeśli nie jest, to:
            $view->generatePage('access_violation');
        }        
        // Jeśli jest zalogowany, to ładujemy formularz z danymi z bazy danych
        elseif ($model->checkIfBlank()) {
            echo "Formularz początkowy:<br />";
            
            // Ładujemy dane z bazy danych:
            $model->loadData(Session::getUsername());
            
            // Wyświetlamy formularz:
            $view->generatePage('changing');
        }
        // Jeśli użytkownik przesłał jakieś dane:
        else {
            // Mówimy modelowi by załadował dane:
            $model->fillFromTable();
            
            // Sprawdzamy, czy wprowadzone dane są poprawdne:
            if ($model->checkAll()) {
                // Jeśli są, to dodajemy nowe dane do bazy:
                $ifAddedToDB = $model->changeData();
                
                // Jeśli rejestracja się udała informujemy o tym:
                if ($ifAddedToDB) {
                    $view->generatePage('changed');
                }
                // Jeśli się nie udało, to wyświetlamy komunikat o błędzie:
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