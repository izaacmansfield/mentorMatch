let userEmail = "";
let userPassword = "";
var row_num=1;



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
  console.log(data.mentor);
  

  if (data.success) {
    // Login successful
    // You can redirect the user to another page or update the UI accordingly
    if(data.mentor===1){
      window.location.href = "mentee.html";
    }
    else{
      window.location.href="mentor.html";
    }
     // Redirect to a dashboard or other page
} else if (data.error) {
    // Show an error message
    alert(data.error);
} else {
    // Unexpected response format
    alert("An unexpected error occurred.");
}
}

async function createAccount(event) {
  event.preventDefault();

  const name = document.getElementById("name").value;
  const email = document.getElementById("newemail").value;
  const password = document.getElementById("newpassword").value;
  // const mentor = document.getElementsByName("userselection").value

  const radioButtons = document.querySelectorAll('input[name="userselection"]');
  let mentor;
  for (const radioButton of radioButtons) {
      if (radioButton.checked) {
          mentor = radioButton.value;
          break;
      }
  }

  const formData = new FormData();
  formData.append("action", "create_account");
  formData.append("name", name);
  formData.append("email", email);
  formData.append("password", password);
  formData.append("mentor", mentor);

  const response = await fetch("user_actions.php", {
    method: "POST",
    body: formData,
  });

  const data = await response.json();
  // console.log(await response.text()); // Add this line to print the raw response text


  if (data.success) {
    alert("Account created successfully!");
    window.location.href = "./login.html";
    // Redirect to a login page or perform other actions upon successful account creation
  } else {
    alert("Error: " + data.error);
  }
}

// function sendInteraction(status) {
//   const userEmail = 'user@example.com'; // Replace this with the actual user email
//   const profileEmail = 'profile@example.com'; // Replace this with the actual profile email

//   if (status === 'rejected') {
//       animateCross();
//   } else if (status === 'accepted') {
//       animateCheck();
//   }

//   const xhr = new XMLHttpRequest();
//   xhr.open('POST', 'interactions.php', true);
//   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

//   xhr.onload = function() {
//       if (this.status === 200) {
//           console.log('Interaction saved:', this.responseText);
//       } else {
//           console.error('An error occurred while saving the interaction');
//       }
//   };

//   xhr.send(`userEmail=${encodeURIComponent(userEmail)}&profileEmail=${encodeURIComponent(profileEmail)}&status=${status}`);
// }

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

// document.getElementById("create-profile-form").addEventListener("submit", createProfile);

async function createProfile(event) {
  event.preventDefault();
  try {
  const email = await getEmail();

  if (email) {

  const major = document.getElementById("major").value;
  const schoolyear = document.getElementById("school-year").value;
  const description = document.getElementById("description").value;
  const linkedin = document.getElementById("linkedin").value;
  

  const formData = new FormData();
  formData.append("action", "create_profile");
  formData.append("email", email);
  formData.append("major", major);
  formData.append("schoolyear", schoolyear);
  formData.append("description", description);
  formData.append("linkedin",linkedin);

  const response = await fetch("user_actions.php", {
    method: "POST",
    body: formData,
  });

  const data = await response.json();
  


  if (data.success) {
    alert("Profile created successfully!");
    
    if(data.mentor===1){
      window.location.href = "./mentee.html";
    }
    else{
      window.location.href = "./mentor.html"
    }
    
    // Redirect to a login page or perform other actions upon successful account creation
  } else {
    alert("Error: " + data.error);
  }
} else {
  console.log("Error getting email from session");
}  } catch (error) {
  console.error("Error in createProfile function:", error);
}
}

async function getEmail() {
  const formData = new FormData();
  formData.append("action", "get_email");

  const response = await fetch("user_actions.php", {
    method: "POST",
    body: formData,
  });

  const data = await response.json();


  if (data.user_email) { 
    console.log("Fetched email:", data.user_email); // Add this line
    return data.user_email;
  } else {
    console.error("Error getting email:", data);
    return null;
  }
}
async function tinder_match(){
  const formData = new FormData();
  formData.append("action", "tinder_match");
  formData.append("row_num",row_num);
  const response = await fetch("user_actions.php", {
    method: "POST",
    body: formData,
  });
  const data3 = await response.json();

  document.getElementById('Name').innerHTML= data3.name;
  document.getElementById('email').innerHTML= data3.email;
  document.getElementById('major').innerHTML= data3.major;
  document.getElementById('school_year').innerHTML= data3.school_year;
  document.getElementById('description').innerHTML= data3.description;
  document.getElementById('linkedin').innerHTML= data3.linkedin;
  
}

async function send_interaction(status){
  const formdata = new FormData();
  formdata.append("action","send_interaction");
  formdata.append("status",status);
  if (status === 'rejected') {
          animateCross();
   } 
   else if (status === 'accepted') {
          animateCheck();
      }
  const response = await fetch("user_actions.php",{
    method: "POST",
    body:formdata,
  });
  row_num++;
  tinder_match();

}

// window.addEventListener("unload", (event) => {
//   // Call the logout function
//   logout();
// });

// function logout() {
//   const formData = new FormData();
//   formData.append("action", "logout");

//   // Use navigator.sendBeacon to send the request
//   navigator.sendBeacon("user_actions.php", formData);
// }

async function populateTable(){
  const formdata = new FormData;
  formdata.append('action', 'populateTable');
  const response = await fetch("user_actions.php",{
    method: "POST",
    body:formdata,
  });




}