{{-- user info and avatar --}}
<div class="avatar av-l chatify-d-flex"></div>
<p class="info-name">{{ config('chatify.name') }}</p>
<div class="messenger-infoView-btns">
    <a href="#" class="danger delete-conversation">Delete Conversation</a>
</div>
{{-- shared photos --}}
<div class="messenger-infoView-shared">
    <p class="messenger-title"><span>Shared Photos</span></p>
    <div class="shared-photos-list"></div>
</div>


{{-- user info and avatar --}}
{{-- @include('Chatify::layouts.headLinks') --}}
{{-- {{dd($id)}} --}}
{{-- @php
    $user = \App\Models\User::where('id', request()->segment(2))->first();
@endphp
@if ($user->photo == null && !file_exists(public_path() . '/uploads/user/' . $user->photo))
    <div class="avatar av-l chatify-d-flex"></div>
@else
    <div class="av-l chatify-d-flex"><img src="{{ asset('/uploads/user/Thumb-' . $user->photo) }}" alt=""></div>
@endif
<p class="info-name">{{ \App\Models\User::where('id', request()->route('id'))->value('full_name') ?? \App\Models\User::where('id', request()->segment(2))->value('full_name') }}</p>
<p class="info-name">{{ $user->full_name }}</p>
<div class="messenger-infoView-btns">
    <a href="#" class="danger delete-conversation">Delete Conversation</a>
</div> --}}
{{-- shared photos --}}
{{-- <div class="messenger-infoView-shared">
    <p class="messenger-title"><span>Shared Photos</span></p>
    <div class="shared-photos-list"></div>
</div> --}}
