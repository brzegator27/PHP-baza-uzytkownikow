<?php

/*
 * Klasa odpowiedzialna za widok dla usuwania konta użytkownika
 */

class DeleteaccView extends View {

    public function __construct(&$model = FALSE) {
        parent::__construct($model, 'deleteacc');
    }
}