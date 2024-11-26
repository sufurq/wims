<?php

require_once "../util/dbhelper.php";
$db = new DbHelper();
$display = $db->display_value_all_purchase();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DR PENDING STATUS</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/index.css">
    <script defer src="../script/script.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo-title"><img src="../img/coclogo.png" width="300" alt="Company Logo"></div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <ul>
            <li>Home</li>
            <li>Groups</li>
            <li>Users</li>
        </ul>
        <div class="profile-section">
            <img src="../img/avatar.png" alt="Profile" class="profile-avatar">
            <span>Jcolonia</span>
        </div>
    </nav>

    <!-- Main Section -->
    <div class="container">
        <!-- Sub Menu -->
        <aside class="sub-menu">
            <h1>
                <center><img src="../img/box.png" height="60" alt="Icon">&nbsp;SIT.io</center>
            </h1>
            <ul>
                <center>
                    <li><a href="pod.php">Dashboard</a></li>
                </center>
                <center>
                    <li class="selected"><a href="index.php" style="color: white">Purchase Order</a></li>
                </center>
                <center>
                    <li><a href="dr_page.php">Delivery Receipt</a></li>
                </center>
                <center>
                    <li><a href="#">POWE</a></li>
                </center>
                <center>
                    <li><a href="#">RIS</a></li>
                </center>
                <center>
                    <li><a href="#">Audit</a></li>
                </center>
                <center>
                    <li><a href="#">Reports</a></li>
                </center>
                <hr>
                <div class="dropdown">
                    <button class="dropdown-btn">Master Pages<i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="#">Site</a>
                        <a href="#">Item Category</a>
                        <a href="#">Item</a>
                        <a href="#">Supplier</a>
                        <a href="#">Settings</a>
                    </div>
                    </div>
                <hr>
                <center>
                    <li><a href="#">Log Out</a></li>
                </center>
            </ul>
        </aside>
            <div class="table-container">
            <center>
                <h2>FULLY DELIVERED</h2>
        </center>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>P.O. ID</th>
                            <th>P.O. #</th>
                            <th>Supplier</th>
                            <th>Procurement No</th>
                            <th>Delivery Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                          
                    </tbody>
                </table>
            </div>
 
    <script>
        function toggleDetails(button) {
            const detailsRow = button.closest("tr").nextElementSibling;
            detailsRow.style.display = detailsRow.style.display === "none" ? "table-row" : "none";
        }

        function editRecord(id) {
            alert(`Edit Record ID: ${id}`);
        }

        function deleteRecord(id) {
            if (confirm("Are you sure you want to delete this record?")) {

                alert(`Record ID ${id} deleted.`);
            }
        }
    </script>
</body>
</html>