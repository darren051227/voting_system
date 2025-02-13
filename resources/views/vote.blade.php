<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
     body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    padding: 20px;
}

h1, h2 {
    color: #343a40;
    margin-bottom: 20px;
    font-weight: 700;
}

form {
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 400px;
    text-align: left;
}

label {
    font-weight: 600;
    display: block;
    margin: 12px 0 6px;
    color: #495057;
}

select, input {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 16px;
    background-color: #f1f3f5;
    transition: all 0.3s;
}

select:focus, input:focus {
    border-color: #007bff;
    background-color: #ffffff;
    outline: none;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 14px;
    margin-top: 20px;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
    font-weight: bold;
    border-radius: 6px;
    transition: background-color 0.3s ease-in-out;
}

button:hover {
    background-color: #0056b3;
}

canvas {
    margin-top: 30px;
    background: white;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    max-width: 500px;
}

    </style>
</head>
<body>
    <h1>Vote for Your Favorite Fruit</h1>

    <form id="voteForm">
        @csrf <!-- Make sure @csrf is here -->
        <label>Choose a fruit:</label>
        <select name="subject" id="subject">
            <option value="apple">Apple</option>
            <option value="orange">Orange</option>
            <option value="pineapple">Pineapple</option>
            <option value="watermelon">Watermelon</option>
            <option value="mango">Mango</option>
        </select>
        <label>Rate (1-5):</label>
        <input type="number" name="rating" id="rating" min="1" max="5" required>
        <button type="submit">Submit Vote</button>
    </form>

    <h2>Voting Results</h2>
    <canvas id="voteChart"></canvas>

    <script>
        // Initialize the chart
        const ctx = document.getElementById('voteChart').getContext('2d');
        const voteChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: ['red', 'orange', 'yellow', 'green', 'blue']
                }]
            }
        });

        // Function to fetch and update the chart data
        function updateChart() {
            fetch('/get-votes')
                .then(response => response.json())
                .then(data => {
                    voteChart.data.labels = Object.keys(data);
                    voteChart.data.datasets[0].data = Object.values(data);
                    voteChart.update();
                });
        }

        // Handle form submission
        document.getElementById('voteForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('/vote', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateChart();
                }
            });
        });

        // Initial chart update
        updateChart();
    </script>
</body>
</html>