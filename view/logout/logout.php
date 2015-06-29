<?php
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/header.php';

    switch ($this->what_display) {
        // Jeśli udało się wylogować
        case 'loggedout':
            echo "Wylogowano, możesz teraz przejść na stronę <a href=\"".Config::BASE_URL."index.php/\" alt=\"Przejdź na stronę główną\">główną</ a>";
            break;
        
        // Jeśli wystąpił błąd: 
        case 'failed':
            echo "Wylogowanie nie powiodło się z niewiadomych przyczyn, spróbój za jakiś czas ponownie, lub skontaktuj się z nami";
    }
    
    require realpath($_SERVER["DOCUMENT_ROOT"]).'/kam/view/foot.php';