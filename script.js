async function checkLogin(event) {
  event.preventDefault();

  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  const formData = new FormData();
  formData.append("action", "login");
  formData.append("email", email);
  formData.append("password", password);

  const response = await fetch("user_actions.php", {
    method: "POST",
    body: formData,
  });

  const data = await response.json();

  if (data.error) {
    alert("Error: " + data.error);
  } else if (data.password === password) {
    alert("Login successful!");
    window.location.href = "./MenteePage.html";
    // Redirect to a protected page or perform other actions upon successful login
  } else {
    alert("Incorrect password. Please try again.");
  }
}

async function createAccount(event) {
  event.preventDefault();

  const name = document.getElementById("name").value;
  const email = document.getElementById("newemail").value;
  const password = document.getElementById("newpassword").value;

  const formData = new FormData();
  formData.append("action", "create_account");
  formData.append("name", name);
  formData.append("email", email);
  formData.append("password", password);

  const response = await fetch("user_actions.php", {
    method: "POST",
    body: formData,
  });

  const data = await response.json();

  if (data.success) {
    alert("Account created successfully!");
    window.location.href = "./login.html";
    // Redirect to a login page or perform other actions upon successful account creation
  } else {
    alert("Error: " + data.error);
  }
}