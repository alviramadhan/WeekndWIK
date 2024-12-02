document.getElementById("loginForm").addEventListener("submit", function (event) {
    const email = document.querySelector("[name='email']").value;
    const password = document.querySelector("[name='password']").value;

    if (!email || !password) {
        event.preventDefault();
        alert("Please fill in both email and password.");
    }
});

