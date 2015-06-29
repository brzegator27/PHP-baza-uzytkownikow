<?php

/*
 * Model odpowiedzialny za usuwanie konta użytkownika
 */

class DeleteaccModel extends Database {
    /*
     * Wystarczy zakomentować jakąś linijkę w poniższej tablicy, by wyżucić to z formularza.
     */
    // Tablica z nazwami i opisami pól formularza:
    protected $fields = array(
        //'username' => 'login',
        //'first_name' => 'imię',
        //'last_name' => 'nazwisko',
        //'email' => 'email',
        //'street' => 'ulica',
        //'city' => 'miasto',
        //'zip_code' => 'kod pocztowy',
        //'house_nr' => 'numer domu',
        //'apartment_nr' => 'numer mieszkania',
        'password' => 'hasło'
    );
    
    function __construct() {
        parent::__construct();
        
        // Tworzymy tablicę:
        $this->nullifyForm();
        
        // Uzupełniamy naszą tablicę
        $this->fillFromTable();
    }
    
    // Funkcja logująca użytkownika
    public function deleteUser() {
        // Łączymy się z bazą danych:
        $conn = new mysqli(Config::DB_HOSTNAME, Config::DB_R_USERNAME, Config::DB_R_PASSWORD, Config::DB_DATABASE_NAME);

        // Sprawdzamy, czy nawiązanie połączenia się powiodło:
        if ($conn->connect_error) {
            // Die - podobnie jak exit - wyświetla wiadomość i kończy wykonywanie skryptu
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Sprawdzamy, czy podane dane są zgodne z tymi w bazie danych:
        $isCompatible = $this->checkUserDataWithDB();
        
        if(!$isCompatible) {
            return FALSE;
        }
        
        // Tworzymy nasze zapytanie:
        $query = 'DELETE FROM users WHERE username=\''.Session::getUsername().'\'';

        // Wykonujemy zapytanie:
        if($conn->query($query)) {
            $conn->close();

            return TRUE;
        }
        else {
            $conn->close();
            return FALSE;
        }
    }
}