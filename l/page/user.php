<h1>Users</h1>
<?php
if($_GET["action"] == "read-all"){
    echo "<h2>All users</h2>";
    $userRepo = new UserRepozitory(Connection::getPdoInstance());
    $allUsersResult = $userRepo ->getAllUsers();

    $datatable = new DataTable($allUsersResult);
    $datatable ->addColumn("id", "ID");
    $datatable ->addColumn("email", "Email");
    $datatable ->addColumn("created", "Created");
    $datatable ->render();

} else if($_GET["action"] == "by_email"){
    //todo
}


