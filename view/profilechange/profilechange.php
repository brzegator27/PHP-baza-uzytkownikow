<?php
    //require "../../config/basic_config.php";
    //require "../".Config::VIEWS_PATH."header.php";
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/header.php';
    //echo realpath($_SERVER["DOCUMENT_ROOT"]);


    switch ($this->what_display) {
        // Jeśli ktoś nie ma dostępu do strony:
        case 'access_violation':
            echo "Nie masz dostępu do tej strony!<br /> Przejdź na stronę <a href=\"".Config::BASE_URL."index.php/\" alt=\"Przejdź na stronę główną\">główną</ a>";
            break;
        
        // Jeśli dokonano zmian w profilu pomyślnie:
        case 'changed':
            echo "Dane pomyślnie zmienione. Przejdź do <a href=\"".Config::BASE_URL."index.php/profile\" alt=\"Przejdź do strony głównej\">profilu</ a>.";
            break;
        
        // Jeśli nie udało się zmienić danych
        case 'failed':
            echo "Rejestracja nie powiodła się z niewiadomych przyczyn, spróbój za jakiś czas ponownie, lub skontaktuj się z nami";
            break;
        
        // Jeśli użytkownik wchodzi do formularza pierwszy raz, lub przekazuje złe dane
        case 'changing':
        case 'bad_data':
            // Jeśli formularz został źle wypełniony wyświetlamy o tym informację:
            if ($this->what_display == 'bad_data') { echo "Formularz wypałniony niepoprawnie!<br />";}

            //W formularzu ustawiamy wartości początkowe, jeśli kontroler tego zażąda, w przeciwnym wypadku pola "value" będę puste
?>

<form method="post" action="<?php echo Config::BASE_URL.Config::INDEX_PAGE.'/profilechange' ?>">
    
<?php
        // Wyświetlamy pojedynczy input:
        foreach($this->model->getFields() as $key => $name) {
            // Wyświetlamy opis pola:
            echo ucfirst($name).': ';
            
            if ($key != 'password' && $key != 'password_old') {
                echo '<input type="text" ';
            } else {
                echo '<input type="password" ';
            }
            
            echo 'name="'.$key.'" ';
            // Zmiena nazwy do stałej z klasy Config:
            $configName = strtoupper($key).'_MAX_LENGTH';
            if ($key != 'password_old') {
                echo 'maxlength="'.constant("Config::$configName").'" ';
            } else {
                echo 'maxlength="'.constant('Config::PASSWORD_MAX_LENGTH').'" ';
            }
            
            if ($key != 'password' && $key != 'password_old') {
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
            throw new Exception($this->what_display.'Takiej strony nie dam rady wyświetlić - ProfilechangeView!');    
    }
    //require "../../".Config::VIEWS_PATH."foot.php";
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/foot.php';
