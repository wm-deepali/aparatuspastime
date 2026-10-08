@extends('layouts.app')

@section('title', 'About Us | Aparatus Pastime - Made for Play. Built for Memories.')
@section('meta_description', 'Discover the story behind Aparatus Pastime. Our commitment to wholesome play, curious minds, and screen-free family adventures.')
@section('active_nav', 'about')

@section('content')

    <!-- ABOUT HERO -->
    <section class="bg-brand-navy text-white py-14 md:py-20 px-4 relative overflow-hidden">
      <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-brand-orange/20 blur-3xl pointer-events-none"></div>

      <div class="max-w-4xl mx-auto text-center relative z-10 space-y-3">
        <span class="inline-block bg-brand-orange text-white text-xs font-bold font-heading px-3.5 py-1 rounded-full uppercase tracking-wider">
          <i class="fa-solid fa-heart mr-1.5"></i>OUR STORY & VALUES
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-white leading-tight">
          MADE FOR PLAY.<br><span class="text-play-yellow">BUILT FOR MEMORIES.</span>
        </h1>
        <p class="text-xs sm:text-sm md:text-base text-white/90 max-w-xl mx-auto font-sans leading-relaxed">
          At Aparatus Pastime, we believe the best childhood memories happen outdoors, around family game tables, and through curious, open-ended hands-on discovery.
        </p>
      </div>
    </section>

    <!-- SECTION 1: OUR STORY & WHY WE STARTED -->
    <section class="py-14 md:py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center">
          <div class="space-y-4">
            <span class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3 py-1 rounded-full font-heading">
              HOW IT STARTED
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy">Why We Started Aparatus Pastime</h2>
            <p class="text-xs sm:text-sm text-body-text leading-relaxed font-sans">
              In a fast-paced world filled with flashing screens and disposable plastic novelties, we found that parents were searching for toys and games that encourage real, meaningful play.
            </p>
            <p class="text-xs sm:text-sm text-body-text leading-relaxed font-sans">
              Aparatus Pastime was created to give parents, teachers, and gift buyers a trustworthy destination for premium, non-toxic, and engaging toys, board games, and sports equipment that spark imagination and bring families closer together.
            </p>
            <div class="pt-2 flex items-center gap-6 font-heading">
              <div>
                <div class="text-2xl sm:text-3xl font-bold text-brand-navy">100%</div>
                <div class="text-xs text-brand-muted font-sans font-semibold">Child-Safe Materials</div>
              </div>
              <div class="w-px h-10 bg-brand-border"></div>
              <div>
                <div class="text-2xl sm:text-3xl font-bold text-brand-orange">Curated</div>
                <div class="text-xs text-brand-muted font-sans font-semibold">Zero-Clutter Quality</div>
              </div>
            </div>
          </div>

          <div class="aspect-16/11 rounded-3xl overflow-hidden bg-soft-blue p-3 relative shadow-md">
            <img src="https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=1000&q=80" alt="Kids playing with blocks" class="w-full h-full object-cover rounded-2xl">
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 2: WHAT WE BELIEVE (PLAY. LEARN. MOVE. IMAGINE.) -->
    <section class="py-14 md:py-20 bg-warm-cream border-y border-brand-border">
      <div class="max-w-7xl mx-auto px-4">

        <div class="text-center max-w-xl mx-auto mb-12">
          <span class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
            CORE PHILOSOPHY
          </span>
          <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy mt-2">What We Believe</h2>
          <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">
            Every product we curate is guided by four foundational principles of healthy child development.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

          <div class="bg-white p-6 rounded-3xl border border-brand-border space-y-3 shadow-xs text-center">
            <div class="w-14 h-14 rounded-2xl bg-soft-orange text-brand-orange flex items-center justify-center text-2xl mx-auto">
              <i class="fa-solid fa-shapes"></i>
            </div>
            <h3 class="font-heading font-bold text-base text-dark-navy">PLAY MATTERS</h3>
            <p class="text-xs text-body-text leading-relaxed font-sans">
              Play is how children understand the world, experiment safely, and build self-confidence.
            </p>
          </div>

          <div class="bg-white p-6 rounded-3xl border border-brand-border space-y-3 shadow-xs text-center">
            <div class="w-14 h-14 rounded-2xl bg-soft-mint text-emerald-600 flex items-center justify-center text-2xl mx-auto">
              <i class="fa-solid fa-atom"></i>
            </div>
            <h3 class="font-heading font-bold text-base text-dark-navy">LEARN MATTERS</h3>
            <p class="text-xs text-body-text leading-relaxed font-sans">
              Curiosity turns into lifelong problem-solving skills when learning is tactile, visual, and fun.
            </p>
          </div>

          <div class="bg-white p-6 rounded-3xl border border-brand-border space-y-3 shadow-xs text-center">
            <div class="w-14 h-14 rounded-2xl bg-soft-blue text-brand-blue flex items-center justify-center text-2xl mx-auto">
              <i class="fa-solid fa-person-running"></i>
            </div>
            <h3 class="font-heading font-bold text-base text-dark-navy">MOVE MATTERS</h3>
            <p class="text-xs text-body-text leading-relaxed font-sans">
              Active sports and fresh air foster strong bodies, motor coordination, and good team spirit.
            </p>
          </div>

          <div class="bg-white p-6 rounded-3xl border border-brand-border space-y-3 shadow-xs text-center">
            <div class="w-14 h-14 rounded-2xl bg-soft-yellow text-amber-500 flex items-center justify-center text-2xl mx-auto">
              <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <h3 class="font-heading font-bold text-base text-dark-navy">QUALITY MATTERS</h3>
            <p class="text-xs text-body-text leading-relaxed font-sans">
              We never compromise on safety, non-toxic materials, or durability that lasts for years.
            </p>
          </div>

        </div>

      </div>
    </section>

    <!-- SECTION 3: OUR PROMISE TO PARENTS -->
    <section class="py-14 md:py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-brand-navy to-[#0a4582] rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative z-10">
            <div class="space-y-3">
              <span class="text-xs font-bold text-play-yellow uppercase tracking-widest font-heading">
                OUR PROMISE
              </span>
              <h2 class="text-2xl sm:text-3xl font-bold font-heading text-white">
                Toys Made For Real Play & Big Smiles
              </h2>
              <p class="text-xs sm:text-sm text-white/90 font-sans leading-relaxed">
                If an item ever fails to delight you or your little explorer, our 7-day easy replacement policy and dedicated customer support team have you covered.
              </p>
            </div>
            <div class="flex flex-wrap gap-4 justify-start lg:justify-end">
              <a href="{{ route('shop') }}" class="btn-play-orange text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-md transition font-heading">
                EXPLORE THE COLLECTION →
              </a>
              <a href="{{ route('contact') }}" class="bg-white/20 hover:bg-white/30 text-white font-bold font-heading text-xs sm:text-sm px-6 py-3.5 rounded-xl border border-white/40 transition">
                CONTACT US
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection