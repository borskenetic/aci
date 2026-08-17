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

  // Brand / #top / #about: scroll reliably even when already on the homepage
  const scrollToHashTarget = (hash) => {
    if (!hash || hash === "#") return false;
    const target = document.querySelector(hash);
    if (!target) return false;
    target.scrollIntoView({ behavior: "smooth", block: "start" });
    return true;
  };

  const goHomeTop = (e) => {
    const url = new URL(e.currentTarget.href, window.location.origin);
    if (url.pathname !== window.location.pathname) return;
    e.preventDefault();
    history.pushState(null, "", url.pathname);
    window.scrollTo({ top: 0, behavior: "smooth" });
    if (navLinks) navLinks.classList.remove("active");
  };

  document.querySelectorAll('a[href*="#"]').forEach((link) => {
    link.addEventListener("click", (e) => {
      const url = new URL(link.href, window.location.origin);
      const isSamePage = url.pathname === window.location.pathname;
      if (!isSamePage || !url.hash) return;

      e.preventDefault();
      history.pushState(null, "", url.pathname + url.hash);
      scrollToHashTarget(url.hash);
      if (navLinks) navLinks.classList.remove("active");
    });
  });

  const brandHome = document.getElementById("brand-home");
  const homeNav = document.querySelector('.nav-link[href="' + (brandHome ? brandHome.getAttribute("href") : "/") + '"]');
  if (brandHome) brandHome.addEventListener("click", goHomeTop);
  document.querySelectorAll(".nav-links .nav-link").forEach((link) => {
    try {
      const url = new URL(link.href, window.location.origin);
      if (url.pathname === new URL(brandHome ? brandHome.href : "/", window.location.origin).pathname && !url.hash) {
        link.addEventListener("click", goHomeTop);
      }
    } catch (_) {}
  });

  if (window.location.hash) {
    setTimeout(() => scrollToHashTarget(window.location.hash), 50);
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
