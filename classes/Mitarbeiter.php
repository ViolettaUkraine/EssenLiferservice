<?php
class Mitarbeiter {
    private $mitarbeiter_id;
    private $name;
    private $email;
    private $passwort_hash;
    public function __construct($mitarbeiter_id, $name, $email, $passwort_hash){
        $this->mitarbeiter_id= $mitarbeiter_id;
        $this->name= $name;
        $this-$email= $email;
        $this->passwort_hash= $passwort_hash;
    }
    
} 
?>