<?php

class ProfilechangeModel extends Forms {
    /*
     * Wystarczy zakomentować jakąś linijkę w poniższej tablicy, by wyżucić to z formularza.
     */
    // Tablica z nazwami i opisami pól formularza:
    protected $fields = array(
        //'username' => 'login',
        //'first_name' => 'imię',
        //'last_name' => 'nazwisko',
        'email' => 'email',
        'street' => 'ulica',
        'city' => 'miasto',
        'zip_code' => 'kod pocztowy',
        'house_nr' => 'numer domu',
        'apartment_nr' => 'numer mieszkania',
        'password' => 'hasło',
        'password_old' => 'stare hasło'
    );
    
    function __construct() {
        // Nie konstruktora w rodzicu!
        parent::__construct();
        
        // Tworzymy tablicę:
        $this->nullifyForm();
    }
    
        // Zakładamy, że to kontroler zadbał o sprawczenie, czy użytkownik jest zalogowany
    public function loadData($username) {
        // Łączymy się z bazą danych, korzystamy z tego samego połączenia, co dla logowania:
        $conn = new mysqli(Config::DB_HOSTNAME, Config::DB_L_USERNAME, Config::DB_L_PASSWORD, Config::DB_DATABASE_NAME);

        // Sprawdzamy, czy nawiązanie połączenia się powiodło:
        if ($conn->connect_error) {
            // Die - podobnie jak exit - wyświetla wiadomość i kończy wykonywanie skryptu
            die("Connection failed: " . $conn->connect_error);
        }
        
        foreach (array_keys($this->fields) as $key) {
            // Nie pobieramy hasła
            if ($key != 'password' && $key != 'password_old') {
                // Dla każdego pola tworzymy zapytanie:
                $query = 'SELECT '.$key.' FROM users WHERE username=\''.$username.'\'';

                $output = $conn->query($query);

                if ($output->num_rows > 0) {
                    $output->data_seek(0);
                    $data = $output->fetch_assoc();

                    $this->passedForm[$key] = $data[$key];

                } else {
                    throw new Exception("Danych nie udało się pobrać!");
                }
            }
        }
        $conn->close();
    }
    
    public function changeData() {
        // Łączymy się z bazą danych:
        $conn = new mysqli(Config::DB_HOSTNAME, Config::DB_R_USERNAME, Config::DB_R_PASSWORD, Config::DB_DATABASE_NAME);

        // Sprawdzamy, czy nawiązanie połączenia się powiodło:
        if ($conn->connect_error) {
            // Die - podobnie jak exit - wyświetla wiadomość i kończy wykonywanie skryptu
            die("Connection failed: " . $conn->connect_error);
        }
        
        if (TRUE) {
            // Przetwarzamy dane przed wrzuceniem do bazy danych:
            foreach ($this->passedForm as $key => $value) {
                $value = $conn->real_escape_string($value);
                $this->passedForm[$key] = stripslashes($value);
            }

            // Jeśli jakieś pole jest puste, to go nie zmieniamy:
            foreach ($this->passedForm as $key => $value) {
                if (empty($value)) {
                    //echo "unset: ".$key;
                    unset($this->passedForm[$key]);
                }
            }
            
            // Szyfrujemy hasła:
            foreach (array('password', 'password_old') as $key) {
                if (isset($this->passedForm[$key])) {
                    $this->passedForm[$key] = md5($this->passedForm[$key]);
                }
            }
            
            // Najpierw sprawdzamy, czy stare hasło zostało podane poprawnie:
            if (isset($this->passedForm['password_old'])) {
                $query = 'SELECT * FROM users WHERE (username=\''.Session::getUsername().'\') AND (password=\''.$this->passedForm['password_old'].'\')';

                $output = $conn->query($query);
                
                if ($output->num_rows > 0) {

                    // Teraz wiemy, że użytkownik został zalogowany, więc tworzymy nasze właściwe żądanie:
                    $query = "UPDATE users SET ";
                    
                    // Starego hasła nie wstawiamy, więc:
                    unset($this->passedForm['password_old']);
                    
                    // Do bazy wstawiamy tyle, ile zostało nam przekazane, oprócz starego hasła:
                    foreach ($this->passedForm as $key => $value) {
                        $query .= $key.'=\''.$value.'\', ';
                    }
                    
                    // Obcinamy ostatnią spację i przecinek:
                    $query = substr($query, 0, -2);
                    
                    $query .= 'WHERE username=\''.Session::getUsername().'\'';

                    
                    $conn->query($query);
                    
                    $conn->close();
                    return TRUE;
                } else {
                    $this->passedFormMsg['password_old_msg'] .= "Nieprawdiłowe hasło!";
                }
            }
        }
        
        $conn->close();
        return FALSE;
    }
}