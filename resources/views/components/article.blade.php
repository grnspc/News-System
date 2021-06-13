@props(['article'])

<article
    {{ $attributes->merge(['class' => 'flex flex-col rounded-lg shadow-xl overflow-hidden']) }}>
    <div class="flex-shrink-0 h-48">
        <img class="w-full object-cover" src="{{ $article->image_url }}" alt="">
    </div>
    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
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
            <a href="{{ route('articles', $article->slug) }}" class="block mt-2">
                <p class="text-xl font-semibold text-gray-900">
                    {{ $article->title }}
                </p>
                <p class="mt-3 text-base text-gray-500">
                    {!! $article->excerpt !!}
                </p>
            </a>
        </div>
        <div class="mt-6 flex items-center justify-between">
            <div class="flex items-center">

                <div class="flex-shrink-0">
                    <a href="#">
                        <span class="sr-only">{{ $article->author->full_name }}</span>
                        <img class="h-10 w-10 rounded-full" src="{{ $article->author->profile_photo_url }}" alt="">
                    </a>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">
                        <a href="#" class="hover:underline">
                            {{ $article->author->full_name }}
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
        </div>
    </div>
</article>
