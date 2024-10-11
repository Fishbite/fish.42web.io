const listItems = document.querySelectorAll(".listElement");
const img = document.getElementById("bg-target");
const header = document.getElementById("header");
const bgTextContainer = document.getElementById("bg-text-container");
const bgTitle = document.getElementById("bg-title");
const bgText = document.getElementById("bg-text");
const subTitle = document.getElementById("sub-title");
// get items from document

listItems.forEach((element) => {
  element.style.cursor = "pointer";
  element.addEventListener("click", handleClick, false);
});

const bgImages = {
  "customer service": ["images/about/headset-5.svg"],
  "precision engineering": ["images/about/space-shuttle-w.svg"],
  manufacturing: ["images/about/manufacturing-mc.svg"],
  "product design": ["images/about/product-design.svg"],
  "colour management": ["images/about/brain-color-3.svg"],
};

const bgTextContent = {
  "customer service":
    "<p>Listen, care, understand</p><p>Be there</p><p>Deliver</p><p>Exceed expectations</p>",
  "precision engineering":
    "<p>A world where '<em>off by a hair</em>' means</p><p>out by a mile</p>",
  manufacturing:
    "<p>Production planning</p><p>Scheduling</p><p>Quality Control</p>",
  "product design": "<p>Egonomics</p><p>useability</p><p>appeal</p>",
  "colour management": "<p>Branding</p><p>standards</p><p>repeatability</p>",
};

function handleClick(e) {
  e.preventDefault();

  bgTitle.innerHTML = e.target.innerHTML;

  // remove the background text and image properties
  removeBg(e);

  // we need to make sure the replacement image has fully loaded
  // otherwise there be dragons!
  async function loadImg(e) {
    console.log("running loadImg");

    const imgLoadPromise = new Promise((resolve) => {
      img.setAttribute("src", bgImages[e.target.innerHTML][0]);
      bgText.innerHTML = bgTextContent[e.target.innerHTML];

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

  bgTextContainer.classList.remove("visible");
  subTitle.style.opacity = 0;

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
  // if (header.style.opacity !== 0) {
  //   header.style.opacity = "0";
  // }
  header.style.opacity = "0";
  // bgTextContainer.classList.remove("visible");

  // could be redundant now but used to give time to load image
  window.setTimeout(() => {
    img.style.transition = "opacity 1s";
    img.style.opacity = "1";
    window.setTimeout(() => {
      bgTextContainer.classList.toggle("visible");
    }, 250);
  }, 0);
}
