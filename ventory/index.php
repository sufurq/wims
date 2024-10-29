<?php 

require_once "./util/dbhelper.php";
$db = new DbHelper();
$display = $db->getAllRecords("purchase_orders");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <script defer src="script/script.js"></script>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo-title"><img src="img/coclogo.png" width="300" alt="Company Logo"></div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <ul>
            <li>Home</li>
            <li>Groups</li>
            <li>Users</li>
        </ul>
        <div class="profile-section">
            <img src="img/avatar.png" alt="Profile" class="profile-avatar">
            <span>Jcolonia</span>
        </div>
    </nav>

    <!-- Main Section -->
    <div class="container">
        <!-- Sub Menu -->
        <aside class="sub-menu">
            <h1><center><img src="img/box.png" height="60" alt="Icon">&nbsp;SIT.io</center></h1>
            <ul>
                <center><li><a href="dashboard.php">Dashboard</a></li></center>
                <center><li class="selected"><a href="index.php">Purchase Order</a></li></center>
                <center><li><a href="#">Delivery Receipt</a></li></center>
                <center><li><a href="#">POWE</a></li></center>
                <center><li><a href="#">RIS</a></li></center>
                <center><li><a href="#">Audit</a></li></center>
                <center><li><a href="#">Reports</a></li></center>
                <hr>
                <center><li><a href="#">Master Pages</a></li></center>
                <hr>
                <center><li><a href="#">Log Out</a></li></center>
            </ul>
        </aside>

        <!-- Purchase Order Page -->
        <section class="purchase-order">
            <center><h2>Purchase Order</h2></center>
            <a href="npo.php"><button class="new-record-btn"><b>New Record</b></button></a>

            <br>
            <center>
                <div class="dropdown-container">
                    <select class="status-dropdown">
                        <option value="deleted">Deleted</option>
                        <option value="pending" selected>Pending</option>
                        <option value="partial">Partial</option>
                        <option value="fully-delivered">Fully Delivered</option>
                    </select>
                </div>
            </center>
            <br>
            <div class="text-center mb-3">
    

    <!-- Search field for filtering entries -->
    <div class="search-container">
    <!-- Font Awesome icon for search, can be replaced with an image if needed -->
    <i class="fa fa-search search-icon"></i>
    <input type="text" class="search-input" placeholder="Search purchase orders..." id="search-input">
</div>

<div class="text-center mb-3">


    <!-- Dropdown to select the number of entries to display -->
    <div class="dropdown-container" style="position:relative; left:-620px;">
    <h4>Show&nbsp;</h4>
                    <select class="status-dropdown" style="width:100px;">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10" selected>10</option>
                    </select>
                    <h4>&nbsp;Entries</h4>
                </div>
</div>

    <!-- Dropdown to show search results -->
    <div id="search-results" class="search-results w-25 mx-auto mt-2" style="display: none;">
        <ul class="list-group" id="result-list">
            <!-- Search results will be appended here dynamically -->
        </ul>
    </div>
</div>
      <!-- Purchase Orders Table -->
<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>P.O #</th>
                <th>Date Created</th>
                <th>Procurement No</th>
                <th>Supplier</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($display as $row) : ?>   

                <tr>
                <td><?php echo $row["purchase_order_number"] ?></td>
                <td><?php echo $row["order_date"] ?></td>
                <td><?php echo $row["procurement_number"] ?></td>
                <td><?php echo $row["supplier_id"] ?></td>
                


                </tr>

                <?php endforeach; ?>
        </tbody>
    </table>
</div>

            <div class="nav-container">
                <button class="nav-btn" id="prev-btn">Previous</button>
                <div class="number-box" id="number-display">1</div>
                <button class="nav-btn" id="next-btn">Next</button>
            </div>
        </section>
    </div>
</body>
</html>
