<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .leave-report {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Leave Report</h1>

    <div class="container">
        <canvas id="leaveChart" width="400" height="400"></canvas>
    </div>

    <?php
    require("connection.php");

    $sql_total = "SELECT COUNT(*) AS total_leaves FROM reason";
    $result_total = $conn->query($sql_total);
    $total_leaves = $result_total->fetch_assoc()['total_leaves'];

    $sql_approved = "SELECT COUNT(*) AS approved_leaves FROM reason WHERE status = 'Accepted'";
    $result_approved = $conn->query($sql_approved);
    $approved_leaves = $result_approved->fetch_assoc()['approved_leaves'];

    $sql_rejected = "SELECT COUNT(*) AS rejected_leaves FROM reason WHERE status = 'Rejected'";
    $result_rejected = $conn->query($sql_rejected);
    $rejected_leaves = $result_rejected->fetch_assoc()['rejected_leaves'];

    $pending_leaves = $total_leaves - $approved_leaves - $rejected_leaves;
    $conn->close();
    ?>

    <script>
        var ctx = document.getElementById('leaveChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Approved', 'Pending', 'Rejected'],
                datasets: [{
                    label: '# of Leaves',
                    data: [<?php echo $approved_leaves; ?>, <?php echo $pending_leaves; ?>, <?php echo $rejected_leaves; ?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

    <div class="leave-report">
        <p>Total Leaves Requested: <?php echo $total_leaves; ?></p>
        <p>Approved Leaves: <?php echo $approved_leaves; ?></p>
        <p>Pending Leaves: <?php echo $pending_leaves; ?></p>
        <p>Rejected Leaves: <?php echo $rejected_leaves; ?></p>
    </div>
</body>

</html>