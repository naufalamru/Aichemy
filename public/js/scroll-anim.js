document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll(".slide-left");

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, { threshold: 0.3 });

    elements.forEach(el => observer.observe(el));
});
