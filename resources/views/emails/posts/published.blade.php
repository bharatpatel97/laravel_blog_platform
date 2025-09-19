@component('mail::message')
# {{ $post->title }}

{{ Str::limit(strip_tags($post->content), 150) }}

@component('mail::button', ['url' => route('posts.show', $post)])
View Post
@endcomponent

*Published at: {{ $post->published_at ? $post->published_at->format('d M, Y') : 'Not Published' }}*

Thanks,  
{{ config('app.name') }}
@endcomponent
