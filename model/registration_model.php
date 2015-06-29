<?php

class RegistrationModel extends Forms {
    /*
     * Wystarczy zakomentować jakąś linijkę w poniższej tablicy, by wyżucić to z formularza.
     */
    // Tablica z nazwami i opisami pól formularza:
    protected $fields = array(
        'username' => 'login',
        'first_name' => 'imię',
        'last_name' => 'nazwisko',
        'email' => 'email',
        'street' => 'ulica',
        'city' => 'miasto',
        'zip_code' => 'kod pocztowy',
        'house_nr' => 'numer domu',
        'apartment_nr' => 'numer mieszkania',
        'password' => 'hasło'
    );
    
    // Tablica wyrażeń, które muszą być unikalne dla każdego użytkownika:
    protected $uniq_data = array(
        'username',
        'email'
    );

    function __construct() {
        parent::__construct();
        //echo "Jestem konstruktorem klasy RegistrationModel!";
        
        // Tworzymy tablicę:
        $this->nullifyForm();
        
        // Uzupełniamy naszą tablicę
        $this->fillFromTable();
    }
    
    public function addUser() {
        // Łączymy się z bazą danych:
        $conn = new mysqli(Config::DB_HOSTNAME, Config::DB_R_USERNAME, Config::DB_R_PASSWORD, Config::DB_DATABASE_NAME);

        // Sprawdzamy, czy nawiązanie połączenia się powiodło:
        if ($conn->connect_error) {
            // Die - podobnie jak exit - wyświetla wiadomość i kończy wykonywanie skryptu
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Sprawdzamy unikalność odpowiednich danych:
        $whetherExists = FALSE;
        foreach($this->uniq_data as $key) {
            $temp = $this->whetherExists($this->passedForm[$key], $key);
            
            if ($temp == TRUE) {$this->passedFormMsg[$key.'_msg'] .= 'Taki/e '.$this->fields[$key].' już istnieje w naszej bazie.';}
            
            $whetherExists = $whetherExists || $temp;
        }
        
        if (!$whetherExists) {
            // Jeśli hasło zostało przekazane, to szyfrujemy za pomocą MD5:
            if (isset($this->passedForm['password'])) {
                $this->passedForm['password'] = md5($this->passedForm['password']);
            }
            
            // Tworzymy nasze żądanie:\
            $query = "INSERT INTO users (";

            // Przetwarzamy dane przed wrzuceniem do bazy danych:
            foreach ($this->passedForm as $key => $value) {
                $value = $conn->real_escape_string($value);
                $this->passedForm[$key] = stripslashes($value);
            }

            // Tyle wstawiamy do bazy, ile zostało nam przekazane:
            foreach (array_keys($this->passedForm) as $key) {
                $query .= $key.', ';
            }

            // Obcinamy ostatnią spację i przecinek:
            $query = substr($query, 0, -2);
            $query .= ') VALUES (';

            //Dodajemy wartośći, które wcześniej już przygotowaliśmy do włożenia do DB:
            foreach($this->passedForm as $value) {
                $query .= '\''.$value.'\', ';
            }

            // Obcinamy ostatnią spację i przecinek:
            $query = substr($query, 0, -2);
            $query .= ')';

            $conn->query($query);
            
            $conn->close();
            return TRUE;
        }
        
        $conn->close();
        return FALSE;
    }
}
