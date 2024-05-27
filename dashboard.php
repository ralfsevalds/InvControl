<?php

include 'redirect_to.php';

// Include the db_connect.php file to connect to the database
require_once 'db_connect.php';

// Define an array of table names and corresponding variables
$tables = [
    'product' => 'totalProducts',
    'category' => 'totalCategories',
    'customer' => 'totalCustomers',
    'orders' => 'totalOrders'
];

// Fetch data for each table and assign the values to variables
foreach ($tables as $table => $variable) {
    $query = "SELECT COUNT(*) AS total FROM $table";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $$variable = $result['total'];
}

// Fetch order data for the chart
$orderQuery = "SELECT DATE_FORMAT(order_date, '%b %d') as order_date, total_order_amount FROM orders ORDER BY order_date";
$orderStmt = $conn->prepare($orderQuery);
$orderStmt->execute();
$orderResults = $orderStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch today's total order amount
$todayQuery = "SELECT SUM(total_order_amount) AS today_total FROM orders WHERE DATE(order_date) = CURDATE()";
$todayStmt = $conn->prepare($todayQuery);
$todayStmt->execute();
$todayResult = $todayStmt->fetch(PDO::FETCH_ASSOC);
$todayTotal = $todayResult['today_total'] ?? 0;

// Determine the profit status for styling
$profitStatus = $todayTotal >= 0 ? 'profit' : 'loss';

// Close the database connection
$conn = null;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/common-style.css">
    <link rel="stylesheet" href="css/data-style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <style>
        .dashboard-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 20px;
        }
        .chart-container {
            position: relative;
            height: 50vh;
            width: 70%;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
            padding: 20px;
        }
        .profit-container {
            position: relative;
            height: 50vh;
            width: 25%;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #333;
        }
        .profit {
            background-color: #e6ffe6;
            color: #006600;
        }
        .loss {
            background-color: #ffe0e0;
            color: #d8000c;
        }
    </style>
</head>

<body>

<?php include 'common-section.php'; ?>

<h2>Dashboard</h2>

<div class="analytics-section">
  <div class="analytics-cards">
    <div class="analytics-card">
      <i class="fas fa-box-open"></i>
      <h3>Total Products</h3>
      <span><?php echo $totalProducts; ?></span>
    </div>
    <div class="analytics-card">
      <i class="fas fa-tags"></i>
      <h3>Total Categories</h3>
      <span><?php echo $totalCategories; ?></span>
    </div>
    <div class="analytics-card">
      <i class="fas fa-user-friends"></i>
      <h3>Total Customers</h3>
      <span><?php echo $totalCustomers; ?></span>
    </div>
    <div class="analytics-card">
      <i class="fas fa-shopping-cart"></i>
      <h3>Total Orders</h3>
      <span><?php echo $totalOrders; ?></span>
    </div>
  </div>
</div>

<div class="dashboard-container">
  <div class="chart-container">
    <canvas id="ordersChart"></canvas>
  </div>

  <div class="profit-container <?php echo $profitStatus; ?>">
    <div>
      <h3>Today's Profits</h3>
      <span>$<?php echo number_format($todayTotal, 2); ?></span>
    </div>
  </div>
</div>

<script>
  // Get the order data from PHP
  const orderData = <?php echo json_encode($orderResults); ?>;

  // Extract dates and amounts for the chart
  const dates = orderData.map(order => order.order_date);
  const amounts = orderData.map(order => order.total_order_amount);

  // Create the chart
  const ctx = document.getElementById('ordersChart').getContext('2d');
  const ordersChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: dates,
      datasets: [{
        label: 'Total Order Amount',
        data: amounts,
        backgroundColor: 'rgba(91, 147, 221, 0.6)',
        borderColor: 'rgba(91, 147, 221, 1)',
        borderWidth: 1,
        barPercentage: 0.5,
        categoryPercentage: 0.5
      }]
    },
    options: {
      scales: {
        x: {
          type: 'category',
          title: {
            display: true,
            text: 'Date',
            font: {
              size: 16,
              weight: 'bold'
            }
          },
          ticks: {
            font: {
              size: 14
            }
          },
          grid: {
            display: false
          }
        },
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Total Order Amount',
            font: {
              size: 16,
              weight: 'bold'
            }
          },
          ticks: {
            font: {
              size: 14
            }
          },
          grid: {
            color: 'rgba(200, 200, 200, 0.2)'
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          labels: {
            font: {
              size: 14
            }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.7)',
          titleFont: { size: 14 },
          bodyFont: { size: 12 },
          callbacks: {
            label: function(context) {
              let label = context.dataset.label || '';
              if (label) {
                label += ': ';
              }
              label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
              return label;
            }
          }
        }
      }
    }
  });
</script>

</body>
</html>