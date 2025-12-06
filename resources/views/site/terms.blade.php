@extends('layouts.app')

@section('title', __('Terms of Service'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/terms.css',
    ])
@endpush

@section('content')


    <section class="tc" aria-labelledby="tc-title">
      <!--  -->
      <div class="right-panel">
        <div class="form-header" style="margin: 50px">
          <button
            class="tab-btn active"
            style="
              font-size: 20px;
              border-radius: 10px;
              background: linear-gradient(#970f05, #fff);
            "
          >
            {{ content('terms.header.title', __('Terms and Conditions')) }}
          </button>
        </div>
      </div>
      <!--  -->

      <div class="tc__content">
        <ul class="tc-list">
          <li class="tc-item">
            <h3 class="tc-item__title">
              <span class="tc-dot" aria-hidden="true"></span>
              <span>{{ content('terms.section1.title', __('National Markets Orchestrator')) }}</span>
            </h3>
            <p>
              {{ content('terms.section1.content1', __('Vero quis est. Quos sint ut voluptate quo pariatur ut ut culpa. Et ullam quia quia optio maiores. Qui in ut repudiandae et et voluptatem. Ipsa ratione expedita sit provident voluptatem doloremque blanditiis temporibus ab. Corporis excepturi unde ipsam maxime qui sunt ipsam sunt eos.')) }}
            </p>
            <p class="indent">
              {{ content('terms.section1.content2', __('Perspiciatis earum porro dolorum molestiae perspiciatis. Eos culpa consequatur et soluta cum. Non recusandae ratione voluptatem et id atque nesciunt. Maxime delectus rerum. Totam velit ipsum aut ut. Ea dolorum vero aspernatur assumenda asperiores vitae voluptatem.')) }}
            </p>
            <p>
              {{ content('terms.section1.content3', __('Id dolor hic sint eum blanditiis. Et veritatis libero et doloremque et cumque architecto mollitia. Quia illum enim ipsam voluptatem vitae et sit recusandae.')) }}
            </p>
          </li>

          <li class="tc-item">
            <h3 class="tc-item__title">
              <span class="tc-dot" aria-hidden="true"></span>
              <span>{{ content('terms.section2.title', __('National Metrics Planner')) }}</span>
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

          <li class="tc-item">
            <h3 class="tc-item__title">
              <span class="tc-dot" aria-hidden="true"></span>
              <span>{{ content('terms.section3.title', __('Dynamic Intranet Administrator')) }}</span>
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
      <div class="tc__consent">
        <label class="tc-check">
          <input type="checkbox" id="approve-all" />
          <span class="box" aria-hidden="true"></span>
          <span class="sr-only">{{ __('Approve all terms and conditions') }}</span>
        </label>

        <button class="tc-btn" type="button" aria-describedby="approve-all">
          {{ content('terms.consent.button_text', __('Approve all terms and conditions')) }}
        </button>
      </div>
    </section>


@endsection
@push('scripts')
@vite('resources/js/script.js')
@endpush
