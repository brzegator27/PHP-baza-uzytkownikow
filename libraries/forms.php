<?php

/*
 * Klasa nadrzędna dla modelów zarządzającymi formualrzami; zawiera podstawowe funkcje
 */

class Forms extends Model {
    // Tablica z wyrażeniami regular expresion do walidacji danych:
    private $validation_expr = array(
        'username' => '/^[a-zA-Z1-9]+$/',
        'username_msg' => 'Zły login',
        'first_name' => '/^[A-Z][a-z]+$/',
        'first_name_msg' => 'Złe imię',
        'last_name' => '/^[A-Z][a-z]+$/',
        'last_name_msg' => 'Złe nazwisko',
        'email' => '',
        'email_msg' => 'Zły email',
        'street' => '/^[A-Z][a-z]+$/',
        'street_msg' => 'Zła nazwa ulicy',
        'city' => '/^[A-Z][a-z]+$/',
        'city_msg' => 'Zła nazwa miasta',
        'zip_code' => '/^[1-9][0-9]-[1-9][0-9]{2}$/',
        'zip_code_msg' => 'Zły kod pocztowy',
        'house_nr' => '/^[1-9][0-9]*$/',
        'house_nr_msg' => 'Nieprawidłowy nr domu',
        'apartment_nr' => '/^[1-9][0-9]*$/',
        'apartment_nr_msg' => 'Nieprawidłowy nr mieszkania',
        'password' => '',
        'password_msg' => 'Nieprawidłowe hasło',
        'password_old' => '',
        'password_old_msg' => 'Nieprawidłowe hasło'
    );
    
            
    // Zmienna na tablicę z danymi z formularza:
    protected $passedForm;
    protected $passedFormMsg;
    
    public function __construct() {
        parent::__construct();
    }
    
    // Tworzy tablicę z indeksami:
    public function nullifyForm() {
        // Jeśli coś tam było zapisane, to już tego nie będzie, bo tego nie chcemy:
        unset($this->passedForm);
        
        // Tworzymy tablicę:
        foreach(array_keys($this->fields) as $name) {
           $this->passedForm[$name] = NULL;
           
           //Dodajemy pola na wiadomości do tablicy passedFormMsg, które będzie mógł wyświetlić widok użytkownikowi:
           $this->passedFormMsg[$name.'_msg'] = ' ';
        }
    }

    // Sprawdza, czy wszystkie pola w formularzu zostały ustawione:
    // Wywołujemy już po wywołaniu funkcji nullifyForm() i fillFromTable(), więc sprawdzamy wszystkie pola, użytkownik nas nie oszuka
    public function checkIfIsset() {
        $isset = TRUE;
        
        if(isset($this->passedForm)){
            foreach($this->passedForm as $value) {
                if(!isset($value)) { $isset = FALSE; }
            }
        } else {$isset = FALSE;}
        
        return $isset;
    }
    
    // Pobiera przekazane dane i wpisuje do naszej tablicy:
    public function fillFromTable() {
        foreach (array_keys($this->passedForm) as $key) {
            $this->passedForm[$key] = filter_input(INPUT_POST, $key);
        }
    }
    
    // Sprawdza, czy choć jedno pole formularza jest wypełnione
    public function checkIfBlank() {
        $isBlank = FALSE;
        
        foreach (array_keys($this->passedForm) as $key) {
           if (!isset($_POST[$key])) { $isBlank = $isBlank || TRUE; }
        }
        
        return $isBlank;
    }
    
    // Funkcja sprawdzająca, czy dane $data o typie $type, 
    // który jest jednym z tablicy: $this->validation_expr jest z nim w rzeczywistości zgodna
    public function validateData($data, $type) {
        // Jeśli typ jest nieustawiony, to nie wiemy jak sprawdzać
        if (!isset($type)) {
            throw new Exception("Musisz podać typ sprawdzanej wartości!");
        }
        
        // Jeśli sprawdzamy maila, to używamy gotowego rozwiązania:
        if ($type == 'email') {
            return filter_var($data, FILTER_VALIDATE_EMAIL);
        }
        
        // Jeśli nic z powyższych to sprawdzamy, czy mamy wyrażenie regularne dla przekazanej danej
        if (isset($this->validation_expr[$type])) {
            //Jeśli nie ustawiliśmy wyrażenia regularnego, to wszystko pasuje, więc zwracamy true:
            if ($this->validation_expr[$type] == '') { return TRUE; }
            
            // Sprawdzamy za pomocą wyrażenia regularnego:
            return preg_match($this->validation_expr[$type], $data);
        } else 
        // Jeśli nie znaleźliśmy żadnego dopasowania wyrzucamy wyjątek 
        {
            throw new Exception("Danych takiego typu nie damy rady sprawdzić!");
        }
    }
    
    // Funkcja sprawdzająca poprawność wszystkich pól w formularzu
    public function checkAll() {
        $all = TRUE;
                
        foreach($this->passedForm as $key => $value) {
            // Sprawdzamy poprawność konkretnego pola:
            $temp = $this->validateData($value, $key);
            
            // Jeśli jest jakiś błąd, to dodajemy informację o błędzie:
            if (!$temp) {$this->passedFormMsg[$key.'_msg'] .= $this->validation_expr[$key.'_msg'];}
            
            $all = $all && $temp;
        }
        
        return $all;
    }
    
    // Funkcja zwracająca wartość pola z formularza o zadanej nazwie $key
    public function getValue($key) {
        if ($this->passedForm[$key]) {
            return $this->passedForm[$key];
        } else {
            throw new Exception("Takiej wartości nie ma w formularzu!");
        }
    }
    
    // Funkcja zwracająca wartość pola z formularza o zadanej nazwie $key
    // Jeśli wartość jest nieustaiona, to zwracamy pusty string
    public function getValueOrEmptyString($key) {
        if ($this->passedForm[$key]) {
            return $this->passedForm[$key];
        } else {
            return '';
        }
    }
    
    // Funkcja zwracająca wiadomość wygenerowaną przez model w wyniku sprawdzania poprawności danych
    // Wiadomość ta dotyczny pola z formularza o nazwię $key
    public function getMsg($key) {
        if (isset($this->passedFormMsg[$key.'_msg'])) {
            return $this->passedFormMsg[$key.'_msg'];
        } else {
            throw new Exception("Takiej wiadomości nie ma w modelu!");
        }
    }
    
    // Funkcja zwracająca tablicę z nazwami pól i ich opisami:
    public function getFields() {
        return $this->fields;
    }
}
