<?php

$serverName = "waterbillsandconsumotion.database.windows.net";
$connectionOptions = array(
    "Database" => "Test Meter reader",
    "Uid" => "Water-Admin",
    "PWD" => "DB-l0gin"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

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


if (isset($_POST['addCustomerButton'])) {
    addCustomer($conn);
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
}

// sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

?>

