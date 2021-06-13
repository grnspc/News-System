    <div class="">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                League News & Updates
            </h2>
            <p class="max-w-2xl mx-auto mt-3 text-xl text-gray-500 sm:mt-4">
                Latest league news and updates.
            </p>
        </div>


        <div class="mt-6 space-y-6">
            @if ($articles->count())

            <x-news::feature-article :article="$articles[0]" />

            @if ($articles->count() > 1)
            <div class="gap-10 space-y-6 lg:grid lg:grid-cols-6 lg:space-y-0">
                @foreach($articles->skip(1) as $article)
                <x-news::article
                    :article="$article"
                    class="{{ $loop->iteration < 3 ? 'col-span-3' : 'col-span-2' }}"
                />
                @endforeach
            </div>
            @endif
            @else
                <p class="text-center">No News, Please check back later. </p>
            @endif
        </div>
    </div>

