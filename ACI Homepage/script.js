document.addEventListener("DOMContentLoaded", () => {
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, observerOptions);

    // Select the elements we want to animate
    const hiddenElements = document.querySelectorAll('.hidden');
    hiddenElements.forEach((el) => observer.observe(el));
});

const observerOptions = { threshold: 0.15 };

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
        }
    });
}, observerOptions);

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

const modal = document.getElementById("historyModal");
const readMoreBtn = document.querySelector(".read-more");
const closeBtn = document.querySelector(".close-btn");

// 1. Open the modal
readMoreBtn.addEventListener("click", () => {
    modal.classList.add("active");
    document.body.style.overflow = "hidden"; // Disable background scrolling
});

// 2. Close when clicking the "X"
closeBtn.addEventListener("click", () => {
    modal.classList.remove("active");
    document.body.style.overflow = "auto"; // Re-enable background scrolling
});

// 3. Close when clicking outside the white box
window.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.classList.remove("active");
        document.body.style.overflow = "auto";
    }
});

