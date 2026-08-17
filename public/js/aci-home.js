document.addEventListener("DOMContentLoaded", () => {
  const mobileToggle = document.getElementById("mobile-toggle");
  const navLinks = document.getElementById("nav-links");
  const searchInput = document.getElementById("search-input");
  const clearBtn = document.getElementById("clear-btn");
  const tutorialVideo = document.getElementById("tutorial-video");

  if (mobileToggle && navLinks) {
    mobileToggle.addEventListener("click", () => {
      navLinks.classList.toggle("active");

      const icon = mobileToggle.querySelector("i");
      if (!icon) return;

      if (navLinks.classList.contains("active")) {
        icon.classList.remove("fa-bars");
        icon.classList.add("fa-xmark");
      } else {
        icon.classList.remove("fa-xmark");
        icon.classList.add("fa-bars");
      }
    });
  }

  if (searchInput && clearBtn) {
    const syncClearButton = () => {
      clearBtn.style.display = searchInput.value.trim().length > 0 ? "block" : "none";
    };

    syncClearButton();
    searchInput.addEventListener("input", syncClearButton);

    clearBtn.addEventListener("click", () => {
      searchInput.value = "";
      clearBtn.style.display = "none";
      searchInput.focus();
    });
  }

  window.addEventListener("scroll", () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrollPercent = scrollHeight > 0 ? scrollTop / scrollHeight : 0;
    document.documentElement.style.setProperty("--scroll-percent", scrollPercent.toFixed(3));
  });

  const revealObserver = new IntersectionObserver((entries, observerInstance) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observerInstance.unobserve(entry.target);
      }
    });
  }, {
    root: null,
    rootMargin: "0px",
    threshold: 0.15
  });

  document.querySelectorAll(".scroll-reveal").forEach((el) => revealObserver.observe(el));

  if (tutorialVideo) {
    const videoObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          tutorialVideo.play().catch(() => {});
        } else {
          tutorialVideo.pause();
        }
      });
    }, {
      root: null,
      rootMargin: "0px",
      threshold: 0.5
    });

    videoObserver.observe(tutorialVideo);
  }
});
