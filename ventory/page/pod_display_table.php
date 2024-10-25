<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pod Display</title>
    <link rel="stylesheet" href="../assets/css/pod_style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>


</head>

<body>
    <header class="bg-light py-3 d-flex justify-content-start align-items-center">
        <img src="../img/coclogo.png" class="img-fluid" alt="Company Logo" style="max-width: 20%; height: auto; margin-right: 10px;">
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">SIT.io</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Groups</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
            </ul>
            <div class="navbar-text ml-auto d-flex align-items-center">
                <img src="../img/avatar.png" class="rounded-circle mr-2" alt="Profile" width="40">
                <span>Jcolonia</span>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-3 col-md-4 col-sm-12 bg-light p-3">
                <div class="text-center mb-4">
                    <img src="../img/box.png" alt="Icon" height="60">
                    <h1>SIT.io</h1>
                </div>
                <ul class="nav flex-column text-center">
                    <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php">Purchase Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Delivery Receipt</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">POWE</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">RIS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Audit</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Master Pages</a></li>
                    <li class="nav-item"><a class="nav-link" href="./logic/logout.php">Log Out</a></li>
                </ul>
            </aside>

            <main class="col-lg-9 col-md-8 col-sm-12 p-4">
                <div class="text-center">
                    <h2 class="mb-4">Purchase Order</h2>
                </div>



                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Unit of Issue</th>
                                <th>QTY</th>
                                <th>Unit Cost</th>
                                <th>Amount</th>
                                <th>Actions</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                </div>

                <tbody id="tableBody">
                    <option>

                    </option>
        </div>
    </div>


    </tbody>
    </table>

    <script type="module" src="../assets/js/index_ventory.js"></script>

</body>

</html>