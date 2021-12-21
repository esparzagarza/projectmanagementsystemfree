<?php

session_start();

if (!isset($_SESSION['session_user'])) die("Oops!! ... Something went wrong!");