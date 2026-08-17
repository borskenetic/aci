document.addEventListener("DOMContentLoaded", () => {
  const mobileToggle = document.getElementById("mobile-toggle");
  const navLinks = document.getElementById("nav-links");
  const searchInput = document.getElementById("search-input");
  const clearBtn = document.getElementById("clear-btn");
  const searchForm = document.getElementById("opac-search-form");
  const tutorialVideo = document.getElementById("tutorial-video");

  // 1. Mobile Menu Toggle
  mobileToggle.addEventListener("click", () => {
    navLinks.classList.toggle("active");
    
    const icon = mobileToggle.querySelector("i");
    if (navLinks.classList.contains("active")) {
      icon.classList.remove("fa-bars");
      icon.classList.add("fa-xmark");
    } else {
      icon.classList.remove("fa-xmark");
      icon.classList.add("fa-bars");
    }
  });

  // 2. Clear Button Visibility
  searchInput.addEventListener("input", () => {
    clearBtn.style.display = searchInput.value.trim().length > 0 ? "block" : "none";
  });

  // 3. Clear Input Field
  clearBtn.addEventListener("click", () => {
    searchInput.value = "";
    clearBtn.style.display = "none";
    searchInput.focus();
  });

  // 4. Form Submission Handler
  searchForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const query = searchInput.value.trim();
    if (query) {
      alert(`Searching OPAC for: "${query}"`);
    }
  });

  // 5. Dynamic Background Scroll Position Variable
  window.addEventListener("scroll", () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrollPercent = scrollHeight > 0 ? scrollTop / scrollHeight : 0;

    // Update CSS custom property for background animations
    document.documentElement.style.setProperty("--scroll-percent", scrollPercent.toFixed(3));
  });

  // 6. Scroll Reveal Animation for Cards
  const revealObserverOptions = {
    root: null,
    rootMargin: "0px",
    threshold: 0.15
  };

  const revealObserver = new IntersectionObserver((entries, observerInstance) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observerInstance.unobserve(entry.target);
      }
    });
  }, revealObserverOptions);

  const scrollElements = document.querySelectorAll(".scroll-reveal");
  scrollElements.forEach(el => revealObserver.observe(el));

  // 7. Auto Play / Pause Video on Scroll
  if (tutorialVideo) {
    const videoObserverOptions = {
      root: null,
      rootMargin: "0px",
      threshold: 0.5
    };

    const videoObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          tutorialVideo.play().catch(error => {
            console.log("Autoplay prevented:", error);
          });
        } else {
          tutorialVideo.pause();
        }
      });
    }, videoObserverOptions);

    videoObserver.observe(tutorialVideo);
  }
});