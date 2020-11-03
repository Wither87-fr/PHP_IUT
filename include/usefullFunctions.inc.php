<?php
  function verifyPassword($password, $salt) {
    if(!empty($password)) {
      return password_verify($password, $salt);
    } else {
      return false;
    }

  }
?>
