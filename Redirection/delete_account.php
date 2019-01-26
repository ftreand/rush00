<?php
include("../Controller/User.php");

session_start();

delete_account($_POST);
session_destroy();