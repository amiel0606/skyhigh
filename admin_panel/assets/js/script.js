
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";  
  document.getElementById("main-content").style.marginLeft = "250px";
  document.getElementById("main").style.display="none";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";  
  document.getElementById("main").style.display="block";  
}

document.addEventListener('DOMContentLoaded', async () => {
  try {
      const response = await fetch('getUser.php');
      if (response.ok) {
          const user = await response.json();
          document.querySelector('input[name="Name"]').value = user.username || '';
          document.querySelector('input[name="Email"]').value = user.email || '';
          document.querySelector('input[name="Address"]').value = user.address || '';
          document.querySelector('input[name="Phone"]').value = user.phone || '';
      } else {
          console.error('Failed to fetch user data');
      }
  } catch (error) {
      console.error('Error fetching user data:', error);
  }
});
