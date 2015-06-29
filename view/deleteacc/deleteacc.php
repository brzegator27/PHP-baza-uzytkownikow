<?php
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/header.php';

    // Jeśli użytkownika zarejestrowano pomyślnie, to będzie wyświetlona strona informująca go o tym, w przeciwnym wypadku formularz do rejestracji
    switch ($this->what_display) {
        case "access_violation":
            echo "Nie masz dostępu do tej strony!<br /> Przejdź na stronę <a href=\"".Config::BASE_URL."index.php/\" alt=\"Przejdź na stronę główną\">główną</ a>";
            break;
        case "deleted":
            echo "Konto zostało usunięte, możesz teraz przejść na stronę <a href=\"".Config::BASE_URL."index.php/\" alt=\"Przejdź na stronę główną\">główną</ a>";
            break;
        case "failed":
            echo "Podane hasło jest nieprawidłowe!<br />";
        case "blank":
?>

<form method="post" action="<?php echo Config::BASE_URL.Config::INDEX_PAGE.'/deleteacc' ?>">
    
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
            echo 'value="'.'" ';
            
            echo '>';
            // Wiadomość wyświetlamy tylko, gdy użytkownik przesyła błędne dane:
            if ($this->what_display == 'bad_data') {
                echo ucfirst($this->model->getMsg($key));
            }
            
            echo '<br />';
        }

?>
    
    <input type="submit" name="submit" value="Usuń">
</form>

<?php
        
            break;
        default:
            throw new Exception('Takiej strony nie dam rady wyświetlić - DeleteaccView!');
    }
    
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/foot.php';


