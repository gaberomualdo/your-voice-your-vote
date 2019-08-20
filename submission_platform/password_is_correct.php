<?php
// get variable for correct password
include "../assets/txt/submission_platform_password.php";

// set header of text
header('Content-type: text/plain');

// if password is correct, return "true"; else, return "false"
if(isset($_GET["password"]) && $_GET["password"] == $SUBMISSION_PLATFORM_PASSWORD) {
    echo "true";
} else {
    echo "false";
}
?>