let navlinks = document.querySelectorAll("li");

navlinks.forEach(link => {
    link.addEventListener("click", () => {
        let active = document.querySelector(".active");
        active.classList.remove("active");
        link.classList.add("active");
    })
});