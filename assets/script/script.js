// Back to top
const backToTop = document.getElementById('backToTop');
const headerNav = document.querySelector('.header-nav');

if (backToTop && headerNav) {
    window.addEventListener('scroll', () => {
        const headerBottom = headerNav.getBoundingClientRect().bottom;
        if (headerBottom < 0) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });

    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Slideshow
document.addEventListener("DOMContentLoaded", () => {
  const galleries = document.querySelectorAll(".services-gallery");
  const displayTime = 3000; // 3 sekunde

  galleries.forEach(gallery => {
    const images = gallery.querySelectorAll("img");
    if (images.length === 0) return;

    let current = 0;
    images[current].classList.add("active");

    if (images.length > 1) {
      setInterval(() => {
        images[current].classList.remove("active");
        current = (current + 1) % images.length;
        images[current].classList.add("active");
      }, displayTime);
    }
  });
});

// Fade in on scroll
const faders = document.querySelectorAll('.fade-in');

const appearOptions = {
    threshold: 0.2,
};

const appearOnScroll = new IntersectionObserver(function(entries, observer) {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
    });
}, appearOptions);

faders.forEach(fader => {
    appearOnScroll.observe(fader);
});

// Hamburger meni
const hamburger = document.getElementById('hamburger');
const nav = document.getElementById('mobileNav');

if (hamburger && nav) {
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        nav.classList.toggle('open');
    });

    // Zatvori meni kad se klikne na link
    nav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            nav.classList.remove('open');
        });
    });
}