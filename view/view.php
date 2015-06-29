<?php
/*
 * Klasa bazowa dla widoków
 */

class View {
        
    // Zmienna 'what_display' mówi nam w jakim trybie ma być wyświetlany formularz
    private $what_display;
    
    // Zmienna przechoująca obiekt modelu
    private $model;
    
    // Zmienna przechowująca dane o nazwie pliku body strony:
    private $page_name;
    
    public function __construct(&$model = FALSE, $page_name) {
        // Inicjalizujemy zmienną pustą wartością:
        $this->what_display = '';
        $this->page_name = $page_name;
        
        //Jeśli controller nie przekazał nam obiektu modelu, no na nasze potrzeby musimy stworzyć go sami;
        if ($model === FALSE) {$model = &$this->createModel($this->page_name); }

        // By do modelu móc się dostać z każdej metody w klasie (cośtam)View:
        $this->model = $model;
    }
    
    protected function createModel($name, $param = '') {
        // Nazwa klasy zaczyna się od dużej litery i składa się z nazwy przekazanej, jak i słowa 'Controller'
        $modelName = ucfirst($name.'Model');

        return new $modelName($param);
    }
        
    public function generatePage($what_display = '') {
        // Bierzemy dane z modelu
        // Przepisujemy je do nowej tabeli, by było wygodniej używać je w różnych funkcjach w widoku, jeśli jakieś się pojawią
        
        if ($what_display !== '') {$this->what_display = $what_display;}
        
        // Wstawiamy formularz, lub inną rzecz:
        require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/'.$this->page_name.'/'.$this->page_name.'.php';
        //require $this->page_name.'.php';
    }
    
    public function setWhatDisplay($what_display) {
        $this->what_display = $what_display;
    }
}