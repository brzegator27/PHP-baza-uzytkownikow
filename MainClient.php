<?php

/*
 * Klasa inicjalizowana jako pierwsza; analizuje adres ulr i uruchamia odpowiednie kontrolery
 */
class MainClient {

    private $url;
    
    public function __construct() {
        //echo "We're in MainClient() constructor<br />";
        $this->getParameters();
        $this->runController();
    }
    
    // Funkcja urachamiająca odpowiedni kontroller
    private function runController() {
        // Zmienna pointer pokazuje nam w którym miejscu w tablicy $url znajdują się interesujące nas parametry
        $pointer = 0;
        // Im folder "bazowy" ze stroną jest głębie zagniężdżony w localhoście, tym dalej nasze parametry w tablicy:
        $pointer += substr_count(Config::BASE_URL, '/') - 1;
        
        // Łączymy się najpierw z kontrollerem. Musimy uruchomić właściwy, w zależności od przekazanych parametrów
        // Sprawdzamy, czy parametry są ustawione:
        if (isset($this->url[$pointer])) {
            switch ($this->url[$pointer]) {
                case "":
                    // Chcemy wejść na stronę główną, więc:
                    $this->url[$pointer] = 'mainpage';
                case "logging":
                case "registration":
                case "logout":
                case "profile":
                case "profilechange":
                case "deleteacc":
                case "mainpage":
                    $this->loadStuff($pointer);
                    
                    // Sprawdzamy, czy został przekazany jakiś argument 
                    $param = isset($this->url[$pointer + 1]) ? $this->url[$pointer + 1] : '';
                    
                    $our_controller = $this->inicializeController($this->url[$pointer], $param);
                    break;                
                
		default :
                    echo "Błąd - strona ".$this->url[$pointer]." nie istnieje! O.o";
                    break;
            }
        } else {
            echo "Taka strona nie istnieje! O.o";
        }        
    }
    
    // Funkcja tworząca tablicę z parametrami przekazanymi w adresie strony
    private function getParameters() {
        // Pobieramy adres:
	$this->url = filter_input(INPUT_SERVER, 'REQUEST_URI');//$_SERVER['REQUEST_URI'];
        rtrim($this->url, '/');   ///< Jeśli na końcu stringu są jakieś znaki '/' to zostają usunięte;
        $this->url = explode('/', $this->url);  ///< To, co jest pomiędzy znakami / trafia do oddzielnych pól w tablicy
    }
    
    private function inicializeController($name, $param = '') {
        // Nazwa klasy zaczyna się od dużej litery i składa się z nazwy przekazanej, jak i słowa 'Controller'
        $controllerName = ucfirst($name.'Controller');
        //echo $controllerName;
        return new $controllerName($param);
    }
    
    // Funkcja ładująca potrzebne klasy:
    private function loadStuff($pointer) {
        require Config::CONTROLLERS_PATH.$this->url[$pointer].'_controller.php';
        require Config::VIEWS_PATH.$this->url[$pointer].'/'.$this->url[$pointer].'_view.php';
        require Config::MODELS_PATH.$this->url[$pointer].'_model.php';
    }
}
