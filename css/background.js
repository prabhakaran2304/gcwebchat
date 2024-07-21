//visit count 
let visitCount = localStorage.getItem("visitCount");

if (!visitCount) {
  visitCount = 0;
}

visitCount = parseInt(visitCount) + 1;
localStorage.setItem("visitCount", visitCount);

const visitCountElement = document.getElementById("visit-count");
visitCountElement.textContent = `${visitCount} visits`;
