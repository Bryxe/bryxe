<?php
if (!isset($_SESSION['username']) || $_SESSION['username'] == '') {
    header("Location: " . BASE_URL);
    exit;
}