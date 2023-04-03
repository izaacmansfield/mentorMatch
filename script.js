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

function sendInteraction(status) {
  const userEmail = 'user@example.com'; // Replace this with the actual user email
  const profileEmail = 'profile@example.com'; // Replace this with the actual profile email

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'interactions.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
      if (this.status === 200) {
          console.log('Interaction saved:', this.responseText);
      } else {
          console.error('An error occurred while saving the interaction');
      }
  };

  xhr.send(`userEmail=${encodeURIComponent(userEmail)}&profileEmail=${encodeURIComponent(profileEmail)}&status=${status}`);
}

function animateCross() {
  const crossButton = document.querySelector('.cross-button');
  crossButton.animate([
      { transform: 'scale(1)', opacity: 1 },
      { transform: 'scale(1.2)', opacity: 0.5 },
      { transform: 'scale(1)', opacity: 1 },
  ], {
      duration: 300,
      iterations: 1
  });
}

function animateCheck() {
  const checkButton = document.querySelector('.check-button');
  checkButton.animate([
      { transform: 'scale(1)', opacity: 1 },
      { transform: 'scale(1.2)', opacity: 0.5 },
      { transform: 'scale(1)', opacity: 1 },
  ], {
      duration: 300,
      iterations: 1
  });
}
