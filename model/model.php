<?php

class Model {
    
    function __construct() {
    }
    
    // Funkcja sprawdzająca np. czy użytkownik istnieje, lub email
    // W celu sprawdzenia unikalności danych;
    static public function whetherExists($data = '', $type = '') {
        // Łączymy się z bazą danych:
        $conn = new mysqli(Config::DB_HOSTNAME, Config::DB_L_USERNAME, Config::DB_L_PASSWORD, Config::DB_DATABASE_NAME);

        // Sprawdzamy, czy nawiązanie połączenia się powiodło:
        if ($conn->connect_error) {
            // Die - podobnie jak exit - wyświetla wiadomość i kończy wykonywanie skryptu
            die("Connection failed: " . $conn->connect_error);
        }
        
        $data = $conn->real_escape_string($data);
        $type = $conn->real_escape_string($type);

        // Tworzymy nasze żądanie:\
        $query = 'SELECT * FROM users WHERE '
                .$type.'=\''.$data.'\'';

        $output = $conn->query($query);
        //if (isset($output->num_rows)) {echo "jest ustawiona na: ".$output->num_rows;}
        if($output->num_rows > 0) {
            $conn->close();
            return TRUE;
        }
        else {
            $conn->close();
            return FALSE;
        }
    }
}