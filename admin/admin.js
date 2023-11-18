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


function closeForm() {
    document.getElementById("AddCustomerForm").reset();
    document.getElementById("AddCustomerForm").style.display = "none";
    document.getElementById("CustomerDetails").style.display = "block";
}

function getCurrentMonth() {
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const date = new Date();

    document.getElementById('currentMonth').innerHTML = months[date.getMonth()].substring(0,3) + ' ' + date.getFullYear();
    // const monthName = date.toLocaleString('default', { month: 'long' }).substring(0,3);
    // document.getElementById('CurrentMonth').innerHTML = monthName + ' ' + date.getFullYear();
}


function addPrevMonthCol() {

}

function addNewCol(){
    
}