async function checkLogin(event) {
  event.preventDefault();

  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  const formData = new FormData();
  formData.append("email", email);
  formData.append("password", password);

  const response = await fetch("check_login.php", {
    method: "POST",
    body: formData,
  });

  const data = await response.json();

  if (data.error) {
    alert("Error: " + data.error);
  } else if (data.password === password) {
    alert("Login successful!");
    // Redirect to a protected page or perform other actions upon successful login
  } else {
    alert("Incorrect password. Please try again.");
  }
}