// Image Slider for hero section
(function(){
  const slider = document.getElementById('imageSlider');
  if(!slider) return;
  
  const slides = slider.querySelector('#sliderImages');
  const slideElems = Array.from(slides.children);
  const dotsContainer = document.getElementById('sliderNav');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  let index = 0;
  const total = slideElems.length;
  let interval = null;
  let isTransitioning = false;

  // Build navigation dots
  slideElems.forEach((slide, i) => {
    const dot = document.createElement('div');
    dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
    dot.addEventListener('click', () => {
      if (!isTransitioning) {
        goTo(i);
        resetAutoplay();
      }
    });
    dotsContainer.appendChild(dot);
  });

  function update() {
    isTransitioning = true;
    slides.style.transform = `translateX(-${index * 100}%)`;
    
    // Update active dot
    Array.from(dotsContainer.children).forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });
    
    // Reset transition flag after animation completes
    setTimeout(() => {
      isTransitioning = false;
    }, 800);
  }

  function goTo(i) { 
    index = (i + total) % total; 
    update(); 
  }
  
  function next() { 
    goTo(index + 1); 
  }
  
  function prev() { 
    goTo(index - 1); 
  }
  
  function resetAutoplay() { 
    clearInterval(interval); 
    interval = setInterval(next, 4000);
  }

  // Button event listeners
  nextBtn.addEventListener('click', () => {
    if (!isTransitioning) {
      next();
      resetAutoplay();
    }
  });
  
  prevBtn.addEventListener('click', () => {
    if (!isTransitioning) {
      prev();
      resetAutoplay();
    }
  });

  // Initialize slider
  update();
  resetAutoplay();

  // Pause autoplay on hover
  slider.addEventListener('mouseenter', () => {
    clearInterval(interval);
  });
  
  slider.addEventListener('mouseleave', () => {
    resetAutoplay();
  });

  // Pause autoplay when tab is not visible
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      clearInterval(interval);
    } else {
      resetAutoplay();
    }
  });
})();

// Enhanced slider for testimonials with smooth transitions
(function(){
  const slider = document.getElementById('testimonialSlider');
  if(!slider) return;
  
  const slides = slider.querySelector('.slides');
  const slideElems = Array.from(slides.children);
  const dotsContainer = document.getElementById('sliderDots');
  let index = 0;
  const total = slideElems.length;
  let interval = null;
  let isTransitioning = false;

  // Build navigation dots
  slideElems.forEach((slide, i) => {
    const dot = document.createElement('div');
    dot.className = 'dot' + (i === 0 ? ' active' : '');
    dot.addEventListener('click', () => {
      if (!isTransitioning) {
        goTo(i);
        resetAutoplay();
      }
    });
    dotsContainer.appendChild(dot);

    // Click on slide redirects to testimonials page
    slide.addEventListener('click', () => {
      const href = slide.getAttribute('data-href');
      if (href) window.location.href = href;
    });
  });

  function update() {
    isTransitioning = true;
    slides.style.transform = `translateX(-${index * 100}%)`;
    
    // Update active dot
    Array.from(dotsContainer.children).forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });
    
    // Reset transition flag after animation completes
    setTimeout(() => {
      isTransitioning = false;
    }, 800);
  }

  function goTo(i) { 
    index = (i + total) % total; 
    update(); 
  }
  
  function next() { 
    goTo(index + 1); 
  }
  
  function resetAutoplay() { 
    clearInterval(interval); 
    interval = setInterval(next, 5000); // Increased to 5 seconds for better readability
  }

  // Initialize slider
  update();
  resetAutoplay();

  // Pause autoplay on hover for better UX
  slider.addEventListener('mouseenter', () => {
    clearInterval(interval);
  });
  
  slider.addEventListener('mouseleave', () => {
    resetAutoplay();
  });

  // Pause autoplay when tab is not visible
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      clearInterval(interval);
    } else {
      resetAutoplay();
    }
  });
})();

// Enhanced mobile navigation with improved accessibility
document.addEventListener('DOMContentLoaded', function(){
  const btn = document.getElementById('hamburger');
  const nav = document.getElementById('primaryNav');
  
  if (!btn || !nav) return;
  
  btn.addEventListener('click', function(){
    const isOpen = nav.classList.toggle('show');
    btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    
    // Update hamburger icon
    btn.innerHTML = isOpen ? '✕' : '☰';
    
    // Manage backdrop
    let backdrop = document.getElementById('menuBackdrop');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.id = 'menuBackdrop';
      document.body.appendChild(backdrop);
    }
    
    if (isOpen) {
      backdrop.classList.add('show');
      nav.style.zIndex = '101';
      
      // Focus first link for accessibility
      const firstLink = nav.querySelector('a');
      if (firstLink) {
        setTimeout(() => firstLink.focus(), 100);
      }
      
      // Close menu handlers
      backdrop.addEventListener('click', closeMenu);
      document.addEventListener('keydown', handleEscapeKey);
      
      // Prevent body scroll when menu is open
      document.body.style.overflow = 'hidden';
    } else {
      closeMenu();
    }
  });
  
  function closeMenu() {
    nav.classList.remove('show');
    btn.setAttribute('aria-expanded', 'false');
    btn.innerHTML = '☰';
    
    const backdrop = document.getElementById('menuBackdrop');
    if (backdrop) {
      backdrop.classList.remove('show');
      backdrop.removeEventListener('click', closeMenu);
    }
    
    document.removeEventListener('keydown', handleEscapeKey);
    document.body.style.overflow = '';
    nav.style.zIndex = '';
    btn.focus();
  }
  
  function handleEscapeKey(e) {
    if (e.key === 'Escape') {
      closeMenu();
    }
  }
  
  // Close menu when clicking on navigation links
  nav.addEventListener('click', function(e) {
    if (e.target.tagName === 'A') {
      // Small delay to allow navigation to complete
      setTimeout(closeMenu, 100);
    }
  });
  
  // Handle window resize - close menu if screen becomes large
  window.addEventListener('resize', function() {
    if (window.innerWidth > 900 && nav.classList.contains('show')) {
      closeMenu();
    }
  });
});

// Reveal-on-scroll for About page and other sections
(function(){
  if (!('IntersectionObserver' in window)) return;
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
      }
    });
  }, { root: null, rootMargin: '0px 0px -10% 0px', threshold: 0.12 });

  document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.reveal');
    items.forEach(el => observer.observe(el));
  });
})();
