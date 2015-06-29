<?php
/**
 * Klasa ze statycznymi metodami za pomocą których można zarządać sesją
 */

class Session {
    // Funckcja sprawdzająca, czy sesja była już rozpoczęta,
    // jeśli nie to ją rozpoczyna
    static function sessionStart() {
        // Sprawdzamy, czy sesja była już rozpoczęta
        // Jeśli wersja PHP < 5.4.0, to:
        // if (session_status() == '') {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    // Funkcja logująca użytkownika - tworzy ciasteczka
    static function logIn($username) {
        if (isset($username)) {
            Session::sessionStart();
            $_SESSION['username'] = $username;
        } else {
            throw new Exception('Musisz podać login użytkownika, który ma zostać zalogowany!');
        }
    }
    
    // Możemy sprawdzić, czy jest zalogowany:
    static function isLogged() {
        Session::sessionStart();
        
        // Sprawdzamy, czy użytkownik o takim loginie jest w bazie danych:
        if (isset($_SESSION['username'])) {
            // Tworzymy krótszą nazwę
            $username = $_SESSION['username'];
            
            // Sprawdzamy, czy dany użytkownik istnieje w naszej bazie:
            if (Model::whetherExists($username, 'username')) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
    }
    
    // Funkcja pobierająca login aktualnie zalogowane użytkownika
    static function getUsername() {
        // Session::isLogged() wywołuje pośrednio sessionStart, więc my tutaj tego nie robimy
        if (Session::isLogged()) {
            return $_SESSION['username'];
        } else {
            throw new Exception('Użytkownik nie jest zalogowany, więc nie możesz pobrać jego loginu!');
        }
    }
    
    // Funkcja usuwająca cisasteczka, które świadczą o zalogowaniu
    static function logOut() {
        Session::sessionStart();
            
        if (session_destroy()) {
            // Możemy przejść automatycznie na stronę główną:
            // header('Location: index.php');  
            
            return TRUE;
        }
        
        return FALSE;
    }
}
