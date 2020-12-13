<?php
require '../vendor/autoload.php';

$ldap = ldap_connect("ldap.example.com");
if ($bind = ldap_bind($ldap, $_POST['username'], $_POST['password'])) {
  // log them in!
} else {
  // error message
}
?>
