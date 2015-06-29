<?php
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/header.php';


    switch ($this->what_display) {
        // Jeśli użytkownika zarejestrowano pomyślnie, to będzie wyświetlona strona informująca go o tym, w przeciwnym wypadku formularz do rejestracji
        case 'access_violation':
            echo "Nie masz dostępu do tej strony!<br /> Przejdź na stronę <a href=\"".Config::BASE_URL."index.php/\" alt=\"Przejdź na stronę główną\">główną</ a>";
            break;

        case 'user_data':
            
            foreach($this->model->getFields() as $key => $name) {
                echo ucfirst($name).': ';
                echo $this->model->getValue($key);
                echo "<br />";
            }
            
            break;
        
        // Jeśli proszeni jesteśmy o wyświetlenie widoku, którego nie zaimplementowaliśmy
        default:
            throw new Exception('Takiej strony nie dam rady wyświetlić - ProfileView!');    
    }
    
    // Wyświetlamy linki:
    echo "<a href=\"".Config::BASE_URL."index.php/profilechange\" alt=\"Zmień dane profilowe\">Zmień dane profilowe.</ a>";
    echo "<br />";
    echo "<a href=\"".Config::BASE_URL."index.php/deleteacc\" alt=\"Usuń konto\">Usuń konto.</ a>";
    
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/foot.php'; 