
// About page
(() => {
  const els = Array.from(document.querySelectorAll('[data-reveal]'));
  if (!els.length || !('IntersectionObserver' in window)) {
    els.forEach(el => el.classList.add('is-visible'));
    return;
  }

  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        const el = e.target;
        el.classList.add('is-visible');
        // if it's a stagger container, nudge children
        if ((el.getAttribute('data-reveal')||'').includes('stagger')) {
          requestAnimationFrame(()=> el.classList.add('is-visible'));
        }
        io.unobserve(el);
      }
    });
  }, { root: null, rootMargin: '0px 0px -10% 0px', threshold: 0.16 });

  els.forEach(el => {
    // base hidden state (if not already styled globally)
    el.style.opacity ??= 0;
    io.observe(el);
  });
})();

// Simple horizontal carousel controls
(() => {
  const carousels = Array.from(document.querySelectorAll('[data-carousel]'));
  if (!carousels.length) {
    return;
  }

  const getButton = (name, id) =>
    document.querySelector(`[data-carousel-${name}="${id}"]`);

  const updateButtons = (viewport, prevBtn, nextBtn) => {
    if (!viewport) {
      return;
    }

    const maxScroll = viewport.scrollWidth - viewport.clientWidth;
    if (maxScroll <= 0) {
      if (prevBtn) prevBtn.disabled = true;
      if (nextBtn) nextBtn.disabled = true;
      return;
    }

    const current = viewport.scrollLeft;
    if (prevBtn) {
      prevBtn.disabled = current <= 2;
    }
    if (nextBtn) {
      nextBtn.disabled = current >= (maxScroll - 2);
    }
  };

  const scrollByStep = (viewport, direction) => {
    if (!viewport) return;
    const step = Math.max(viewport.clientWidth * 0.8, 220);
    viewport.scrollBy({
      left: direction === 'next' ? step : -step,
      behavior: 'smooth',
    });
  };

  carousels.forEach((carousel) => {
    const id = carousel.getAttribute('data-carousel');
    if (!id) {
      return;
    }

    const viewport = carousel.querySelector('[data-carousel-viewport]');
    if (!viewport) {
      return;
    }

    const prevBtn = getButton('prev', id);
    const nextBtn = getButton('next', id);

    prevBtn?.addEventListener('click', (event) => {
      event.preventDefault();
      scrollByStep(viewport, 'prev');
    });

    nextBtn?.addEventListener('click', (event) => {
      event.preventDefault();
      scrollByStep(viewport, 'next');
    });

    const debouncedUpdate = () => updateButtons(viewport, prevBtn, nextBtn);
    viewport.addEventListener('scroll', debouncedUpdate, { passive: true });
    window.addEventListener('resize', debouncedUpdate);
    debouncedUpdate();
  });
})();
