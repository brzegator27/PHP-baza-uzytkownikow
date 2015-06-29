<?php

/*
 * Klasa nadrzędna dla modelów zarządzającymi bazą danych; zawiera podstawowe funkcje
 */

class Database extends Forms {
    
    // Funkcja sprawdzająca poprawność dantch użytkownika
    public function checkUserDataWithDB() {
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
        // Hasło musi zostać zaszyfrowane przed formatowaniem danych
        foreach ($this->passedForm as $key => $value) {
            $value = $conn->real_escape_string($value);
            $this->passedForm[$key]  = $conn->real_escape_string($value);
        }

        // Tworzymy nasze żądanie:\
        $query = 'SELECT * FROM users WHERE ';
        
        foreach (array_keys($this->fields) as $key) {
                $query .= ' ('.$key.'=\''.$this->passedForm[$key].'\') AND ';
        }
        
        $query .= '(username=\''.Session::getUsername().'\')';
        
        // Wykonujemy zapytanie:
        $output = $conn->query($query);
        
        if($output->num_rows > 0) {
            $conn->close();
            echo "Tutaj w check";
            return TRUE;
        }
        else {
            $conn->close();
            return FALSE;
        }
    } 
}
