<?php

/*
 * Model odpowiedzialny za logowanie
 */

class LoggingModel extends Forms {
    /*
     * Wystarczy zakomentować jakąś linijkę w poniższej tablicy, by wyżucić to z formularza.
     */
    // Tablica z nazwami i opisami pól formularza:
    protected $fields = array(
        'username' => 'login',
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
        //echo "Jestem konstruktorem klasy RegistrationModel!";
        
        // Tworzymy tablicę:
        $this->nullifyForm();
        
        // Uzupełniamy naszą tablicę
        $this->fillFromTable();
    }
    
    // Funkcja logująca użytkownika
    public function loginUser() {
        // Łączymy się z bazą danych:
        $conn = new mysqli(Config::DB_HOSTNAME, Config::DB_L_USERNAME, Config::DB_L_PASSWORD, Config::DB_DATABASE_NAME);

        // Sprawdzamy, czy nawiązanie połączenia się powiodło:
        if ($conn->connect_error) {
            // Die - podobnie jak exit - wyświetla wiadomość i kończy wykonywanie skryptu
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Szyfrujemy hasło, jeśli jest przekazywane:
        if (isset($this->passedForm['password'])) {
            $this->passedForm['password'] = md5($this->passedForm['password']);
        }
        
        // Formatujemy dane przed wysłaniem:
        foreach ($this->passedForm as $key => $value) {
            $value = $conn->real_escape_string($value);
            $this->passedForm[$key]  = $conn->real_escape_string($value);
        }

        // Tworzymy nasze żądanie:\
        $query = 'SELECT * FROM users WHERE ';
        
        foreach ($this->passedForm as $key => $value) {
            $query .= ' ('.$key.'=\''.$value.'\') AND';
        }
        
        // Obcinamy ostatnie AND:
        $query = substr($query, 0, -4);

        // Wykonujemy zapytanie:
        $output = $conn->query($query);
        
        if($output->num_rows > 0) {
            $conn->close();
            
            // Tworzymy sesję:
            Session::logIn($this->passedForm['username']);

            return TRUE;
        }
        else {
            $conn->close();
            return FALSE;
        }
    }
}