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

//visit count 
let visitCount = localStorage.getItem("visitCount");

if (!visitCount) {
  visitCount = 0;
}

visitCount = parseInt(visitCount) + 1;
localStorage.setItem("visitCount", visitCount);

const visitCountElement = document.getElementById("visit-count");
visitCountElement.textContent = `${visitCount} visits`;
