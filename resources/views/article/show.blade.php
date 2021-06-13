<x-app-layout>
    <article class="max-w-4xl mx-auto lg:grid lg:grid-cols-12 gap-x-10">
        <div class="col-span-4 lg:text-center lg:pt-14 mb-10">
            <img src="{{ $article->image_url }}" alt="" class="rounded-xl">

            <p class="mt-4 block text-gray-400 text-xs">
                Published <time>{{ $article->created_at->diffForHumans() ?? '' }}</time>
            </p>

            <div class="flex items-center lg:justify-center text-sm mt-4">
                <img src="{{ $article->author->profile_photo_url ?? '' }}" alt="avatar">
                <div class="ml-3 text-left">
                    <h5 class="font-bold">{{ $article->author->name ?? ''}}</h5>
                    <h6>Admin</h6>
                </div>
            </div>
        </div>

        <div class="col-span-8">
            <a href="/" class="transition-colors duration-300 relative inline-flex items-center text-lg hover:text-blue-500">
                <svg width="22" height="22" viewBox="0 0 22 22" class="mr-2">
                    <g fill="none" fill-rule="evenodd">
                        <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z">
                        </path>
                        <path class="fill-current" d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z">
                        </path>
                    </g>
                </svg>

                Back to Articles
            </a>
            <div class="hidden lg:flex justify-between mb-6">
                <div class="space-x-2">
                    <a href="#" class="px-3 py-1 border border-blue-300 rounded-full text-blue-300 text-xs uppercase font-semibold" style="font-size: 10px">{{ $article->category->name }}</a>
                </div>


                <div class="space-x-2">
                    @foreach ($article->tags as $tag)
                    <a href="#" class="px-3 py-1 border border-red-300 rounded-full text-red-300 text-xs uppercase font-semibold" style="font-size: 10px">{{ $tag->name }}</a>
                    @endforeach

                </div>
            </div>

            <h1 class="font-bold text-3xl lg:text-4xl mb-10">
                {{ $article->title }}
            </h1>

            <div class="space-y-4 lg:text-lg leading-loose">
                {!! $article->content !!}
            </div>
        </div>
    </article>

</x-app-layout>
