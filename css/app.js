//clock
function updateClock() {
  const clockElement = document.getElementById("clock");
  const now = new Date();
  const hours = String(now.getHours()).padStart(2, "0");
  const minutes = String(now.getMinutes()).padStart(2, "0");
  const seconds = String(now.getSeconds()).padStart(2, "0");
  const time = `${hours}:${minutes}:${seconds}`;
  clockElement.textContent = time;
}

setInterval(updateClock, 1000);

// Get the button element
const changeColorButton = document.getElementById('changeColorButton');

// Function to generate a random color
function getRandomColor() {
  const letters = '0123456789ABCDEF';
  let color = '#';
  for (let i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

// Function to change the background color on button click
function changeBackgroundColor() {
  const newColor = getRandomColor();
  document.body.style.backgroundColor = newColor;
}

// Add event listener to the button
changeColorButton.addEventListener('click', changeBackgroundColor);
