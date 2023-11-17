<?php

// Load environment variables from .env file
$env = parse_ini_file('.env');

// Access environment variables
$serverName = $env['AZURE_SQL_SERVERNAME'];
$database = $env['AZURE_SQL_DATABASE'];
$username = $env['AZURE_SQL_UID'];
$password = $env['AZURE_SQL_PWD'];

// Connect to SQL Server
$connectionOptions = array(
    "Database" => $database,
    "Uid" => $username,
    "PWD" => $password
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (isset($_GET['CustomerDetails'])) {
    getCustomerDetails($conn);
}
elseif (isset($_POST['addCustomerButton'])) {
    addCustomer($conn);
}
elseif (isset($_GET['showAllConsumption'])) {
    allCustomerConsumption($conn);
}


function getCustomerDetails($conn){
    // Check the connection
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    $sql = "SELECT * FROM [dbo].[Customer_Details]";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Echo the table header
    echo "<tr><th>Customer ID</th><th>Name</th><th>Phone Number</th><th>Alternate Phone Number</th><th>Connection Date</th><th>Standard Charges</th><th>Location Description</th></tr>";

    // Initialize an array to store table rows
    $tableRows = array();

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Append each row to the array
        $tableRows[] = "<tr><td>" . $row["Customer_ID_NO"] . "</td><td>" . $row["Customer_Name"] . "</td><td>" . $row["Phone_Number"] . "</td><td>" . $row["Alternate_Phone_Number"] . "</td><td>" . $row["Connection_Date"] . "</td><td>" . $row["Standard_Charges"] . "</td><td>" . $row["Location_Description"] . "</td></tr>";
    }

    // Echo the table rows
    foreach ($tableRows as $row) {
        echo $row;
    }

    sqlsrv_close($conn);
}


function addCustomer($conn) {
// Check the connection
    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Get data from POST
    $customerID = $_POST['customer_id'];
    $customerName = $_POST['customer_name'];
    $mainPhoneNo = $_POST['main-phone-no'];
    $alternatePhoneNo = isset($_POST['Alternate-phone-no']) ? $_POST['Alternate-phone-no'] : null;
    $standardCharges = $_POST['standard-charges'] == 'True' ? 1 : 0;
    $connectionDate = $_POST['conn-date'];
    $locationDescription = $_POST['location-desc'];

    // SQL INSERT statement
    $sql = "INSERT INTO [Customer_Details] (Customer_ID_NO,Customer_Name,Phone_Number,Alternate_Phone_Number,Connection_Date,Standard_Charges,Location_Description)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare and execute the SQL statement
    $params = array($customerID, $customerName, $mainPhoneNo, $alternatePhoneNo, $connectionDate, $standardCharges, $locationDescription);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Check for errors
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // // Assuming there are no errors and the insertion is successful
    // $successMessage = "Customer added successfully!";

    // // Output HTML for the overlay with the success message
    // echo "<div id='overlay' class='overlay'>
    //         <div class='popup'>
    //             <p class='success-message'>$successMessage</p>
    //         </div>
    //     </div>";
    
    // Redirect to index.html after a short delay
    echo "<script>
            setTimeout(function() {
                window.location.href = 'index.html#Customers';
            }, 10);
          </script>";
    
    sqlsrv_close($conn);
}

function allCustomerConsumption($conn){
    // Check the connection
    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }
    $sql_cons = "SELECT * FROM [dbo].[Consumption]";
    $stmt = sqlsrv_query($conn, $sql_cons);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Echo the table header
    echo "<tr><th>Name</th><th>Phone Number</th><th>Jan 2023</th><th>Feb 2023</th><th>Mar 2023</th><th>Apr 2023</th></tr>";

    // Initialize an array to store table rows
    $tableRows = array();

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Append each row to the array
        $tableRows[] = "<tr><td>" . $row["Customer_Name"] . "</td><td>" . $row["Phone_Number"] . "</td><td>" . $row["Jan2023"] . "</td><td>" . $row["Feb2023"] . "</td><td>" . $row["Mar2023"] . "</td><td>" . $row["Apr2023"] . "</td></tr>";
    }

    // Echo the table rows
    foreach ($tableRows as $row) {
        echo $row;
    }
    sqlsrv_close($conn);
}

// sqlsrv_free_stmt($stmt);


?>

