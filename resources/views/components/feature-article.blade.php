@props(['article'])

<article
    {{ $attributes->merge(['class' => 'flex flex-col md:flex-row rounded-lg shadow-xl overflow-hidden']) }}>
    <div class="flex h-48 md:w-1/2 md:h-96">

        <img class="object-cover w-full" src="{{ $article->image ?? 'storage/images/news/news-default.jpg' }}" alt="">

    </div>
    <div class="flex flex-col justify-between flex-1 p-6 bg-white md:border-l">
        <div class="flex-1">
            <div class="flex justify-between">

                <p class="text-sm font-medium text-indigo-600">
                    <a href="#" class="hover:underline">
                        {{ $article->category->name }}
                    </a>
                </p>
                <div>
                    @foreach($article->tags as $tag)
                    <a href="#" class="{{ $tag->classes }} text-xs font-semibold py-1 px-3 border-2 rounded-full">
                        {{ $tag->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            <a href="#" class="block mt-2">
                <p class="text-xl font-semibold text-gray-900">
                    {{ $article->title }}
                </p>
                <p class="mt-3 text-base text-gray-500">
                    {!! $article->excerpt !!}
                </p>
            </a>
        </div>
        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center">

                <div class="flex-shrink-0">
                    <a href="#">
                        <span class="sr-only">{{ $article->author->name ?? '' }}</span>
                        <img class="w-10 h-10 rounded-full" src="{{ $article->author->profile_photo_url ?? '' }}" alt="">
                    </a>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">
                        <a href="#" class="hover:underline">
                            {{ $article->author->name ?? '' }}
                        </a>
                    </p>
                    <div class="flex space-x-1 text-sm text-gray-500">
                        <time datetime="{{ $article->date->format('Y-m-d') }}">
                            {{ $article->date->format('m/d/Y') }}
                        </time>
                        <span aria-hidden="true">
                            &middot;
                        </span>
                        <span>
                            {{ $article->estimated_read_time }} read
                        </span>
                    </div>
                </div>
            </div>
            <div class="px-3 py-2 text-green-400 border-2 border-green-500 rounded-lg cursor-pointer hover:bg-green-600 hover:text-green-200">
                Read More
            </div>
        </div>
    </div>
</article>
