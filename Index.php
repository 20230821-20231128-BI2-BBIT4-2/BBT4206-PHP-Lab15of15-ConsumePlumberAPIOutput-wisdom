<!DOCTYPE html>
<html>
<head>
    <title>Diabetes Prediction</title>
</head>
<body>
    <h2>Diabetes Prediction Form</h2>
    <form method="post" action="">
        <label for="arg_pregnant">Pregnant:</label>
        <input type="number" id="arg_pregnant" name="arg_pregnant" required><br><br>
        
        <label for="arg_glucose">Glucose:</label>
        <input type="number" id="arg_glucose" name="arg_glucose" required><br><br>
        
        <label for="arg_pressure">Blood Pressure:</label>
        <input type="number" id="arg_pressure" name="arg_pressure" required><br><br>
        
        <label for="arg_triceps">Skin Thickness:</label>
        <input type="number" id="arg_triceps" name="arg_triceps" required><br><br>
        
        <label for="arg_insulin">Insulin:</label>
        <input type="number" id="arg_insulin" name="arg_insulin" required><br><br>
        
        <label for="arg_mass">BMI:</label>
        <input type="number" step="0.01" id="arg_mass" name="arg_mass" required><br><br>
        
        <label for="arg_pedigree">Diabetes Pedigree Function:</label>
        <input type="number" step="0.001" id="arg_pedigree" name="arg_pedigree" required><br><br>
        
        <label for="arg_age">Age:</label>
        <input type="number" id="arg_age" name="arg_age" required><br><br>
        
        <input type="submit" name="submit" value="Predict">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Process form data
        $apiUrl = 'http://127.0.0.1:5022/diabetes';

        // Extracting values from the form
        $params = array(
            'arg_pregnant' => $_POST['arg_pregnant'],
            'arg_glucose' => $_POST['arg_glucose'],
            'arg_pressure' => $_POST['arg_pressure'],
            'arg_triceps' => $_POST['arg_triceps'],
            'arg_insulin' => $_POST['arg_insulin'],
            'arg_mass' => $_POST['arg_mass'],
            'arg_pedigree' => $_POST['arg_pedigree'],
            'arg_age' => $_POST['arg_age']
        );

        // Initiate a new cURL session/resource
        $curl = curl_init();

        // Set the cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $apiUrl = $apiUrl . '?' . http_build_query($params);
        curl_setopt($curl, CURLOPT_URL, $apiUrl);

        // Make a GET request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            // Handle the error appropriately
            die("cURL Error: $error");
        }

        // Close cURL session/resource
        curl_close($curl);

        // Process the response
        $data = json_decode($response, true);

        // Check if the response was successful
        if (isset($data['0'])) {
            // API request was successful
            // Access the data returned by the API
            echo "<br>The predicted diabetes status is:<br>";
            foreach ($data as $repository) {
                echo $repository['0'], $repository['1'], $repository['2'], "<br>";
            }
        } else {
            // API request failed or returned an error
            echo "API Error: " . $data['message'];
        }
    }
    ?>
</body>
</html>
