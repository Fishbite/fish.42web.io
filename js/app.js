const listItems = document.querySelectorAll(".listElement");
const img = document.getElementById("bg-target");
const header = document.getElementById("header");
console.log(header);

console.log(listItems);

listItems.forEach((element) => {
  element.style.cursor = "pointer";
  element.addEventListener("click", handleClick, false);
});

const bgImages = {
  "customer service": "images/about/call-center.svg",
  "precision engineering": "images/about/space-shuttle-w.svg",
};

function handleClick(e) {
  e.preventDefault();

  removeBg(e);

  // we need to make sure the replacement image has fully loaded
  // otherwise there be dragons!
  async function loadImg(e) {
    console.log("running loadImg");
    const imgLoadPromise = new Promise((resolve) => {
      img.setAttribute("src", bgImages[e.target.innerHTML]);
      console.log("img.src", img.src);
      img.onload = resolve;
    });

    await imgLoadPromise;
  }

  loadImg(e).then((e) => {
    console.log("image loaded?", img.src);
    setProps();
  });
}

function removeBg(e) {
  console.log("removing bg");

  if (img.style.transition) {
    img.style.removeProperty("transition");
  }
  if (img.src) {
    img.setAttribute("src", "");
  }
  if (img.style.opactiy !== 0) {
    img.style.opacity = 0;
  }
}

function setProps(e) {
  if (header.style.opacity !== 0) {
    header.style.opacity = "0";
  }

  // could be redundant now but used to give time to load image
  window.setTimeout((e) => {
    img.style.transition = "opacity 0.5s";
    img.style.opacity = "1";
  }, 0);
}
