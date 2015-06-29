<?php
    //require "../../config/basic_config.php";
    //require "../".Config::VIEWS_PATH."header.php";
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/header.php';
    //echo realpath($_SERVER["DOCUMENT_ROOT"]);


    switch ($this->what_display) {
        // Jeśli użytkownika zarejestrowano pomyślnie, to będzie wyświetlona strona informująca go o tym, w przeciwnym wypadku formularz do rejestracji
        case 'registered':
            echo "Zarejestrowano pomyślnie, możesz teraz przejść na stronę <a href=\"".Config::BASE_URL."/index.php/logging\" alt=\"Przejdź do arkusza logowania\">logowania</ a>";
            break;
        
        // Jeśli użytkownik jest już zalogowany
        case 'logged':
            echo "Jesteś już zalogowany. Przejdź do <a href=\"".Config::BASE_URL."/index.php/\" alt=\"Przejdź do strony głównej\">strony głównej</ a>.";
            break;
        
        // Jeśli rejestracja się nie powiodła
        case 'failed':
            echo "Rejestracja nie powiodła się z niewiadomych przyczyn, spróbój za jakiś czas ponownie, lub skontaktuj się z nami";
            break;
        
        // Jeśli użytkownik wchodzi do formularza pierwszy raz, lub przekazuje złe dane
        case 'registration':
        case 'bad_data':
            // Jeśli formularz został źle wypełniony wyświetlamy o tym informację:
            if ($this->what_display == 'bad_data') { echo "Formularz wypałniony niepoprawnie!<br />";}

            //W formularzu ustawiamy wartości początkowe, jeśli kontroler tego zażąda, w przeciwnym wypadku pola "value" będę puste
?>

<form method="post" action="<?php echo Config::BASE_URL.Config::INDEX_PAGE.'/registration' ?>">
    
<?php
        // Wyświetlamy pojedynczy input:
        foreach($this->model->getFields() as $key => $name) {
            // Wyświetlamy opis pola:
            echo ucfirst($name).': ';
            
            if ($key != 'password') {
                echo '<input type="text" ';
            } else {
                echo '<input type="password" ';
            }
            
            echo 'name="'.$key.'" ';
            // Zmiena nazwy do stałej z klasy Config:
            $configName = strtoupper($key).'_MAX_LENGTH';
            echo 'maxlength="'.constant("Config::$configName").'" ';
            
            if ($key != 'password') {
                echo 'value="'.$this->model->getValueOrEmptyString($key).'" ';
            } else {
                echo 'value=""';
            }
            
            echo '>';
            // Wiadomość wyświetlamy tylko, gdy użytkownik przesyła błędne dane:
            if ($this->what_display == 'bad_data') {
                echo ucfirst($this->model->getMsg($key));
            }
            
            echo '<br />';
        }

?>
    
    <input type="submit" name="submit" value="Wyślij">
</form>

<?php
            
            break;
        
        // Jeśli proszeni jesteśmy o wyświetlenie widoku, którego nie zaimplementowaliśmy
        default:
            throw new Exception('Takiej strony nie dam rady wyświetlić - RegistrationView!');    
    }
    //require "../../".Config::VIEWS_PATH."foot.php";
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/foot.php';            

