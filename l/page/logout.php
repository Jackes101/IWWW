<h1>Logout</h1>

<?php
session_destroy();
header("Location:".BASE_URL);