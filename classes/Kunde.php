<?php

class Kunde {
    private $kunden_id;
    private $vorname;
    private $nachname;
    private $email;
    private $passwort_hash;
    private $adresse;
    private $erstellt_am;
    private $benutzername;

    public function __construct($kunden_id, $vorname, $nachname, $email, $passwort_hash, $adresse, $erstellt_am, $benutzername) {
        $this->kunden_id = $kunden_id;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->email = $email;
        $this->passwort_hash = $passwort_hash;
        $this->adresse = $adresse;
        $this->erstellt_am = $erstellt_am;
        $this->benutzername = $benutzername;
    }
}