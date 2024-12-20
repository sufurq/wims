<?php
$conn = new mysqli("localhost", "root", "", "inventory_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_Id = $_POST['supplier_Id'];
    $purchase_order_id = $_POST['purchase_order_id'];
    $category = $_POST['category'];
    $item_description = $_POST['item']; 
    $unit_of_measure = $_POST['uom']; 
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $amount = $_POST['amount'];

    $checkSupplier = $conn->prepare("SELECT * FROM suppliers WHERE supplier_Id = ?");
    $checkSupplier->bind_param("i", $supplier_Id);
    $checkSupplier->execute();
    $resultSupplier = $checkSupplier->get_result();

    if ($resultSupplier->num_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO pod_items (supplier_Id, purchase_order_id, category, item_description, unit_of_measure, quantity, unit_price, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssidd", $supplier_Id, $purchase_order_id, $category, $item_description, $unit_of_measure, $quantity, $unit_price, $amount);
        
        if ($stmt->execute()) {
            header("Location: ./page/view_deatails_purchase_oder.php?id=$purchase_order_id");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Supplier ID does not exist.";
    }

    $checkSupplier->close();
}

require_once "./util/dbhelper.php";
$db = new DbHelper();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 10;
$start = ($page - 1) * $recordsPerPage;
$query = isset($_GET['query']) ? htmlspecialchars($_GET['query'], ENT_QUOTES, 'UTF-8') : '';
$row = $db->fetchRecords_limit("pod_items", $start, $recordsPerPage, $query);
$totalRecords = $db->fetchTotalRecords("pod_items", $query);
$totalPage = ceil($totalRecords / $recordsPerPage);

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
    <link rel="stylesheet" href="./assets/css/pod_style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header class="bg-light py-3 d-flex justify-content-start align-items-center">
        <img src="img/coclogo.png" class="img-fluid" alt="Company Logo" style="max-width: 20%; height: auto; margin-right: 10px;">
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
                <img src="img/avatar.png" class="rounded-circle mr-2" alt="Profile" width="40">
                <span>Jcolonia</span>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-3 col-md-4 col-sm-12 bg-light p-3">
                <div class="text-center mb-4">
                    <img src="img/box.png" alt="Icon" height="60">
                    <h1>SIT.io</h1>
                </div>
                <ul class="nav flex-column text-center">
                    <li class="nav-item"><a class="nav-link" href="pod.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php">Purchase Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="dr_page.php">Delivery Receipt</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">POWE</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">RIS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Audit</a></li>
                    <li class="nav-item"><a class="nav-link" href="report/reports.php">Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Master Pages</a></li>
                    <li class="nav-item"><a class="nav-link" href="./logic/logout.php">Log Out</a></li>
                </ul>
            </aside>

            <main class="col-lg-9 col-md-8 col-sm-12 p-4">
                <div class="text-center">
                    <h2 class="mb-4">Dashboard</h2>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <form action="pod.php" method="get" class="form-inline d-flex flex-grow-1">
                        <div class="form-group flex-grow-1">
                            <div class="search-container d-flex align-items-center">
                                <img src="./assets/img/search.svg" alt="Logo" class="search-icon" style="margin-right: 5px; width: 30px; height: 30px;">
                                <input type="text" name="query" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>" required>
                                <button type="submit" class="btn btn-primary ml-2">SEARCH</button>
                            </div>
                        </div>
                    </form>

                
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($row)) : ?>
                                <?php foreach ($row as $rows) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($rows["id"], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($rows["category"], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($rows["item_description"], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($rows["unit_of_measure"], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($rows["quantity"], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($rows["unit_price"], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($rows["amount"], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <button onclick="showAlertEdit(this);" class="btn btn-primary btn-sm" data-id="<?= $rows['id'] ?>">
                                                Edit
                                            </button>

                                            <button onclick="showAlertDelete(this);" class="btn btn-danger btn-sm" data-id="<?= $rows['id'] ?>">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="text-center">No records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <div class="d-flex justify-content-center justify-content-md-end mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&query=<?php echo urlencode($query); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&query=<?php echo urlencode($query); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($page < $totalPage) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&query=<?php echo urlencode($query); ?>" aria-label="Next">
                            Next &raquo;
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <script>
        function showAlertEdit(button) {
            const id = button.getAttribute('data-id');
            const userConfirmed = confirm("Are you sure you want to Edit?");
            if (userConfirmed) {
                alert("You chose to edit.");
                window.location.href = './crud_form/edit_pod_dashboard.php?id=' + id;
            } else {
                alert("You chose not to edit.");
            }
        }

        function showAlertDelete(button) {
            const id = button.getAttribute('data-id');
            const userConfirmed = confirm("Are you sure you want to Delete?");
            if (userConfirmed) {
                alert("You chose to delete.");
                window.location.href = './crud_form/delete_pod_dashboard.php?id=' + id;
            } else {
                alert("You chose not to Delete.");
            }
        }
    </script>

</body>

</html>
