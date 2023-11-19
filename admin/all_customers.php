<?php

// Load environment variables from .env file
$env = parse_ini_file('.env');

// Access environment variables

// $serverName = $env['AZURE_SQL_SERVERNAME'];
// $database = $env['AZURE_SQL_DATABASE'];
// $username = $env['AZURE_SQL_UID'];
// $password = $env['AZURE_SQL_PWD'];

$serverName = "kingswater-server.database.windows.net";
$database = "kingswater-database";
$username = "kingswater-server-admin";
$password = "M41207X0LY7DNL2E$";

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
elseif (isset($_POST['addNewMonth'])){
    newMonthCol($conn);
}

function newMonthCol($conn){
    if ($conn === false){
        die(print_r(sqlsrv_errors(), true));
    }

    $colName = $_POST['ColumnName'].' '.date("Y");

    $sql_Nw_col = "ALTER TABLE [dbo].[Consumption] ADD $colName INT NULL";
    $stmt = sqlsrv_query($conn, $sql);
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
        $tableRows[] = "<tr><td>" . $row["Customer ID NO"] . "</td><td>" . $row["Customer Name"] . "</td><td>" . $row["Phone Number"] . "</td><td>" . $row["Alternate Phone Number"] . "</td><td>" . $row["Connection Date"] . "</td><td>" . $row["Standard Charges"] . "</td><td>" . $row["Location Description"] . "</td></tr>";
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
    $standardCharges = $_POST['standard-charges'];
    $connectionDate = $_POST['conn-date'];
    $locationDescription = $_POST['location-desc'];

    // SQL INSERT statement
    $sql_1 = "INSERT INTO [Customer_Details] ([Customer ID NO],[Customer Name],[Phone Number],[Alternate Phone Number],[Connection Date],[Standard Charges],[Location Description])
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare and execute the SQL statement
    $params = array($customerID, $customerName, $mainPhoneNo, $alternatePhoneNo, $connectionDate, $standardCharges, $locationDescription);
    $stmt1 = sqlsrv_query($conn, $sql_1, $params);

    // Run stmt2 to get the phone number
    $sql_2 = "INSERT INTO [Consumption] ([Phone Number]) SELECT [Phone Number] FROM [Customer_Details] WHERE [Customer_Details].[ID] = (SELECT MAX([ID]) FROM [Customer_Details])";
    $stmt2 = sqlsrv_query($conn, $sql_2, array($sql_2));
    
    // Check for errors
    if ($stmt1 === false || $stmt2 === false) {
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
    $sql_cons = "SELECT [Customer Name], Consumption.* FROM [dbo].[Customer_Details] JOIN [dbo].[Consumption] ON Customer_Details.[Phone Number] = Consumption.[Phone Number]";
    $stmt = sqlsrv_query($conn, $sql_cons);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    // Initialize an array to store table rows
    $tableRows = array();

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Append each row to the array
        $tableRows[] = "<tr><td>" . $row["Customer Name"] . "</td><td>" . $row["Phone Number"] . "</td><td>" . $row["Jan 2023"] . "</td><td>" . $row["Feb 2023"] . "</td><td>" . $row["Mar 2023"] . "</td><td>" . $row["Apr 2023"] . "</td></tr>";
    }

    // Echo the table rows
    foreach ($tableRows as $row) {
        echo $row;
    }
    sqlsrv_close($conn);
}

// sqlsrv_free_stmt($stmt);


?>

