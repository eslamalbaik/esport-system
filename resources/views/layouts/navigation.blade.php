 <header class="navbar">
      <div class="logo">
        <img src="./img/logo.png" class="logo-img fluid" alt="Four04 Logo" />
      </div>

          <!-- Hamburger Menu Toggle (hidden checkbox) -->
    <input type="checkbox" id="navbar-toggle" class="navbar-toggle">
    <label for="navbar-toggle" class="navbar-toggler" aria-label="Toggle navigation">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
    </label>
    
      <nav class="nav-links">
        <a href="./index.html" class="btn-primary">Home</a>
        <a href="./about.html">About Us</a>
        <a href="./our-services.html">Our Services</a>
        <a href="./tournaments.html">E-Sports</a>
        <a href="./tours-reg.html">Events Management</a>
         <a href="./team.html">Our Team</a>
        <a href="./login.html">Login</a>
        <a href="./sign-up.html">Sign Up for free</a>
        <a href="#">EN+</a>
      </nav>

    </header>

<!-- Floating Social Rail (upper-right under navbar) -->
<nav class="social-rail" aria-label="Social links">
  <!-- the red skin with perfect notches -->
  <svg class="rail-skin" viewBox="0 0 56 100" preserveAspectRatio="none" aria-hidden="true">
    <defs>
      <!-- Mask coordinates are 0..1 so it scales with height -->
      <mask id="railCut" maskUnits="objectBoundingBox">
        <rect x="0" y="0" width="1" height="1" fill="#fff"/>
        <!-- top notch -->
        <circle cx="0" cy="0.22" r="0.22" fill="#000"/>
        <!-- bottom notch -->
        <circle cx="0" cy="0.78" r="0.22" fill="#000"/>
      </mask>
    </defs>
    <!-- red rounded bar with the mask applied -->
    <rect x="0" y="0" width="56" height="100%" rx="28" ry="28" fill="#f23b33" mask="url(#railCut)"/>
  </svg>

  <!-- content sits above the SVG skin -->
  <div class="rail-content">
    <a class="ico" href="#" aria-label="Facebook">
      <svg viewBox="0 0 24 24"><path d="M15 3h-2.2C10.6 3 9 4.7 9 6.9V9H7v3h2v9h3v-9h2.6l.4-3H12V7c0-.6.5-1 1.1-1H15V3z"/></svg>
    </a>
    <a class="ico" href="#" aria-label="LinkedIn">
      <svg viewBox="0 0 24 24"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1 4.98 2.12 4.98 3.5zM.5 8.5h4V22h-4zM8 8.5h3.8v1.8h.1c.53-1 1.84-2.1 3.78-2.1 4.04 0 4.79 2.66 4.79 6.1V22h-4v-5.7c0-1.36-.02-3.11-1.9-3.11-1.9 0-2.19 1.49-2.19 3.02V22H8z"/></svg>
    </a>
    <a class="ico" href="#" aria-label="YouTube">
      <svg viewBox="0 0 24 24"><path d="M23.5 7.2a3.1 3.1 0 0 0-2.2-2.2C19.4 4.5 12 4.5 12 4.5s-7.4 0-9.3.5a3.1 3.1 0 0 0-2.2 2.2C0 9.1 0 12 0 12s0 2.9.5 4.8c.3 1 1.2 1.9 2.2 2.2C4.6 19.5 12 19.5 12 19.5s7.4 0 9.3-.5c1-.3 1.9-1.2 2.2-2.2.5-1.9.5-4.8.5-4.8s0-2.9-.5-4.8zM9.6 15.5v-7l6 3.5-6 3.5z"/></svg>
    </a>
    <a class="ico" href="#" aria-label="WhatsApp">
      <svg viewBox="0 0 24 24"><path d="M20 3.9A10 10 0 0 0 3.4 17.8L2 22l4.4-1.4A10 10 0 1 0 20 3.9zM12 20a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm4.2-5.8c-.2-.1-1.2-.6-1.3-.7-.2-.1-.3-.1-.5.1s-.6.7-.8.8-.3.1-.5 0-1-.4-1.9-1.2a7.2 7.2 0 0 1-1.3-1.6c-.1-.3 0-.4.1-.6l.4-.5c.1-.2.1-.3 0-.5l-.7-1.7c-.2-.4-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.2.3-.9.9-.9 2.1s1 2.4 1.1 2.6c.1.2 2 3 4.8 4.1.7.3 1.2.4 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.2-.6 1.4-1.1.2-.5.2-1 .1-1.1-.2-.2-.3-.2-.5-.3z"/></svg>
    </a>
    <a class="ico" href="#" aria-label="Contact">
      <svg viewBox="0 0 24 24"><path d="M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18zm0-5c2.2 0 4-1.3 4-3h-8c0 1.7 1.8 3 4 3zm-3.5-7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm7 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/></svg>
    </a>
  </div>
</nav>
