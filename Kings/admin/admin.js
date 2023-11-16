// Admin login 
// document.getElementById("main-admin-section").style.display = "none";
document.getElementById("loginForm").style.display = "none";
document.getElementById("add-customer").style.display = "none";

function admin_login() {
    // Simulate a successful login (you should replace this with actual login logic)
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Validate credentials (you should replace this with a secure authentication process)
    var validUsername = "admin";
    var validPassword = "admin123";

    if (username === validUsername && password === validPassword) {
        // Display greeting
        var greetingDiv = document.getElementById("greeting");
        greetingDiv.innerHTML = "Hello, " + username + "! Welcome to the admin page.";
        greetingDiv.style.display = "block";

        // Hide the login form and display main content
        document.getElementById("loginForm").style.display = "none";
        document.getElementById("main-admin-section").style.display = "block";
    } else {
        // Invalid credentials
        alert("Invalid username or password");
    }
}

function addCustomer() {
    document.getElementById("CustomerDetails").style.display = "none";
    document.getElementById("add-customer").style.display = "block";

    // Collect form data
    var formData = $("#add-customer form").serializeArray();

    // Send AJAX request
    $.ajax({
        type: "POST",
        url: "all_customers.php",
        data: formData,
        success: function(response) {
            // alert(response);
        }
    });
}


function closeForm(){
    dodument.getElementById("add-customer").reset();
    document.getElementById("add-customer").style.display = "none";
}

