@extends('layouts.app')

@section('title', __('Privacy Policy'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/privacy.css',
    ])
@endpush

@section('content')

<section class="pp" aria-labelledby="pp-title">

    <div class="right-panel">
      <div class="form-header" style=" margin: 50px;">
        <button
          class="tab-btn active"
          style="font-size: 20px; border-radius: 10px; background: linear-gradient(#970f05,#fff);"
        >
          {{ __('Privacy Policy') }}
        </button>
      </div>
    </div>

  <div class="pp__content">
    <ul class="pp-list">
      <li class="pp-item">
        <h3 class="pp-item__title">
          <span class="pp-dot" aria-hidden="true"></span>
          <span>{{ __('National Markets Orchestrator') }}</span>
        </h3>
        <p>
          {{ __('Vero quis est. Quos sint ut voluptate quo pariatur ut ut culpa. Et ullam quia quia optio maiores. Qui in ut repudiandae et et voluptatem. Ipsa ratione expedita sit provident voluptatem doloremque blanditiis temporibus ab. Corporis excepturi unde ipsam maxime qui sunt ipsam sunt eos.') }}
        </p>
        <p class="indent">
          {{ __('Perspiciatis earum porro dolorum molestiae perspiciatis. Eos culpa consequatur et soluta cum. Non recusandae ratione voluptatem et id atque nesciunt. Maxime delectus rerum. Totam velit ipsum aut ut. Ea dolorum vero aspernatur assumenda asperiores vitae voluptatem.') }}
        </p>
        <p>
          {{ __('Id dolor hic sint eum blanditiis. Et veritatis libero et doloremque et cumque architecto mollitia. Quia illum enim ipsam voluptatem vitae et sit recusandae.') }}
        </p>
      </li>

      <li class="pp-item">
        <h3 class="pp-item__title">
          <span class="pp-dot" aria-hidden="true"></span>
          <span>{{ __('National Metrics Planner') }}</span>
        </h3>
        <p>
          {{ __('Porro suscipit alias voluptatibus atque. Culpa possimus et corrupti ut rerum architecto dolorem beatae. Et et neque. Deserunt laborum vitae quia expedita earum dolorem. Quasi occaecati est et esse. Id ex sint sunt delectus vel facilis.') }}
        </p>
        <p class="indent">
          {{ __('Voluptatem et molestias facere ex eum provident velit. At esse qui. Accusantium iste eius aut non.') }}
        </p>
        <p class="indent">
          {{ __('Distinctio labore neque illo. Nostrum sapiente placeat repellat ducimus nemo eum maiores qui. Quaerat id ut iure omnis explicabo quis id debitis. Mollitia aut voluptatem et officia. Quod placeat quia minus consequuntur sint odit impedit architecto. Odit alias quaerat soluta labore vel corporis qui omnis.') }}
        </p>
      </li>

      <li class="pp-item">
        <h3 class="pp-item__title">
          <span class="pp-dot" aria-hidden="true"></span>
          <span>{{ __('Dynamic Intranet Administrator') }}</span>
        </h3>
        <p>
          {{ __('Doloribus saepe et consectetur voluptatum nisi. Quibusdam vero aut quas odio qui consequatur cum eligendi sunt. Quis quia est perspiciatis vel praesentium. Et tempore ipsa possimus qui ea nemo. Ipsam dolores ut vel molestiae corrupti omnis sed dolores.') }}
        </p>
        <p class="indent">
          {{ __('Ducimus voluptate ut libero rerum ut adipisci porro voluptatem. Molestiae praesentium illo nemo eligendi qui. Magni fuga eaque facilis voluptate ipsum molestias.') }}
        </p>
        <p>
          {{ __('Sapiente sit non rerum adipisci quia placeat id. Consequatur dolore eius ut. Omnis iste voluptatum qui dolor molestiae.') }}
        </p>
      </li>
    </ul>
  </div>

  <!-- Consent bar -->
  <div class="pp__consent">
    <label class="pp-check">
      <input type="checkbox" id="accept-all" />
      <span class="box" aria-hidden="true"></span>
      <span class="sr-only">{{ __('Accept all privacy policy') }}</span>
    </label>

    <button class="pp-btn" type="button" aria-describedby="accept-all">
      {{ __('Accept all privacy policy') }}
    </button>
  </div>
</section>


@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const acceptCheckbox = document.getElementById('accept-all');
  const acceptButton = document.querySelector('.pp-btn');
  if (!acceptButton || !acceptCheckbox) {
    return;
  }

  const params = new URLSearchParams(window.location.search);
  const mode = (params.get('mode') || 'single').toLowerCase();
  const tournamentId = params.get('t');
  const gameId = params.get('g');
  const singleRoute = "{{ route('register.single') }}";
  const teamRoute = "{{ route('register.team') }}";

  acceptButton.addEventListener('click', function () {
    if (!acceptCheckbox.checked) {
      alert("{{ __('Please confirm you accept the privacy policy.') }}");
      return;
    }

    let baseUrl = mode === 'team' ? teamRoute : singleRoute;
    const target = new URL(baseUrl, window.location.origin);

    if (tournamentId) {
      target.searchParams.set('t', tournamentId);
    }

    if (gameId) {
      target.searchParams.set('g', gameId);
    }

    window.location.href = target.toString();
  });
});
</script>
@endpush
@push('scripts')
@vite('resources/js/script.js')
@endpush
