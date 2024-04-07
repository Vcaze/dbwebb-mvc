console.log("lucky.js started");
console.info("lucky.js started");

const imgPath = "../../img/";

const numberFilenames = [
    "zero.png",
    "one.png",
    "two.png",
    "three.png",
    "four.png",
    "five.png",
    "six.png",
    "seven.png",
    "eight.png",
    "nine.png",
    "times.png",
    "equals.png"
];

// Get the two factors and their product
let product = 1000;
let factorOne;
let factorTwo;
while (product > 999) {
    // Randomize factor one and two
    factorOne = Math.floor(Math.random() * 90) + 10;
    factorTwo = Math.floor(Math.random() * 90) + 10;
    // Get the product of the factors
    product = factorOne * factorTwo;
}

// Factors and product to strings
const factorOneString = factorOne.toString();
const factorTwoString = factorTwo.toString();
const productString = product.toString();

// Add the numbers and signs to the divs on the page
addImageToDiv(factorOneString[0], "factor-one-first");
addImageToDiv(factorOneString[1], "factor-one-second");
addImageToDiv(10, "times");
addImageToDiv(factorTwoString[0], "factor-two-first");
addImageToDiv(factorTwoString[1], "factor-two-second");
addImageToDiv(11, "equals");
addImageToDiv(productString[0], "product-first");
addImageToDiv(productString[1], "product-second");
addImageToDiv(productString[2], "product-third");

// Make the container div spin and move up and down
const multiplicationDiv = document.getElementsByClassName("multiplication")[0];
multiplicationDiv.classList.add("moving");

// Function to add the image for a number or a sign to a div
function addImageToDiv(number, divClassName) {
    const div = document.getElementsByClassName(divClassName)[0];
    let img = document.createElement("img");
    img.src = imgPath + numberFilenames[parseInt(number)];
    div.appendChild(img);
    div.classList.add("zoom-in");
}

// debugging
console.log("lucky.js is being run fully");

console.log("fac 1: " + factorOne);
console.log("fac 2: " + factorTwo);
console.log("prod: " + product);
console.log("imgpath: " + imgPath + "one");
