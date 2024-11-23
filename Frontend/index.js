// Navigation [HamBurger] for less than 768px 

document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.querySelector(".hamburger");
    const navigation = document.querySelector(".navigation");

    hamburger.addEventListener("click", () => {
        navigation.classList.toggle("active");
    });
});
