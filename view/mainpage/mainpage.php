<?php
    //require "../../config/basic_config.php";
    //require "../".Config::VIEWS_PATH."header.php";
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/header.php';
    //echo realpath($_SERVER["DOCUMENT_ROOT"]);

    
    
    if ($this->what_display == 'logged') {
        echo "<a href=\"".Config::BASE_URL."index.php/profile\" alt=\"Przejdź na stronę główną\">Zobacz swój profil.</ a>";
    } else {
        echo "<a href=\"".Config::BASE_URL."index.php/logging\" alt=\"Przejdź na stronę główną\">Zaloguj się.</ a>";
        echo "<br />";
        echo "<a href=\"".Config::BASE_URL."index.php/registration\" alt=\"Przejdź na stronę główną\">Zarejestruj się.</ a>";
    }
    
    //require "../../".Config::VIEWS_PATH."foot.php";
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/foot.php';