<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flood Details Map</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Chart.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.css">
    <style>
        /* Night mode theme */
        body {
            background-color: #0e0e0e;
            color: #fff;
        }
        .navbar {
            background-color: #333; /* Dark grey */
        }
        .navbar-brand {
            color: #f0f0f0; /* Light grey */
            font-weight: bold;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(255, 255, 255, 0.1); /* White shadow */
            background-color: #222; /* Dark grey */
            color: #fff; /* White text */
        }
        th{color: aliceblue;}
        tr{
            color: aqua;
        }
        .btn {
            border-radius: 20px;
        }
        .footer {
            background-color: #111; /* Very dark grey */
            padding: 20px 0;
            text-align: center;
        }
        #map {
            height: 400px;
        }
        #lineChart { 
            height: 400px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Flood Details Map</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center mb-4">Flood Details Map</h1>
    <div class="row">
        <!-- Map -->
        <div class="col-md-8">
            <div id="map"></div>
        </div>
        
        <!-- Line chart -->
        <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Flood Severity (Line Chart)</h5>
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            
            <!-- Prediction module -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Flood Severity Prediction</h5>
                    <form id="predictionForm">
                        <div class="form-group">
                            <label for="inputMonth">Select Month:</label>
                            <select class="form-control" id="inputMonth" required>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputTemperature">Temperature (°C):</label>
                            <input type="number" class="form-control" id="inputTemperature" placeholder="Enter temperature" required>
                        </div>
                        <div class="form-group">
                            <label for="inputRainfall">Rainfall (mm):</label>
                            <input type="number" class="form-control" id="inputRainfall" placeholder="Enter rainfall" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Predict</button>
                    </form>
                    <div id="predictionResult" class="mt-3"></div>
                </div>
            </div>
            
        </div>
        
    </div>
    <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Flood Analysis Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="floodChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- PHP to fetch data from database -->
        <?php
        $servername = "srv1124.hstgr.io";
        $username = "u632480160_52project";
        $password = "@Babahelp13";
        $db = "u632480160_52project";
    
        // Create connection
        $connection = new mysqli($servername, $username, $password, $db);
    
        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
    
        // Query to fetch data from the 'user' table
        $sql = "SELECT year, level FROM user";
    
        // Execute the query
        $result = mysqli_query($connection, $sql);
    
        // Initialize arrays to store fetched data
        $years = [];
        $levels = [];
    
        // Fetch data and populate arrays
        while ($row = mysqli_fetch_assoc($result)) {
            $years[] = $row['year'];
            $levels[] = $row['level'];
        }
    
        // Close database connection
        mysqli_close($connection);
        ?>
</div>

<!-- Footer -->
<footer class="footer mt-5 bg-dark text-white">
    <div class="container text-center">
      <p class="mb-0">Designed and Developed by Your Company</p>
    </div>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

<script>
    // Initialize map
    var map = L.map('map').setView([20.5937, 78.9629], 5); // Default center of India

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Dummy data for flood severity
    var floodData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'Flood Severity',
            data: [3, 4, 2, 3, 5, 4, 3], // Example data, replace with actual data
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.4
        }]
    };

    // Initialize line chart
    var ctx = document.getElementById('lineChart').getContext('2d');
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: floodData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Prediction form submission
    document.getElementById('predictionForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var month = document.getElementById('inputMonth').value;
        var temperature = parseFloat(document.getElementById('inputTemperature').value);
        var rainfall = parseFloat(document.getElementById('inputRainfall').value);
        var predictionResult = predictFloodSeverity(month, temperature, rainfall);
        document.getElementById('predictionResult').innerHTML = '<p>Predicted Flood Severity: ' + predictionResult + '</p>';
    });

    // Function to predict flood severity (dummy implementation)
    function predictFloodSeverity(month, temperature, rainfall) {
        // Dummy prediction logic (replace with actual prediction algorithm)
        var severity = 1; // Default severity
        if (month === 'July' && temperature > 30 && rainfall > 100) {
            severity = 5; // Extreme severity
        } else if (month === 'August' && temperature > 35 && rainfall > 150) {
            severity = 4; // Severe severity
        } else if (month === 'September' && temperature > 30 && rainfall > 120) {
            severity = 3; // Moderate severity
        }
        return severity;
    }
</script>

</body>
</html>
