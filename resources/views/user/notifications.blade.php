@extends('layouts.app')

@section('title', 'Notifications | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('user.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">Notifications</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('user._sidebar', ['active' => 'notifications', 'customer' => $customer])

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-9 space-y-6">

          <div class="pb-4 border-b border-brand-border flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Notifications & Alerts</h1>
              <p class="text-xs text-brand-muted font-body mt-1">Delivery updates and order alerts.</p>
            </div>
            @if ($unreadCount > 0)
              <form method="POST" action="{{ route('user.notifications.read-all') }}">
                @csrf
                <button type="submit" class="text-xs font-bold font-heading text-brand-blue hover:text-brand-orange transition cursor-pointer">
                  Mark all as read ({{ $unreadCount }})
                </button>
              </form>
            @endif
          </div>

          @if (session('success'))
            <div class="bg-soft-mint border border-mint text-emerald-800 rounded-2xl p-4 text-xs font-bold font-body">{{ session('success') }}</div>
          @endif

          <div class="space-y-3">
            @forelse ($notifications as $n)
              @php
                $palette = match ($n->color) {
                    'blue'          => 'bg-soft-blue text-brand-blue',
                    'green', 'mint' => 'bg-soft-mint text-emerald-700',
                    'purple'        => 'bg-soft-purple text-purple-700',
                    'yellow'        => 'bg-soft-yellow text-amber-700',
                    'red'           => 'bg-soft-coral text-red-700',
                    default         => 'bg-soft-orange text-brand-orange',
                };
                $icon = $n->icon ?: 'fa-bell';
              @endphp

              <div class="bg-white rounded-3xl border {{ $n->is_read ? 'border-brand-border shadow-xs' : 'border-brand-orange/40 bg-soft-orange/30 shadow-sm' }} p-5 flex items-start justify-between gap-4">
                <div class="flex items-start gap-3.5 min-w-0">
                  <div class="w-10 h-10 rounded-2xl {{ $palette }} flex items-center justify-center shrink-0 text-sm">
                    <i class="fa-solid {{ $icon }}"></i>
                  </div>
                  <div class="min-w-0">
                    <h4 class="font-heading font-bold text-sm text-brand-navy">{{ $n->title }}</h4>
                    <p class="text-xs text-body-text mt-0.5 font-body leading-relaxed">{{ $n->message }}</p>
                    <span class="text-[10px] text-brand-muted mt-1 block font-medium">{{ $n->created_at->diffForHumans() }}</span>

                    @if (! $n->is_read)
                      <form method="POST" action="{{ route('user.notifications.read', $n) }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-[11px] font-bold font-heading text-brand-orange hover:underline cursor-pointer">
                          {{ $n->url ? 'View →' : 'Mark as read' }}
                        </button>
                      </form>
                    @elseif ($n->url)
                      <a href="{{ $n->url }}" class="inline-block mt-2 text-[11px] font-bold font-heading text-brand-blue hover:text-brand-orange">View →</a>
                    @endif
                  </div>
                </div>

                @unless ($n->is_read)
                  <span class="w-2.5 h-2.5 rounded-full bg-brand-orange shrink-0 mt-2 animate-pulse"></span>
                @endunless
              </div>
            @empty
              <div class="bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-soft-blue text-brand-blue flex items-center justify-center text-2xl mx-auto">
                  <i class="fa-regular fa-bell"></i>
                </div>
                <h3 class="font-heading font-extrabold text-lg text-brand-navy">No notifications yet</h3>
                <p class="text-xs sm:text-sm text-brand-muted max-w-sm mx-auto font-body">Order and delivery updates will show up here.</p>
              </div>
            @endforelse

            {{ $notifications->links() }}
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection