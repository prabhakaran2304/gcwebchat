//--------------Dark and white mode -----------------//

let toggler = document.getElementById("switch");

toggler.addEventListener("click", () => {
  //   if (toggler.checked === true) {
  //     document.body.style.backgroundColor = "black";
  //   } else {
  //     document.body.style.backgroundColor = "white";
  //   }

  toggler.checked === true
    ? (document.body.style.backgroundColor = "black")
    : (document.body.style.backgroundColor = "white");
});

//-------------- Digital clock-----------//
const clock = document.querySelector(".clock");

clock.addEventListener("load", tick);

function tick() {
  const now = new Date();
  const h = now.getHours();
  const m = now.getMinutes();
  const s = now.getSeconds();

  const html = `
        <span>${h} :</span>
        <span>${m} :</span>
        <span>${s}</span>
    `;
  clock.innerHTML = html;
}

setInterval(tick, 1000);
