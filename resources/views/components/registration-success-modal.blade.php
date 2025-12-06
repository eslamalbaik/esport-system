@if(session('registration_success'))
  @php($message = session('registration_success'))
  <div
    id="registrationSuccessModal"
    class="registration-success-modal"
    data-redirect="{{ $redirectUrl ?? route('home') }}"
    role="dialog"
    aria-modal="true"
    aria-labelledby="registrationSuccessTitle"
    tabindex="-1"
  >
    <div class="registration-success-modal__dialog" role="document">
      <h2 id="registrationSuccessTitle">{{ __('Registration Successful') }}</h2>
      <p>{{ $message }}</p>
      <button type="button" class="registration-success-modal__action" data-close-modal>
        {{ __('Go to homepage') }}
      </button>
    </div>
  </div>

  @push('styles')
    <style>
      .registration-success-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(7, 7, 12, 0.78);
        padding: 1.5rem;
      }

      .registration-success-modal__dialog {
        background: #0e1024;
        color: #fff;
        border-radius: 12px;
        padding: 2.5rem 2rem;
        max-width: 420px;
        width: 100%;
        text-align: center;
        box-shadow: 0 22px 45px rgba(0, 0, 0, 0.4);
      }

      .registration-success-modal__dialog h2 {
        margin-bottom: 0.75rem;
        font-size: 1.75rem;
        letter-spacing: 0.02em;
      }

      .registration-success-modal__dialog p {
        margin-bottom: 1.5rem;
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.82);
      }

      .registration-success-modal__action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.75rem;
        border-radius: 999px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.95rem;
        background: linear-gradient(135deg, #ff2849, #f24b6a);
        color: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }

      .registration-success-modal__action:hover,
      .registration-success-modal__action:focus-visible {
        transform: translateY(-1px);
        box-shadow: 0 12px 25px rgba(242, 75, 106, 0.35);
        outline: none;
      }

      body.has-registration-success-modal {
        overflow: hidden;
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      (() => {
        const modal = document.getElementById('registrationSuccessModal');
        if (!modal) {
          return;
        }

        const redirectUrl = modal.dataset.redirect || '/';
        const closeBtn = modal.querySelector('[data-close-modal]');
        const redirectDelay = 4000;

        document.body.classList.add('has-registration-success-modal');
        closeBtn?.focus({ preventScroll: true });

        const redirectToHome = () => {
          window.location.href = redirectUrl;
        };

        const handleKey = (event) => {
          if (event.key === 'Escape') {
            event.preventDefault();
            redirectToHome();
          }
        };

        window.setTimeout(redirectToHome, redirectDelay);
        closeBtn?.addEventListener('click', redirectToHome);
        modal.addEventListener('click', (event) => {
          if (event.target === modal) {
            redirectToHome();
          }
        });
        document.addEventListener('keydown', handleKey, { once: true });
      })();
    </script>
  @endpush
@endif
