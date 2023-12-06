<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Table</title>
    <link rel="stylesheet" href="style_table_order.css">

    <?php include 'sql_fetch_order.php'; ?>
</head>
<body>
    <div class="sidebar">
        <img src="logo.jpg" alt="Logo" class="logo">
        <button onclick="location.href='home.php'">Dashboard</button>
        <button onclick="location.href='table_order.php'">Order</button>
        <button onclick="location.href='table_supply.php'">Supply</button>
    </div>

    <?php
    // Number of rows to display per page
    $rowsPerPage = 4;

    // Calculate the total number of pages
    $totalPages = ceil(count($data) / $rowsPerPage);

    // Get the current page from the query parameter, default to 1 if not set
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // Calculate the starting index for the current page
    $startIndex = ($currentPage - 1) * $rowsPerPage;

    // Slice the data array to get rows for the current page
    $currentPageData = array_slice($data, $startIndex, $rowsPerPage);
    ?>

    <style>
         .status-pending {
            background-color: white; /* Adjust background color as needed */
        }

        .status-cancelled {
            background-color: #ffdddd; /* Light red */
        }

        .status-done {
            background-color: #d4edda; /* Light green */
        }
    </style>

    <?php if (!empty($currentPageData)): ?>
        <div class="container">
            <button onclick="location.href='order.php'" class="add-button">Add Order</button>
            <div class="form-container">
                <table>
                    <thead>
                        <tr>
                            <?php foreach ($currentPageData[0] as $key => $value) : ?>
                                <th><?= $key ?></th>
                            <?php endforeach; ?>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($currentPageData as $row) : ?>
                            <tr>
                                <?php foreach ($row as $key => $value) : ?>
                                    <td><?= $value ?></td>
                                <?php endforeach; ?>
                                <td>
                                    <select class="status-dropdown" data-order-id="<?= $row['OrderID'] ?>">
                                        <option value="PENDING">PENDING</option>
                                        <option value="CANCELLED">CANCELLED</option>
                                        <option value="DONE">DONE</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination buttons -->
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?= $currentPage - 1 ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" <?= $currentPage == $i ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?= $currentPage + 1 ?>">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <br>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusDropdowns = document.querySelectorAll('.status-dropdown');

            // Restore the selected status from local storage
            statusDropdowns.forEach(function (dropdown) {
                const orderId = dropdown.dataset.orderId;
                const key = `status-${orderId}`;

                // Check if there's a saved status for this row
                if (localStorage.getItem(key)) {
                    dropdown.value = localStorage.getItem(key);
                }

                // Add an event listener for status change
                dropdown.addEventListener('change', function () {
                    const selectedStatus = this.value;

                    // Update local storage for this row
                    localStorage.setItem(key, selectedStatus);
                    
                });
            });
        });
    </script>
</body>
</html>
