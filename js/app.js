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
  "customer service": "images/about/headset-2.svg",
  "precision engineering": "images/about/space-shuttle-w.svg",
  manufacturing: "images/about/manufacturing-mc.svg",
  "product design": "images/about/product-design.svg",
  "colour management": "images/about/brain-color-3.svg",
};

function handleClick(e) {
  e.preventDefault();

  // remove the background text and image properties
  removeBg(e);

  // we need to make sure the replacement image has fully loaded
  // otherwise there be dragons!
  async function loadImg(e) {
    console.log("running loadImg");

    const imgLoadPromise = new Promise((resolve) => {
      img.setAttribute("src", bgImages[e.target.innerHTML]);
      console.log("img.src", img.src);

      if (
        img.src == "https://fish.42web.io/images/about/brain-color-3.svg" ||
        img.src ==
          "http://localhost/fish.42web.io/images/about/brain-color-3.svg"
      ) {
        img.classList.remove("bg-img");
        img.classList.add("bg-img-no-sep");
      }

      // resolve the promise when image has loaded
      img.onload = resolve;
    });

    // wait for the promise to resolve
    await imgLoadPromise;
  }

  // load the image
  loadImg(e).then((e) => {
    console.log("image loaded?", img.src);

    // then set the properties for the image
    setProps(e);
  });
}

function removeBg(e) {
  console.log("removing bg", e.target.innerHTML);

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

  // if (e.target.innerHTML === "colour management") {
  //   img.style.filter = "";
  // }

  // could be redundant now but used to give time to load image
  window.setTimeout(() => {
    img.style.transition = "opacity 0.5s";
    img.style.opacity = "1";
  }, 0);
}
