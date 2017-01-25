<?php

require_once('lib/Config.php'); 

session_destroy();

header('Location: '.URL_ADMIN.'login/');