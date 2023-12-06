<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supply Table</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #007bff;
            padding-top: 20px;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
        }

        button {
            background-color: #0056b3;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            width: 150px;
        }

        button:hover {
            background-color: #004080;
        }

        .container {
            margin-left: 220px;
            margin-right: 220px; /* Adjusted to make the form centered */
        }

        .add-button {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            margin-left: 20px;
        }

        .add-button:hover {
            background-color: #218838;
        }

        .form-container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 100%; /* Make the form take the full width of the container */
        }

        table {
            width: 100%; /* Make the table take the full width of the form */
            border: 1px solid #ddd; /* Add a border to the table */
            border-collapse: collapse; /* Collapse borders into a single border */
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd; /* Add a border to separate table rows */
        }

        th {
            background-color: #f2f2f2; /* Add a background color to header cells */
        }

        button {
            cursor: pointer;
        }
    </style>
    <?php include 'sql_fetch_supply.php'; ?>
</head>
<body>
    <div class="sidebar">
        <img src="logo.jpg" alt="Logo" class="logo">
        <button onclick="location.href='home.php'">Dashboard</button>
        <button onclick="location.href='table_order.php'">Order</button>
        <button onclick="location.href='table_supply.php'">Supply</button>
    </div>

    <?php if (!empty($data)): ?>
        <div class="container">
            <button onclick="location.href='supply.php'" class="add-button">Add Supply</button>
            <div class="form-container">
                <table>
                    <thead>
                        <tr>
                            <?php foreach ($data[0] as $key => $value) : ?>
                                <th><?= $key ?></th>
                            <?php endforeach; ?>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) : $supplyId = $row['supply_id']; ?>
                            <tr>
                                <?php foreach ($row as $key => $value) : ?>
                                    <td><?= $value ?></td>
                                <?php endforeach; ?>
                                <td>
                                    <button onclick="editRow(<?= $supplyId ?>, '<?= $row['supply_name'] ?>', <?= $row['quantity'] ?>)">Edit</button>
                                    <button onclick="confirmDelete(<?= $supplyId ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <script>
        function confirmDelete(id) {
            var confirmation = confirm("Are you sure you want to delete this row?");
            if (confirmation) {
                // Redirect to delete script or perform delete operation
                window.location.href = 'delete_row.php?id=' + id;
            }
        }

        function editRow(supplyId, supplyName, quantity) {
        window.location.href = 'edit_supply.php?id=' + supplyId + '&name=' + supplyName + '&quantity=' + quantity;
        }
    </script>
</body>
</html>
