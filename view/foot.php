<?php
    // Jeśli ktoś jest zalogowany, to wyświetlamy link do wylogowania się:
    if (Session::isLogged()) {
        echo "<br /><a href=\"logout\" alt=\"Wyloguj\">Wyloguj</ a>";
    }
?>

</body>
</html>