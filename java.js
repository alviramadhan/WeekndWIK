document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevents form from refreshing the page

            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;

            // Simple validation
            if (email == "example@example.com" && password == "password123") {
                alert("Login successful!");
                window.location.href="homepage.html";
            } else {
                alert("Invalid email or password");
            }
        });

document.querySelector('.signup-button').addEventListener('click', function () {
    window.location.href = "signUp.html";
});
