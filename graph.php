<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Quantity Column Chart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        Product Quantity Column Chart
                    </div>
                    <div class="card-body">
                        <canvas id="columnChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetch data from the database using PHP (replace with your actual connection details)
        <?php
        $conn = new mysqli("localhost", "root", "", "inventory");
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT product_name, SUM(product_quantity) AS total_quantity FROM products GROUP BY product_name";
        $result = $conn->query($sql);
        
        $labels = [];
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $labels[] = $row["product_name"];
                $data[] = $row["total_quantity"];
            }
        }

        $conn->close();
        ?>

        // Create the column chart
        var ctx = document.getElementById("columnChart").getContext("2d");
        var columnChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: "Product Quantity",
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: "rgba(54, 162, 235, 0.7)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Total Quantity"
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
