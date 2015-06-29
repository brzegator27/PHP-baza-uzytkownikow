<?php

class ProfileModel extends Model {
    /*
     * Wystarczy zakomentować jakąś linijkę w poniższej tablicy, by wyżucić to z formularza.
     */
    // Tablica z nazwami i opisami pól wyświetlanymi w profilu:
    private $fields = array(
        'username' => 'login',
        'first_name' => 'imię',
        'last_name' => 'nazwisko',
        'email' => 'email',
        'street' => 'ulica',
        'city' => 'miasto',
        'zip_code' => 'kod pocztowy',
        'house_nr' => 'numer domu',
        'apartment_nr' => 'numer mieszkania',
        //'password' => 'hasło'
    );
        
    // Zmienna na tablicę z danymi z formularza:
    private $userData;
    
    function __construct() {
        parent::__construct();
    }
    
    // Zakładamy, że to kontroler zadbał o sprawczenie, czy użytkownik jest zalogowany
    public function loadUserData($username) {
        // Łączymy się z bazą danych, korzystamy z tego samego połączenia, co dla logowania:
        $conn = new mysqli(Config::DB_HOSTNAME, Config::DB_L_USERNAME, Config::DB_L_PASSWORD, Config::DB_DATABASE_NAME);

        // Sprawdzamy, czy nawiązanie połączenia się powiodło:
        if ($conn->connect_error) {
            // Die - podobnie jak exit - wyświetla wiadomość i kończy wykonywanie skryptu
            die("Connection failed: " . $conn->connect_error);
        }
        
        foreach (array_keys($this->fields) as $key) {
            // Dla każdego pola tworzymy zapytanie:
            $query = 'SELECT '.$key.' FROM users WHERE username=\''.$username.'\'';
            
            $output = $conn->query($query);

            if ($output->num_rows > 0) {
                $output->data_seek(0);
                $data = $output->fetch_assoc();
                
                $this->userData[$key] = $data[$key];

            } else {
                throw new Exception("Danych nie udało się pobrać!");
            }
        }
        $conn->close();
    }
    
    public function getFields() {
        return $this->fields;
    }
    
    public function getValue($key) {
        return $this->userData[$key];
    }
}