<?php

function connection( $con ) {
  return new PDO('mysql:host='.$con['host'].';dbname='.$con['dbname'], $con['user'], $con['password']);
}
