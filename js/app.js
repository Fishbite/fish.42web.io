const listItems = document.querySelectorAll(".listElement");

console.log(listItems);

listItems.forEach((element) => {
  element.addEventListener("click", (e) => {
    e.preventDefault();

    return false;
  });

  element.addEventListener(
    "contextmenu",
    (e) => {
      e.preventDefault();

      return false;
    },
    true
  );
});
