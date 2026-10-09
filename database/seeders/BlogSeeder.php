<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => '5 Fun Indoor Games That Keep Kids Active & Engaged',
                'slug' => '5-fun-indoor-games-for-kids',
                'category' => 'Games & Play',
                'category_slug' => 'games',
                'image' => 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?auto=format&fit=crop&w=800&q=80',
                'banner_image' => 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?auto=format&fit=crop&w=1400&q=80',
                'short_description' => 'Turn rainy afternoons into dynamic arenas of strategic thinking, balance, and cooperative family laughter with these screen-free classics.',
                'author_name' => 'Dr. Alisha Sen',
                'author_role' => 'Child Development & Play Specialist',
                'author_avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80',
                'author_bio' => 'Dr. Sen has over 12 years of research in developmental psychology and kinetic learning. She advocates for daily screen-free cooperative play routines.',
                'key_takeaways' => [
                    'Tactile balance games refine fine-motor control and stress management under suspense.',
                    'Strategy board games teach children long-term resource planning and emotional agility.',
                    'Indoor target routines provide vital aerobic release without risking household furniture.',
                ],
                'tags' => ['IndoorActivities', 'ScreenFree', 'BoardGames', 'MotorSkills', 'FamilyTime'],
                'read_time' => 4,
                'views_count' => 1400,
                'published_at' => '2026-03-15 09:00:00',
                'is_featured' => 1,
                'show_home' => 1,
                'content' => <<<'HTML'
<p class="text-base sm:text-lg leading-relaxed text-body-text mb-6">
  When unpredictable weather keeps children indoors, energy levels often clash with confined living spaces. However, with the right structured games, indoor playtime transforms into one of the most rewarding developmental experiences for young minds. Below are five tested activities that balance physical coordination with cognitive problem-solving.
</p>

<div class="my-8 p-6 bg-gradient-to-r from-soft-blue via-soft-yellow/30 to-soft-mint/40 rounded-2xl border border-brand-border/80">
  <h4 class="text-xs font-bold uppercase tracking-wider text-brand-blue font-heading flex items-center gap-2 mb-2">
    <i class="fa-solid fa-lightbulb text-play-yellow text-sm"></i> EXPERT PLAY TIP
  </h4>
  <p class="text-xs sm:text-sm text-brand-navy leading-relaxed font-sans">
    Rotate available toy bins weekly rather than leaving all games out simultaneously. Studies show that offering 2–3 focused options increases sustained play engagement by over 60%.
  </p>
</div>

<div class="space-y-8">
  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <div class="flex items-center gap-3 mb-3">
      <span class="w-8 h-8 rounded-xl bg-brand-orange text-white font-bold font-heading flex items-center justify-center text-sm shadow-xs shrink-0">1</span>
      <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">The Precision Stacking & Balance Challenge</h3>
    </div>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Using solid wood precision blocks or tumbling towers, challenge players to construct the tallest stable structure while alternating colors, letters, or numbers. This stimulates fine motor calibration, spatial anticipation, and emotional composure under light suspense.
    </p>
  </div>

  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <div class="flex items-center gap-3 mb-3">
      <span class="w-8 h-8 rounded-xl bg-brand-blue text-white font-bold font-heading flex items-center justify-center text-sm shadow-xs shrink-0">2</span>
      <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">Living Room Civilization & Resource Strategy</h3>
    </div>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Modern modular board games introduce children to resource management, negotiation, and consequence forecasting. Unlike luck-only dice rollers, tactical board games teach children how to adapt and pivot when conditions change on the board.
    </p>
  </div>

  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <div class="flex items-center gap-3 mb-3">
      <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold font-heading flex items-center justify-center text-sm shadow-xs shrink-0">3</span>
      <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">Indoor Over-The-Door Active Target Tournaments</h3>
    </div>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Mini spring-action basketball hoops or soft velcro dartboards mounted over playroom doors provide an active cardiovascular outlet without risking room furnishings. Set up a timed 60-second shoot-out to practice hand-eye coordination and rhythmic breathing.
    </p>
  </div>

  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <div class="flex items-center gap-3 mb-3">
      <span class="w-8 h-8 rounded-xl bg-purple-600 text-white font-bold font-heading flex items-center justify-center text-sm shadow-xs shrink-0">4</span>
      <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">Magnetic Architecture & Suspension Bridges</h3>
    </div>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Challenge children to span a 40cm gap between two chairs using only magnetic geometric tiles and tension rods. Observing how triangular trusses support heavier loads introduces fundamental principles of civil engineering in a tactile, intuitive environment.
    </p>
  </div>

  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <div class="flex items-center gap-3 mb-3">
      <span class="w-8 h-8 rounded-xl bg-brand-navy text-white font-bold font-heading flex items-center justify-center text-sm shadow-xs shrink-0">5</span>
      <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">The Mystery Specimen Lab & Sketch Journal</h3>
    </div>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Using junior magnifying lenses or pocket microscopes, gather safe household textures (fabric weaves, spices, fallen leaves from house plants) and invite kids to sketch their discoveries. It fosters mindful focus, sensory distinction, and scientific curiosity.
    </p>
  </div>
</div>
HTML,
            ],
            [
                'title' => "How To Choose The Right Toy: A Parent's Guide to Meaningful Play",
                'slug' => 'how-to-choose-the-right-toy',
                'category' => 'Buying Guides',
                'category_slug' => 'guides',
                'image' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=800&q=80',
                'banner_image' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=1400&q=80',
                'short_description' => 'Cut through toy room clutter by focusing on open-ended materials, durable builds, and developmentally aligned age categories.',
                'author_name' => 'Kavita Rao',
                'author_role' => 'Editorial Lead & Play Curator',
                'author_avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&q=80',
                'author_bio' => 'Kavita curates the Aparatus Pastime collection, focusing on child-safe materials, Montessori fundamentals, and durable design.',
                'key_takeaways' => [
                    'Follow the 90% Child, 10% Toy rule: prioritize materials that require children to generate the action.',
                    'Tactile materials like solid wood, rubber, and textured cotton enhance sensory integration.',
                    'Choose toys that meet current motor readiness with just enough challenge to spark mastery.',
                ],
                'tags' => ['ToyGuide', 'Montessori', 'MindfulParenting', 'ChildSafety', 'Educational'],
                'read_time' => 6,
                'views_count' => 2100,
                'published_at' => '2026-02-28 09:00:00',
                'is_featured' => 0,
                'show_home' => 1,
                'content' => <<<'HTML'
<p class="text-base sm:text-lg leading-relaxed text-body-text mb-6">
  Walk down any mainstream toy aisle and you will be inundated by flashing strobe lights, noisy pre-programmed routines, and single-purpose electronic gadgets that captivate for twenty minutes before gathering dust in toy chests. At Aparatus Pastime, our philosophy is anchored in what child educators call <strong>“90% Child, 10% Toy”</strong>.
</p>

<div class="my-8 p-6 bg-gradient-to-r from-soft-orange via-soft-yellow/40 to-soft-blue/30 rounded-2xl border border-brand-border/80">
  <h4 class="text-xs font-bold uppercase tracking-wider text-brand-orange font-heading flex items-center gap-2 mb-2">
    <i class="fa-solid fa-quote-left text-brand-orange text-sm"></i> CORE PHILOSOPHY
  </h4>
  <p class="text-xs sm:text-sm text-brand-navy font-semibold leading-relaxed font-sans italic">
    “When the toy does less, the child’s imagination does more. The best toys don’t dictate the script — they hand the pen to the player.”
  </p>
</div>

<div class="space-y-8">
  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy mb-3 flex items-center gap-2">
      <i class="fa-solid fa-shapes text-brand-blue"></i> Look for Open-Ended Potential
    </h3>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      The best toys can be ten different things on ten different days. A set of translucent magnetic tiles can be a medieval fortress on Monday, an aerodynamic pit garage for sports cars on Tuesday, and a kaleidoscope under morning window light on Wednesday.
    </p>
  </div>

  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy mb-3 flex items-center gap-2">
      <i class="fa-solid fa-tree text-emerald-600"></i> Prioritize Tactile, Non-Toxic Materials
    </h3>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Natural beechwood, BPA-free high-density ABS, braided jute, and authentic PU leather teach children sensory appreciation. Quality materials provide realistic weight feedback that helps young children calibrate muscle memory and grip strength safely.
    </p>
  </div>

  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy mb-3 flex items-center gap-2">
      <i class="fa-solid fa-arrows-split-up-and-left text-brand-orange"></i> Respect Developmental Windows
    </h3>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Buying a toy meant for a 10-year-old for a 4-year-old often leads to frustration rather than accelerated learning. Choose play equipment that matches their current motor readiness with just enough challenge to foster confidence and self-efficacy upon mastery.
    </p>
  </div>
</div>
HTML,
            ],
            [
                'title' => 'Best Outdoor Activities For Kids: Fresh Air, Fitness & Friendship',
                'slug' => 'best-outdoor-activities-for-kids',
                'category' => 'Sports & Outdoor',
                'category_slug' => 'sports',
                'image' => 'https://images.unsplash.com/photo-1472162072942-cd5147eb3902?auto=format&fit=crop&w=800&q=80',
                'banner_image' => 'https://images.unsplash.com/photo-1472162072942-cd5147eb3902?auto=format&fit=crop&w=1400&q=80',
                'short_description' => 'Discover high-energy lawn games, precision sports, and field expeditions that build teamwork and athletic confidence outdoors.',
                'author_name' => 'Marcus Vance',
                'author_role' => 'Youth Athletic Coach & Outdoor Educator',
                'author_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                'author_bio' => 'Coach Marcus has trained junior athletes and led wilderness scouting programs for over a decade, helping kids build strength and team spirit through sport.',
                'key_takeaways' => [
                    'Target-based outdoor sports boost depth perception, cardiovascular stamina, and hand-eye coordination.',
                    'Lawn games with handicap distances allow multi-age siblings to play harmoniously together.',
                    'Outdoor scavenger missions encourage keen environmental observation and curiosity.',
                ],
                'tags' => ['OutdoorPlay', 'YouthSports', 'Cricket', 'ActiveLifestyle', 'HealthyHabits'],
                'read_time' => 5,
                'views_count' => 3200,
                'published_at' => '2026-02-10 09:00:00',
                'is_featured' => 0,
                'show_home' => 1,
                'content' => <<<'HTML'
<p class="text-base sm:text-lg leading-relaxed text-body-text mb-6">
  Outdoor free play is foundational for physical stamina, visual tracking, social negotiation, and emotional resilience. In an era where screens command hours of sedentary attention, cultivating an enthusiastic love for open skies, green fields, and collaborative sport is one of the greatest gifts we can offer.
</p>

<div class="my-8 p-6 bg-gradient-to-r from-soft-mint via-soft-blue/40 to-soft-yellow/30 rounded-2xl border border-brand-border/80">
  <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-700 font-heading flex items-center gap-2 mb-2">
    <i class="fa-solid fa-person-running text-emerald-600 text-sm"></i> COACH'S RULE OF THUMB
  </h4>
  <p class="text-xs sm:text-sm text-brand-navy leading-relaxed font-sans">
    Aim for at least 60 minutes of unconstrained outdoor movement every single day. Children who participate in regular active outdoor games show 40% higher sleep quality and improved classroom focus.
  </p>
</div>

<div class="space-y-8">
  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <div class="flex items-center gap-3 mb-3">
      <span class="w-8 h-8 rounded-xl bg-brand-orange text-white font-bold font-heading flex items-center justify-center text-sm shadow-xs shrink-0">1</span>
      <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">Backyard Cricket Target Bowling Challenge</h3>
    </div>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Set up junior Kashmir willow stumps on grass. Instead of standard batting-only matches, place colored disc markers for line-and-length targets. Bowlers earn bonus points for hitting specific target zones, turning repetitive practice into a thrilling, high-scoring game.
    </p>
  </div>

  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <div class="flex items-center gap-3 mb-3">
      <span class="w-8 h-8 rounded-xl bg-brand-blue text-white font-bold font-heading flex items-center justify-center text-sm shadow-xs shrink-0">2</span>
      <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">Lawn Ring Toss & Precision Decathlons</h3>
    </div>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Lawn ring toss is beloved because players of all age brackets can compete on equal footing. Establish varying throwing distances for different age groups (e.g. 5 feet for juniors, 10 feet for parents) to make every round nail-bitingly close.
    </p>
  </div>

  <div class="bg-warm-cream/70 rounded-2xl p-6 border border-brand-border/60">
    <div class="flex items-center gap-3 mb-3">
      <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold font-heading flex items-center justify-center text-sm shadow-xs shrink-0">3</span>
      <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">Field Binocular Scavenger Expeditions</h3>
    </div>
    <p class="text-sm sm:text-base text-body-text leading-relaxed">
      Equip young explorers with 8x21 optical binoculars and an expedition card: identify 3 local bird species, track an ant trail to its source, and collect 4 distinct fallen leaf shapes. Guided observation deepens environmental empathy and observational acuity.
    </p>
  </div>
</div>
HTML,
            ],
        ];

        foreach ($posts as $p) {
            Blog::updateOrCreate(['slug' => $p['slug']], $p + ['status' => 1]);
        }

        // Home page "Playroom Inspiration" heading (same table as the other home sections)
        if (Schema::hasTable('home_sections') && !DB::table('home_sections')->where('section_key', 'blogs')->exists()) {
            DB::table('home_sections')->insert([
                'section_key' => 'blogs',
                'badge_text' => 'IDEAS & GUIDES',
                'title' => 'PLAYROOM INSPIRATION',
                'subtitle' => 'Ideas, guides and inspiration for better playtime.',
                'button_text' => 'VIEW ALL INSPIRATION',
                'button_link' => null, // empty = blogs page
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}