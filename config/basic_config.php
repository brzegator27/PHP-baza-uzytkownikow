<?php
/*
 * Plik z podstawowymi ustawieniami konfiguracyjnymi
 */

class Config {
    // Struktura folderów:
    const
    CONTROLLERS_PATH = "controller/",
    VIEWS_PATH = "view/",
    MODELS_PATH = "model/",
    BASE_URL = "http://localhost/kam/",
    INDEX_PAGE = "index.php";
    
    // Maksymalna długość danych w bazie danych:
    const
    USERNAME_MAX_LENGTH = '30',
    FIRST_NAME_MAX_LENGTH = '45',
    LAST_NAME_MAX_LENGTH = '45',
    EMAIL_MAX_LENGTH = '45',
    STREET_MAX_LENGTH = '45',
    CITY_MAX_LENGTH = '45',
    ZIP_CODE_MAX_LENGTH = '6',
    HOUSE_NR_MAX_LENGTH = '10',
    APARTMENT_NR_MAX_LENGTH = '10',
    PASSWORD_MAX_LENGTH = '30';
    
    // Dane do bazy danych:
    const
    DB_DATABASE_NAME = "kam_1",
    DB_HOSTNAME = "localhost",
    // Dane konta do logownia użytkownika, wyświetlanie jesgo danych itp.:
    DB_L_USERNAME = "kam_logging",
    DB_L_PASSWORD = "kam",
    // Dane konta do rejestracji użytkownika itp.:
    DB_R_USERNAME = "kam_registration",
    DB_R_PASSWORD = "kam"; 
}