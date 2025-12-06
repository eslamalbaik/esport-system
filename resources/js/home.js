// RTL detection helper
function isRTL() {
  return document.documentElement.dir === 'rtl' || getComputedStyle(document.documentElement).direction === 'rtl';
}

// Slider micro-lib used across pages
function makeSlider(root){
  const track = root.querySelector('.slider-track');
  const prev  = root.querySelector('.slider-btn.prev');
  const next  = root.querySelector('.slider-btn.next');
  const step = () => {
    if (!track.children.length) return;
    const first = track.children[0];
    track.appendChild(first.cloneNode(true));
    track.removeChild(first);
  };
  let auto = setInterval(step, 1500);
  const scrollByCards = (dir=1) => {
    const card = track.children[0];
    const w = card.getBoundingClientRect().width + 16;
    track.scrollBy({left: dir * w, behavior: 'smooth'});
  };
  prev && prev.addEventListener('click', () => { scrollByCards(-1); reset(); });
  next && next.addEventListener('click', () => { scrollByCards(1);  reset(); });
  const reset = () => { clearInterval(auto); auto = setInterval(step, 1500); };
  root.addEventListener('mouseenter', () => clearInterval(auto));
  root.addEventListener('mouseleave', () => reset());
}
document.querySelectorAll('[data-slider]').forEach(makeSlider);


// Partners Slider - Removed conflicting autoplay function
// Using only the unified controller below


// Partners Slider - Fixed Implementation
(function () {
  const slider = document.getElementById('partners-slider');
  const track  = slider?.querySelector('.track');
  const prev   = document.getElementById('p-prev');
  const next   = document.getElementById('p-next');
  const dotsEl = document.getElementById('p-dots');
  
  if (!slider || !track || !prev || !next || !dotsEl) {
    console.warn('Partners slider: Missing required elements', {
      slider: !!slider,
      track: !!track, 
      prev: !!prev,
      next: !!next,
      dotsEl: !!dotsEl
    });
    return;
  }

  const cards = () => Array.from(track.querySelectorAll('.card-partner'));
  const toNumber = (value) => {
    const parsed = parseFloat(value ?? '');
    return Number.isFinite(parsed) ? parsed : 0;
  };

  function cardStride(list = cards()) {
    if (list.length <= 1) {
      const single = list[0];
      return single ? single.getBoundingClientRect().width : slider.clientWidth;
    }
    const delta = Math.abs(list[1].offsetLeft - list[0].offsetLeft);
    if (delta > 0) return delta;
    const width = list[0].getBoundingClientRect().width;
    return width || slider.clientWidth;
  }
  
  // Configuration
  let currentIndex = 0;
  let autoplayTimer = null;
  const AUTOPLAY_DELAY = 1500;

  function getVisibleCards() {
    const list = cards();
    if (!list.length) return 1;

    const stride = cardStride(list);
    if (!stride) return 1;

    const styles = window.getComputedStyle(slider);
    const paddingStart = toNumber(styles.paddingInlineStart || styles.paddingLeft);
    const paddingEnd = toNumber(styles.paddingInlineEnd || styles.paddingRight);
    const available = slider.clientWidth - paddingStart - paddingEnd;
    const usable = available > 0 ? available : slider.clientWidth;
    const approx = usable / stride;

    return Math.max(1, Math.round(approx));
  }

  function getMaxIndex() {
    const totalCards = cards().length;
    const visibleCards = getVisibleCards();
    return Math.max(0, totalCards - visibleCards);
  }

  function setIndex(index, stopAutoplay = false) {
    const list = cards();
    if (!list.length) return;

    const maxIdx = getMaxIndex();
    currentIndex = Math.max(0, Math.min(index, maxIdx));
    
    const stride = cardStride(list);
    const offset = stride * currentIndex;
    const rtlMode = isRTL();
    
    // Calculate translation in pixels to account for card gap + width
    const direction = rtlMode ? 1 : -1;
    const x = direction * offset;
    
    track.style.transform = `translateX(${x}px)`;
    updateDots();
    updateArrowsState();
    
    if (stopAutoplay) {
      restartAutoplay();
    }
  }

  function nextSlide(stopAutoplay = false) {
    const maxIdx = getMaxIndex();
    const nextIdx = currentIndex >= maxIdx ? 0 : currentIndex + 1; // wrap around
    setIndex(nextIdx, stopAutoplay);
  }

  function prevSlide(stopAutoplay = false) {
    const maxIdx = getMaxIndex();
    const prevIdx = currentIndex <= 0 ? maxIdx : currentIndex - 1; // wrap around
    setIndex(prevIdx, stopAutoplay);
  }

  // Dots management
  function buildDots() {
    const maxIdx = getMaxIndex();
    const numDots = Math.min(5, maxIdx + 1); // Max 5 dots, minimum 1
    dotsEl.innerHTML = '';
    
    for (let i = 0; i < numDots; i++) {
      const dot = document.createElement('span');
      dot.className = 'dot' + (i === 0 ? ' active' : '');
      dot.setAttribute('data-slide', i.toString());
      dot.addEventListener('click', () => setIndex(i, true));
      dotsEl.appendChild(dot);
    }
  }

  function updateDots() {
    const dots = dotsEl.querySelectorAll('.dot');
    dots.forEach((dot, index) => {
      dot.classList.toggle('active', index === currentIndex);
    });
  }

  function updateArrowsState() {
    // Enable wrap-around, so never disable buttons
    prev.disabled = false;
    next.disabled = false;
    
    // Optional: Add visual feedback for disabled state
    prev.style.opacity = '1';
    next.style.opacity = '1';
  }

  // Event listeners
  next.addEventListener('click', (e) => {
    e.preventDefault();
    nextSlide(true);
  });
  
  prev.addEventListener('click', (e) => {
    e.preventDefault();
    prevSlide(true);
  });

  // Autoplay functions
  function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(() => nextSlide(), AUTOPLAY_DELAY);
  }

  function stopAutoplay() {
    if (autoplayTimer) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  }

  function restartAutoplay() {
    stopAutoplay();
    setTimeout(() => startAutoplay(), 1500); // Restart after 1.5s
  }

  // Pause autoplay on hover
  slider.addEventListener('mouseenter', stopAutoplay);
  slider.addEventListener('mouseleave', startAutoplay);

  // Handle window resize
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      buildDots(); // Rebuild dots for new screen size
      setIndex(Math.min(currentIndex, getMaxIndex())); // Adjust current index if needed
    }, 250);
  });

  // Touch/swipe support for mobile
  let startX = 0;
  let isDragging = false;
  
  slider.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    isDragging = true;
    stopAutoplay();
  }, { passive: true });
  
  slider.addEventListener('touchend', (e) => {
    if (!isDragging) return;
    isDragging = false;
    
    const endX = e.changedTouches[0].clientX;
    const diffX = startX - endX;
    const threshold = 50; // Minimum swipe distance
    
    if (Math.abs(diffX) > threshold) {
      if (diffX > 0) {
        nextSlide(true); // Swipe left - next slide
      } else {
        prevSlide(true); // Swipe right - previous slide  
      }
    } else {
      restartAutoplay();
    }
  }, { passive: true });

  // Initialize slider
  function init() {
    const totalCards = cards().length;
    console.log(`Partners slider initialized with ${totalCards} cards`);
    
    if (totalCards === 0) {
      console.warn('No partner cards found');
      return;
    }
    
    buildDots();
    setIndex(0);
    updateArrowsState();
    startAutoplay();
  }

  // Wait for DOM to be ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();


// Tournaments carousel
(() => {
  const carousel = document.querySelector('[data-tournament-carousel]');
  if (!carousel) return;

  const track = carousel.querySelector('[data-carousel-track]');
  const viewport = carousel.querySelector('[data-carousel-viewport]');
  const btnPrev = carousel.querySelector('[data-carousel-prev]');
  const btnNext = carousel.querySelector('[data-carousel-next]');
  const dotsHost = carousel.querySelector('[data-carousel-dots]');
  const liveRegion = carousel.querySelector('[data-carousel-live]');

  if (!track || !viewport || !btnPrev || !btnNext || !dotsHost) {
    console.warn('Tournament carousel: missing pieces', {
      track: !!track,
      viewport: !!viewport,
      btnPrev: !!btnPrev,
      btnNext: !!btnNext,
      dotsHost: !!dotsHost,
    });
    return;
  }

  const slides = () => Array.from(track.querySelectorAll('[data-carousel-slide]'));
  const AUTO_MS = 1500;
  const statusTemplate = carousel.dataset.carouselStatusTemplate || 'Showing :start-:end of :total';
  const dotLabelTemplate = carousel.dataset.carouselDotLabel || 'Show tournament group :number';
  const prefersReducedMotion = window.matchMedia
    ? window.matchMedia('(prefers-reduced-motion: reduce)')
    : null;

  let index = 0;
  let timer = null;
  let resizeId = null;

  const gapValue = () => {
    const styles = window.getComputedStyle(track);
    const gapRaw = styles.columnGap || styles.gap || '0';
    const parsed = parseFloat(gapRaw);
    return Number.isFinite(parsed) ? parsed : 0;
  };

  const stride = () => {
    const first = slides()[0];
    if (!first) return 0;
    return first.getBoundingClientRect().width + gapValue();
  };

  const visibleCount = () => {
    const width = viewport.clientWidth;
    const step = stride();
    if (!step) return 1;
    return Math.max(1, Math.round(width / step));
  };

  const maxIndex = () => Math.max(0, slides().length - visibleCount());

  const formatStatus = (start, end, total) =>
    statusTemplate
      .replace(':start', start)
      .replace(':end', end)
      .replace(':total', total);

  const announce = () => {
    if (!liveRegion) return;
    const total = slides().length;
    if (!total) {
      liveRegion.textContent = '';
      return;
    }

    const visible = visibleCount();
    const start = Math.min(total, index + 1);
    const end = Math.min(total, index + visible);
    liveRegion.textContent = formatStatus(start, end, total);
  };

  const updateSlides = () => {
    const items = slides();
    const visible = visibleCount();
    const start = index;
    const end = Math.min(items.length - 1, start + visible - 1);

    items.forEach((item, idx) => {
      const active = idx >= start && idx <= end;
      item.classList.toggle('is-active', active);
      item.setAttribute('aria-hidden', active ? 'false' : 'true');
    });
  };

  const buildDots = () => {
    const max = maxIndex();
    const count = Math.max(1, max + 1);
    dotsHost.innerHTML = '';

    for (let i = 0; i < count; i++) {
      const dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 'tournament-carousel__dot' + (i === index ? ' is-active' : '');
      dot.setAttribute('aria-label', dotLabelTemplate.replace(':number', String(i + 1)));
      dot.addEventListener('click', () => goTo(i, true));
      dotsHost.appendChild(dot);
    }
  };

  const updateDots = () => {
    Array.from(dotsHost.children).forEach((dot, idx) => {
      dot.classList.toggle('is-active', idx === index);
    });
  };

  const applyTransform = () => {
    const offset = stride() * index;
    const rtl = isRTL();
    const translate = rtl ? offset : -offset;
    track.style.transform = offset ? `translateX(${translate}px)` : '';
  };

  const goTo = (nextIndex, stopAuto = false) => {
    const max = maxIndex();
    if (max === 0) {
      index = 0;
      track.style.transform = '';
      buildDots();
      updateSlides();
      announce();
      stopAutoplay();
      return;
    }

    const total = max + 1;
    index = ((nextIndex % total) + total) % total;

    applyTransform();
    updateDots();
    updateSlides();
    announce();

    if (stopAuto) restartAutoplay();
  };

  const next = (stopAuto = false) => goTo(index + 1, stopAuto);
  const prev = (stopAuto = false) => goTo(index - 1, stopAuto);

  const stopAutoplay = () => {
    if (timer) {
      clearInterval(timer);
      timer = null;
    }
  };

  const shouldAutoplay = () => {
    if (prefersReducedMotion?.matches) return false;
    return maxIndex() > 0;
  };

  const startAutoplay = () => {
    stopAutoplay();
    if (!shouldAutoplay()) return;
    timer = setInterval(next, AUTO_MS);
  };

  const restartAutoplay = () => {
    stopAutoplay();
    startAutoplay();
  };

  btnNext.addEventListener('click', () => next(true));
  btnPrev.addEventListener('click', () => prev(true));

  carousel.addEventListener('mouseenter', stopAutoplay);
  carousel.addEventListener('mouseleave', startAutoplay);

  viewport.addEventListener('focusin', stopAutoplay);
  viewport.addEventListener('focusout', startAutoplay);

  // Touch gestures
  let startX = 0;
  let dragging = false;
  viewport.addEventListener('touchstart', (e) => {
    dragging = true;
    startX = e.touches[0].clientX;
    stopAutoplay();
  }, { passive: true });

  viewport.addEventListener('touchend', (e) => {
    if (!dragging) return;
    dragging = false;

    const dx = startX - e.changedTouches[0].clientX;
    const threshold = 50;
    if (Math.abs(dx) > threshold) {
      dx > 0 ? next(true) : prev(true);
    } else {
      restartAutoplay();
    }
  }, { passive: true });

  window.addEventListener('resize', () => {
    clearTimeout(resizeId);
    resizeId = setTimeout(() => {
      const previousMax = maxIndex();
      buildDots();
      const boundedIndex = Math.min(index, maxIndex());
      goTo(boundedIndex);
      if (previousMax !== maxIndex()) {
        restartAutoplay();
      }
    }, 200);
  });

  const init = () => {
    if (!slides().length) return;
    buildDots();
    goTo(0);
    startAutoplay();
    announce();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  if (prefersReducedMotion) {
    const handleMotionChange = () => restartAutoplay();
    if (typeof prefersReducedMotion.addEventListener === 'function') {
      prefersReducedMotion.addEventListener('change', handleMotionChange);
    } else if (typeof prefersReducedMotion.addListener === 'function') {
      prefersReducedMotion.addListener(handleMotionChange);
    }
  }
})();


// Testimonials
(() => {
  // Unique, conflict-free names
  const ts_root   = document.getElementById('ts-slider');
  if (!ts_root) return;
  
  const ts_track  = ts_root.querySelector('.ts-track');
  if (!ts_track) return;
  
  const ts_cards  = Array.from(ts_track.querySelectorAll('.ts-card'));
  const ts_dotsEl = document.getElementById('ts-dots');
  const ts_prev   = document.getElementById('ts-prev');
  const ts_next   = document.getElementById('ts-next');
  
  if (!ts_dotsEl || !ts_prev || !ts_next || ts_cards.length === 0) return;

  // Show 2 at a time, slide 1 by 1
  const TS_VISIBLE = 2;
  const ts_maxIndex = Math.max(0, ts_cards.length - TS_VISIBLE);
  const ts_dotsCount = Math.max(1, ts_maxIndex + 1);
  let ts_index = 0;
  let ts_timer = null;
  const TS_AUTOPLAY_MS = 1500;

  // Build dots
  ts_dotsEl.innerHTML = '';
  for (let i = 0; i < ts_dotsCount; i++) {
    const d = document.createElement('span');
    d.className = 'dot' + (i === 0 ? ' active' : '');
    d.addEventListener('click', () => ts_setIndex(i, true));
    ts_dotsEl.appendChild(d);
  }

  function ts_cardWidth() {
    const el = ts_cards[0];
    return el ? el.getBoundingClientRect().width : 0;
  }

  function ts_setIndex(n, stopAuto = false) {
    ts_index = (n + ts_maxIndex + 1) % (ts_maxIndex + 1);   // wrap 0..maxIndex
    const cardWidth = ts_cardWidth();
    const rtlMode = isRTL();
    
    // RTL support: reverse the translation direction
    const x = rtlMode ? (ts_index * cardWidth) : -(ts_index * cardWidth);
    ts_track.style.transform = `translateX(${x}px)`;

    // update dots
    Array.from(ts_dotsEl.children).forEach((d, i) =>
      d.classList.toggle('active', i === ts_index)
    );

    if (stopAuto) ts_restartAutoplay();
  }

  function ts_nextStep(stop=false){ ts_setIndex(ts_index + 1, stop); }
  function ts_prevStep(stop=false){ ts_setIndex(ts_index - 1, stop); }

  ts_next.addEventListener('click', () => ts_nextStep(true));
  ts_prev.addEventListener('click', () => ts_prevStep(true));

  // autoplay with pause on hover
  function ts_startAutoplay(){ ts_stopAutoplay(); ts_timer = setInterval(ts_nextStep, TS_AUTOPLAY_MS); }
  function ts_stopAutoplay(){ if (ts_timer) clearInterval(ts_timer); ts_timer = null; }
  function ts_restartAutoplay(){ ts_stopAutoplay(); ts_startAutoplay(); }

  // ts_root.addEventListener('mouseenter', ts_stopAutoplay);
  ts_root.addEventListener('mouseleave', ts_startAutoplay);
  window.addEventListener('resize', () => ts_setIndex(ts_index)); // keep alignment on resize

  // init
  ts_setIndex(0);
  ts_startAutoplay();
})();

(() => {
  const SEL = '[data-reveal]';
  const els = Array.from(document.querySelectorAll(SEL));

  // If nothing to reveal, bail
  if (!els.length) return;

  // Utility: apply visible state with optional per-element delay
  const reveal = (el) => {
    const delay = parseInt(el.getAttribute('data-reveal-delay') || '0', 10);
    if (delay) el.style.transitionDelay = `${delay}ms`;
    el.classList.add('is-visible');

    // If 'stagger' is on a container, reveal its children in a cascade
    if (el.getAttribute('data-reveal')?.includes('stagger')) {
      requestAnimationFrame(() => el.classList.add('is-visible'));
    }
  };

  // Observer options: adjust rootMargin to trigger a bit before the item hits center
  const io = ('IntersectionObserver' in window)
    ? new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          const el = entry.target;
          const onceAttr = el.getAttribute('data-reveal-once');
          const once = onceAttr === null || onceAttr === 'true'; // default true

          if (entry.isIntersecting) {
            reveal(el);
            if (once) io.unobserve(el);
          } else if (!once) {
            // allow re-trigger when scrolled away and back
            el.classList.remove('is-visible');
            el.style.transitionDelay = '';
          }
        });
      }, { root: null, rootMargin: '0px 0px -10% 0px', threshold: 0.18 })
    : null;

  // Observe or fallback
  els.forEach(el => {
    if (io) io.observe(el);
    else reveal(el); // no IO support → show immediately
  });

  // Keep layout tidy on route/page resizes
  window.addEventListener('resize', () => {
    // no-op for now; transitions remain correct
  }, { passive: true });
})();



// make tstimonials cards same size
(function () {
  // Select all testimonials’ inner boxes
  const SELECTOR = '.ts-inner';

  function syncHeights() {
    const els = Array.from(document.querySelectorAll(SELECTOR));
    if (!els.length) return;

    // Reset before measuring
    els.forEach(el => el.style.minHeight = '');

    // Measure tallest (padding included, margin excluded)
    const tallest = Math.max(...els.map(el => el.getBoundingClientRect().height));

    // Apply uniform min-height
    els.forEach(el => { el.style.minHeight = tallest + 'px'; });
  }

  // Re-run on resize (debounced) and after load (images/fonts)
  let t;
  window.addEventListener('resize', () => {
    clearTimeout(t);
    t = setTimeout(syncHeights, 120);
  });

  if (document.readyState === 'complete') syncHeights();
  else window.addEventListener('load', syncHeights);

  // Keep heights in sync if any card’s content changes (images, async text, etc.)
  const ro = new ResizeObserver(syncHeights);
  const mo = new MutationObserver(syncHeights);

  function observeAll() {
    const els = document.querySelectorAll(SELECTOR);
    els.forEach(el => ro.observe(el));
  }
  observeAll();
  mo.observe(document.documentElement, { childList: true, subtree: true });
})();

// swap hero-tag word
(function () {
  const words = ['Esports', 'Events', 'Tournaments'];
  const el = document.getElementById('swapword');
  if (!el) return;

  let i = 0;
  const DURATION = 2200;   // time each word stays (ms)
  const XFADE = 350;       // match CSS transition (.35s)

  function next() {
    // fade out current
    el.classList.add('is-out');

    // after fade-out, swap text, fade back in
    setTimeout(() => {
      i = (i + 1) % words.length;
      el.textContent = words[i];
      el.classList.remove('is-out');
      el.classList.add('is-in');
      // clean the 'is-in' class after the transition
      setTimeout(() => el.classList.remove('is-in'), XFADE + 20);
    }, Math.min(200, XFADE)); // small overlap for a snappy feel
  }

  // start the loop
  setInterval(next, DURATION);
})();


// progressbar increase with scroll
(function () {
  const section = document.querySelector('section.hero#home');
  const fill    = document.querySelector('.progress-fill');
  const label   = document.querySelector('.progress-label'); // optional
  if (!section || !fill) return;

  // CONFIG:
  const MAX = 1.0;   // 1.0 = 100%. Set to 0.65 if you want to cap at 65%
  const USE_PERCENT_LABEL = false; // set true to show "42%" instead of "Esports"

  // Respect reduced motion: just snap to MAX once visible
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Compute progress of scrolling through the section (0..1)
  function progressOf(el) {
    const r  = el.getBoundingClientRect();
    const vh = window.innerHeight || document.documentElement.clientHeight;

    // Start counting when the top hits the bottom of the viewport,
    // finish when the bottom leaves the top of the viewport.
    const total = vh + r.height;
    const passed = Math.min(total, Math.max(0, vh - r.top));
    return total ? (passed / total) : 0;
  }

  let ticking = false;
  function update() {
    ticking = false;

    if (prefersReduced) {
      fill.style.width = (MAX * 100).toFixed(2) + '%';
      if (label && USE_PERCENT_LABEL) label.textContent = Math.round(MAX * 100) + '%';
      return;
    }

    const p   = Math.max(0, Math.min(1, progressOf(section)));
    const val = p * MAX;
    fill.style.width = (val * 100).toFixed(2) + '%';

    if (label && USE_PERCENT_LABEL) {
      label.textContent = Math.round(val * 100) + '%';
    }
  }

  function onScroll() {
    if (!ticking) {
      requestAnimationFrame(update);
      ticking = true;
    }
  }

  // Update when section is in/near the viewport (saves work)
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          window.addEventListener('scroll', onScroll, { passive: true });
          window.addEventListener('resize', onScroll);
          update();
        } else {
          window.removeEventListener('scroll', onScroll);
          window.removeEventListener('resize', onScroll);
        }
      });
    }, { root: null, threshold: [0, 0.01, 1] });
    io.observe(section);
  } else {
    // Fallback
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
    update();
  }

  // Initial paint
  update();
})();


(function countdownTimer() {
  const countdownEl = document.querySelector('[data-countdown-target]');
  if (!countdownEl) return;

  const targetIso = countdownEl.getAttribute('data-countdown-target');
  if (!targetIso) return;

  const targetDate = new Date(targetIso);
  if (Number.isNaN(targetDate.getTime())) {
    console.warn('Invalid countdown target datetime', targetIso);
    return;
  }

  const partElements = {
    months: countdownEl.querySelector('[data-countdown-part="months"]'),
    days: countdownEl.querySelector('[data-countdown-part="days"]'),
    minutes: countdownEl.querySelector('[data-countdown-part="minutes"]'),
  };

  const pad = (value) => String(Math.max(0, value ?? 0)).padStart(2, '0');

  const setPart = (part, value) => {
    if (!partElements[part]) return;
    partElements[part].textContent = pad(value);
  };

  const computeDiff = (from, to) => {
    if (to <= from) {
      return { months: 0, days: 0, minutes: 0 };
    }

    let months =
      (to.getFullYear() - from.getFullYear()) * 12 +
      (to.getMonth() - from.getMonth());

    const anchor = new Date(from.getTime());
    anchor.setMonth(anchor.getMonth() + months);

    if (anchor > to) {
      months -= 1;
      anchor.setMonth(anchor.getMonth() - 1);
    }

    let remaining = to.getTime() - anchor.getTime();
    const dayMs = 24 * 60 * 60 * 1000;
    const hourMs = 60 * 60 * 1000;
    const days = Math.floor(remaining / dayMs);
    remaining -= days * dayMs;

    const hours = Math.floor(remaining / hourMs);
    remaining -= hours * hourMs;

    const minutes = Math.floor(remaining / 60000);

    return {
      months: Math.max(0, months),
      days: Math.max(0, days),
      minutes: Math.max(0, minutes),
    };
  };

  let timerId;

  const tick = () => {
    const now = new Date();
    const diff = computeDiff(now, targetDate);
    setPart('months', diff.months);
    setPart('days', diff.days);
    setPart('minutes', diff.minutes);
  };

  const scheduleNextTick = () => {
    clearTimeout(timerId);
    const now = new Date();
    const msUntilNextMinute =
      60000 - (now.getSeconds() * 1000 + now.getMilliseconds());
    timerId = setTimeout(() => {
      tick();
      scheduleNextTick();
    }, Math.max(1000, msUntilNextMinute));
  };

  tick();
  scheduleNextTick();
})();
