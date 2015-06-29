<?php
/**
 * Ładuje najważniejsze klasy i przekazuje sterowanie do klasy MainClient
 */

require "controller/controller.php";
require "view/view.php";
require "config/basic_config.php";
require "model/model.php";

// Ładujemy biblioteki:
require "libraries/session.php";
require "libraries/forms.php";
require "libraries/database.php";



require "MainClient.php";

$our_site = new MainClient();
