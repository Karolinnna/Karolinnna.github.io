//1.2 code
console.log("count of p: "  + document.getElementsByTagName("p").length);
console.log("count of h2: " + document.getElementsByTagName("h2").length);
console.log(getComputedStyle(document.body).backgroundColor);
console.log(getComputedStyle(document.getElementsByTagName("h1")[0]).fontSize);

//1.3 code
let elem = document.body.childNodes;
elem.forEach(element => {
    if (element instanceof HTMLElement) {
        element.addEventListener("mouseenter", () => {
            element.style.backgroundColor = "red";
        });
        element.addEventListener("mouseleave", () => {
            element.style.backgroundColor = "";
        });
    }
});