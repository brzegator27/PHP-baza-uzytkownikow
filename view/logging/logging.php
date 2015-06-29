<?php
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/header.php';

    // Jeśli użytkownika zarejestrowano pomyślnie, to będzie wyświetlona strona informująca go o tym, w przeciwnym wypadku formularz do rejestracji
    if ($this->what_display == 'logged') {
        echo "Jesteś już zalogowany/a";
    } elseif ($this->what_display == 'just_logged') {
        echo "Zalogowano pomyślnie. Możesz możesz teraz przejść na stronę <a href=\"".Config::BASE_URL."index.php/\" alt=\"Przejdź na stronę główną\">główną</ a>";
    }
    elseif ($this->what_display == 'failed') {
        echo "Logowanie nie powiodło się z niewiadomych przyczyn, spróbój za jakiś czas ponownie, lub skontaktuj się z nami";
    }     
    else {
        // Jeśli formularz został źle wypełniony wyświetlamy o tym informację:
        if ($this->what_display == 'no_such_user') { echo "Taki użytkownik nie istnieje, lub podałeś złe hasło!<br />";}

        //W formularzu ustawiamy wartości początkowe, jeśli kontroler tego zarząda, w przeciwnym wypadku pola "value" będę puste
?>

<form method="post" action="<?php echo Config::BASE_URL.Config::INDEX_PAGE.'/logging' ?>">
    
<?php
        echo "Formularz początkowy: <br />";
        
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
            echo 'value="'.'" ';
            
            echo '>';
            // Wiadomość wyświetlamy tylko, gdy użytkownik przesyła błędne dane:
            if ($this->what_display == 'bad_data') {
                echo ucfirst($this->model->getMsg($key));
            }
            
            echo '<br />';
        }

?>
    
    <input type="submit" name="submit" value="Zaloguj">
</form>

<?php
    }
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/foot.php';


