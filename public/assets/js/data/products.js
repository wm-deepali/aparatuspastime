// Aparatus Pastime - Central Product Catalog
// Curated, premium toys, games, sports goods & educational sets

export const products = [
  {
    id: 1,
    name: "Match Pro Classic Football - Size 5",
    slug: "classic-football",
    category: "sports",
    categoryName: "Sports Goods",
    ageGroup: "9-12",
    ageLabel: "9–12 Years",
    price: 999,
    originalPrice: 1299,
    discount: 23,
    rating: 4.8,
    reviewCount: 38,
    badge: "Best Seller",
    stock: 18,
    featured: true,
    trending: true,
    newArrival: false,
    bestSeller: true,
    editorPick: true,
    twoProductFeatured: true, // Appears in 2-product section
    images: [
      "https://images.unsplash.com/photo-1511886929837-354d827aae26?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1579952363873-27f3bade9f55?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1614632537423-1e6c2e7e0aab?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "Hand-stitched synthetic leather football with reinforced latex bladder for optimal flight control, precision touch, and lasting outdoor durability.",
    description: "Designed for budding athletes and spirited weekend games, the Match Pro Classic Football offers superior ball control, water-resistant casing, and balanced weight distribution. Engineered with multi-layer polyester backing to maintain shape through intense play sessions on grass or turf.",
    specifications: {
      "Material": "Textured PU Leather with 4-ply lining",
      "Size": "Standard Size 5 (Youth & Training)",
      "Bladder": "Reinforced High-Retention Latex",
      "Stitching": "32-Panel Hand Stitched",
      "Weight": "420g - 440g",
      "Recommended Surface": "Natural Grass, Artificial Turf"
    },
    included: [
      "1x Match Pro Football",
      "1x Dual-Action Air Inflation Pump",
      "2x Brass Inflation Needles",
      "1x Breathable Ball Mesh Carry Bag"
    ],
    howToUse: "Inflate to recommended 8–10 PSI. Wipe clean with damp cloth after outdoor play and store away from direct sunlight.",
    reviews: [
      { id: 101, user: "Vikram Mehta", rating: 5, date: "2026-03-12", title: "Exceptional grip and durability", comment: "Bought this for my 10-year old son. The flight stability is superb and the outer shell hasn't scuffed despite heavy use on our turf park." },
      { id: 102, user: "Ananya Sharma", rating: 5, date: "2026-02-28", title: "Great quality accessories too", comment: "The included air pump and carry pouch made this a complete kit. Very impressive build quality!" }
    ]
  },
  {
    id: 2,
    name: "Kingdoms & Conquests Strategy Board Game",
    slug: "strategy-board-game",
    category: "games",
    categoryName: "Board Games",
    ageGroup: "12+",
    ageLabel: "12+ Years",
    price: 1899,
    originalPrice: 2499,
    discount: 24,
    rating: 4.9,
    reviewCount: 52,
    badge: "Editor's Choice",
    stock: 14,
    featured: true,
    trending: true,
    newArrival: false,
    bestSeller: true,
    editorPick: true,
    twoProductFeatured: true, // Appears in 2-product section
    images: [
      "https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1632501641765-e568d28b0015?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1563941402622-4e7a488bcc57?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "An immersive tactical civilization-building strategy game for 2–4 players with handcrafted wooden resource tokens and modular game board.",
    description: "Lead your realm through the ages of commerce, innovation, and alliance. Kingdoms & Conquests blends deep strategic depth with approachable gameplay rules. Every match is unique thanks to dynamically generated territory tiles and asymmetric character abilities.",
    specifications: {
      "Players": "2 to 4 Players",
      "Play Time": "45 - 75 Minutes",
      "Age Recommendation": "10 Years to Adult",
      "Language": "English",
      "Board Dimensions": "60 x 60 cm Modular Board"
    },
    included: [
      "1x Quad-fold Quad-Territory Game Board",
      "64x Handcrafted Beechwood Resource Tokens",
      "120x Illustrated Action & Tech Cards",
      "4x Player Command Dashboards",
      "1x Comprehensive Illustrated Rulebook"
    ],
    howToUse: "Set up the modular hex tiles according to chosen scenario map. Follow turn sequences: Harvest, Trade, Build, and Expand.",
    reviews: [
      { id: 103, user: "Rohan Sengupta", rating: 5, date: "2026-03-20", title: "Best family game night purchase", comment: "Complex enough for adults to love, yet intuitive for teenagers. The wooden pieces feel very premium." }
    ]
  },
  {
    id: 3,
    name: "Junior Champion Kashmir Willow Cricket Set",
    slug: "kids-cricket-set",
    category: "sports",
    categoryName: "Sports Goods",
    ageGroup: "6-8",
    ageLabel: "6–8 Years",
    price: 1499,
    originalPrice: 1999,
    discount: 25,
    rating: 4.7,
    reviewCount: 29,
    badge: "Trending",
    stock: 9,
    featured: true,
    trending: true,
    newArrival: true,
    bestSeller: false,
    editorPick: false,
    images: [
      "https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1624526267942-ab0ff8a3e972?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "Lightweight, expertly balanced cricket bat with heavy-duty wickets, bails, rubber grip, and safety soft-touch leatherette ball.",
    description: "Introduce your young champions to the excitement of cricket with this complete outdoor set. Carefully tailored to youth height with ergonomic chevron rubber grip for shock absorption and wrist safety.",
    specifications: {
      "Bat Material": "Selected Grade Kashmir Willow",
      "Bat Size": "Size 3 (Height 4'0\" to 4'5\")",
      "Stump Height": "24 Inches with sturdy spring base",
      "Ball Type": "Safety Impact Synthetic Leatherette"
    },
    included: [
      "1x Junior Cricket Bat (Chevron Grip)",
      "3x Wooden Stumps with Heavy Stand Base",
      "2x Wooden Bails",
      "2x Safety Practice Balls",
      "1x Heavy Duty Canvas Carry Duffle"
    ],
    howToUse: "Ensure safe play area. Bat is pre-knocked for soft ball play.",
    reviews: [
      { id: 104, user: "Karan Johar", rating: 5, date: "2026-03-05", title: "Perfect weight for 7yo", comment: "My son picked it up immediately. The bat balance is noticeably better than plastic toy kits." }
    ]
  },
  {
    id: 4,
    name: "STEM 12-in-1 Solar Powered Hydrobot Kit",
    slug: "solar-robot-kit",
    category: "educational",
    categoryName: "Educational & STEM",
    ageGroup: "9-12",
    ageLabel: "9–12 Years",
    price: 1299,
    originalPrice: 1699,
    discount: 24,
    rating: 4.9,
    reviewCount: 44,
    badge: "New Arrival",
    stock: 22,
    featured: true,
    trending: true,
    newArrival: true,
    bestSeller: false,
    editorPick: true,
    images: [
      "https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1535378917042-10a22c95931a?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "Build 12 unique crawling, rolling, and aquatic robots powered by green solar energy and hydraulic gearbox mechanics.",
    description: "Ignite mechanical curiosity with this hands-on STEM builder kit. No batteries required — children observe real photovoltaic solar conversion as gears turn and pistons move on land and in water.",
    specifications: {
      "Build Configurations": "12 Transforming Models",
      "Power Source": "Direct Solar Cell & Hydraulic Piston",
      "Piece Count": "190 Precision Snap-fit Components",
      "Skills": "Robotics, Green Energy, Spatial Reasoning"
    },
    included: [
      "190x Modular Snap-fit Robot Parts",
      "1x High-Efficiency Photovoltaic Solar Panel",
      "1x Hydraulic Gearbox System",
      "1x Step-by-Step Blueprint Manual"
    ],
    howToUse: "Follow diagrammatic assembly guide. Place outdoors under direct sunlight to initiate motion.",
    reviews: [
      { id: 105, user: "Sneha Patel", rating: 5, date: "2026-03-18", title: "Educational and super fun", comment: "My daughter built the beetle and boat configurations over a weekend. Great way to learn without screens." }
    ]
  },
  {
    id: 5,
    name: "Magnetic 3D Architect Master Tiles (100 Pcs)",
    slug: "magnetic-learning-set",
    category: "toys",
    categoryName: "Kids Toys",
    ageGroup: "3-5",
    ageLabel: "3–5 Years",
    price: 2199,
    originalPrice: 2899,
    discount: 24,
    rating: 4.9,
    reviewCount: 67,
    badge: "Top Rated",
    stock: 15,
    featured: true,
    trending: true,
    newArrival: false,
    bestSeller: true,
    editorPick: false,
    images: [
      "https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "Ultra-strong neodymium magnetic building tiles in translucent jewel tones for open-ended 2D and 3D architectural exploration.",
    description: "Made from food-grade BPA-free ultrasonic welded ABS with reinforced rivets for total safety. Helps younger children effortlessly understand geometry, structural balance, light refraction, and creative engineering.",
    specifications: {
      "Piece Count": "100 Translucent Magnetic Pieces",
      "Material": "BPA-Free, Non-Toxic ABS with Rounded Bevels",
      "Magnet Type": "Encapsulated Neodymium N35",
      "Age Grade": "3 Years and Up (EN71 & ASTM Certified)"
    },
    included: [
      "32x Squares (Small & Large)",
      "24x Equilateral & Right Triangles",
      "14x Isosceles Tall Triangles",
      "8x Window & Castle Door Panels",
      "2x Wheeled Car Chassis Bases",
      "1x Idea Inspiration Booklet",
      "1x Storage Drawstring Bag"
    ],
    howToUse: "Snap magnetic edges together to form towers, bridges, animals, and moving vehicles.",
    reviews: [
      { id: 106, user: "Pooja Roy", rating: 5, date: "2026-02-15", title: "Sturdy and safe magnets", comment: "Zero fear of magnets popping out. The colors under sunlight look like stained glass!" }
    ]
  },
  {
    id: 6,
    name: "AeroStrike Pro Kids Badminton Set with Carry Bag",
    slug: "kids-badminton-set",
    category: "sports",
    categoryName: "Sports Goods",
    ageGroup: "6-8",
    ageLabel: "6–8 Years",
    price: 849,
    originalPrice: 1199,
    discount: 29,
    rating: 4.6,
    reviewCount: 31,
    badge: "Special Offer",
    stock: 20,
    featured: true,
    trending: false,
    newArrival: false,
    bestSeller: true,
    editorPick: false,
    images: [
      "https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1613918108466-292b78a8ef95?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "Two lightweight isometric graphite-alloy racquets with large sweet spots and 3 durable nylon shuttlecocks.",
    description: "Shorter shaft length and lightweight build engineered specifically for children's wrist development. Provides forgiving sweet spot for confident volleys in backyards, parks, and indoor courts.",
    specifications: {
      "Frame Material": "High-Modulus Aluminum Alloy",
      "Shaft Length": "21 Inches (Youth Ergonomic)",
      "Weight": "85g per racquet",
      "Grip": "Sweat-absorbent PU Cushion Grip"
    },
    included: [
      "2x AeroStrike Youth Racquets",
      "3x High-Visibility Nylon Shuttles with Cork Base",
      "1x Zippered Shoulder Sling Bag"
    ],
    howToUse: "Store in protective sling bag in dry conditions.",
    reviews: [
      { id: 107, user: "Deepak Nambiar", rating: 5, date: "2026-03-01", title: "Great starter set", comment: "My daughter caught onto badminton within minutes. Very comfortable grip." }
    ]
  },
  {
    id: 7,
    name: "Wooden Tower Precision Block Stacking Game",
    slug: "wooden-tower-blocks",
    category: "games",
    categoryName: "Board Games",
    ageGroup: "6-8",
    ageLabel: "6–8 Years",
    price: 699,
    originalPrice: 899,
    discount: 22,
    rating: 4.8,
    reviewCount: 41,
    badge: "Popular",
    stock: 25,
    featured: false,
    trending: true,
    newArrival: false,
    bestSeller: true,
    editorPick: false,
    images: [
      "https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "54 hand-polished solid pine hardwood blocks with numbered dice for thrilling family stacking and balancing challenges.",
    description: "Precision-milled with smooth rounded corners and zero splinters. Test nerve, tactical thinking, and gentle dexterity as players pull lower blocks and balance them atop the ever-taller tower.",
    specifications: {
      "Material": "100% Sustainably Sourced Natural Pine Wood",
      "Block Count": "54 Blocks + 4 Numbered Dice",
      "Block Size": "7.5 x 2.5 x 1.5 cm each"
    },
    included: [
      "54x Smooth Hardwood Stacking Blocks",
      "4x Wooden Gaming Dice",
      "1x Stacking Alignment Sleeve",
      "1x Canvas Storage Bag"
    ],
    howToUse: "Build initial 18-layer tower. Take turns removing one block with one hand and balancing on top.",
    reviews: [
      { id: 108, user: "Manisha Rao", rating: 5, date: "2026-01-22", title: "Smooth finish", comment: "The wood smells great and the edges are completely smooth. Entertains our whole family." }
    ]
  },
  {
    id: 8,
    name: "Pro Court Mini Indoor Basketball Hoop & Ball",
    slug: "mini-basketball-set",
    category: "sports",
    categoryName: "Sports Goods",
    ageGroup: "6-8",
    ageLabel: "6–8 Years",
    price: 1199,
    originalPrice: 1599,
    discount: 25,
    rating: 4.7,
    reviewCount: 36,
    badge: "Active Play",
    stock: 16,
    featured: true,
    trending: true,
    newArrival: true,
    bestSeller: false,
    editorPick: false,
    images: [
      "https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1519861531473-9200262188bf?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "Shatterproof polycarbonate over-the-door basketball hoop with spring-action breakaway steel rim and mini basketball.",
    description: "Turn bedroom or playroom doors into a basketball court with heavy-duty foam-padded bracket mounts that protect door frames from scuffs. Realistic spring flex allows authentic slam dunks.",
    specifications: {
      "Backboard": "45 x 30 cm Shatterproof Polycarbonate",
      "Rim": "Solid Steel with Spring-Action Flex (22 cm diameter)",
      "Mounting": "Thick Protective EVA Foam Door Mounts"
    },
    included: [
      "1x Heavy-Duty Clear Backboard & Steel Rim",
      "2x High-Grip Mini Rubber Basketballs",
      "1x Hand Air Pump with Needle",
      "1x Door Mounting Hardware & Tool"
    ],
    howToUse: "Hang over standard interior doors without drilling.",
    reviews: [
      { id: 109, user: "Aditya Verma", rating: 5, date: "2026-03-14", title: "Very sturdy spring rim", comment: "Doesn't rattle or damage the door at all. Great break from desk study sessions." }
    ]
  },
  {
    id: 9,
    name: "Explorer Naturalist Binoculars & Adventure Pack",
    slug: "outdoor-adventure-kit",
    category: "outdoor",
    categoryName: "Outdoor Gear",
    ageGroup: "6-8",
    ageLabel: "6–8 Years",
    price: 1349,
    originalPrice: 1799,
    discount: 25,
    rating: 4.8,
    reviewCount: 22,
    badge: "Outdoor Fun",
    stock: 11,
    featured: false,
    trending: true,
    newArrival: true,
    bestSeller: false,
    editorPick: true,
    images: [
      "https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "High-clarity 8x21 optical glass binoculars with liquid-filled compass, LED hand-crank flashlight, and insect specimen viewer.",
    description: "Encourage curiosity for nature, birdwatching, camping trips, and backyard exploration. Shock-resistant rubberized coating protects optical lenses from drops and bumps.",
    specifications: {
      "Magnification": "8x Optical Zoom with 21mm Objective Lens",
      "Eyepiece": "Soft Rubber Eye-Cups for Comfort",
      "Features": "Flashlight requires zero batteries (hand-crank dynamo)"
    },
    included: [
      "1x 8x21 Shockproof Binoculars with Neck Strap",
      "1x Dynamo Hand-Crank LED Flashlight",
      "1x Lensatic Directional Compass",
      "1x Magnifying Bug Catcher Box with Tweezers",
      "1x Water-Resistant Belt Backpack"
    ],
    howToUse: "Adjust center wheel for focus. Use neck strap during field hikes.",
    reviews: [
      { id: 110, user: "Suresh Pillai", rating: 5, date: "2026-02-19", title: "Real optical lenses, not blurry toys", comment: "Very clear magnification for bird watching on our hill vacation." }
    ]
  },
  {
    id: 10,
    name: "Classic Solid Wood Ring Toss Outdoor Lawn Game",
    slug: "outdoor-ring-toss",
    category: "outdoor",
    categoryName: "Outdoor Gear",
    ageGroup: "3-5",
    ageLabel: "3–5 Years",
    price: 799,
    originalPrice: 999,
    discount: 20,
    rating: 4.6,
    reviewCount: 19,
    badge: "Family Classic",
    stock: 14,
    featured: false,
    trending: false,
    newArrival: false,
    bestSeller: true,
    editorPick: false,
    images: [
      "https://images.unsplash.com/photo-1566454544259-f4b94c3d758c?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1502086223501-7ea6ecd79368?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "Solid pine cross-base targets with scoring pegs, 5 natural braided jute rope rings, and 5 colorful safety plastic rings.",
    description: "Develop hand-eye coordination, counting skills, and active outdoor family competition. Quick tool-free 60-second setup on lawns, sand, or living room rugs.",
    specifications: {
      "Base": "Solid Stained Pine Wood Cross Target (42 x 42 cm)",
      "Rings": "5x Braided Jute Rope with Wood Beads + 5x Polymer Rings",
      "Score Markers": "Color-coded point indicators (5, 10, 15, 20, 25)"
    },
    included: [
      "2x Interlocking Target Base Arms",
      "5x Screw-in Wooden Scoring Pegs",
      "5x Jute Throwing Rings",
      "5x Color Throwing Rings",
      "1x Compact Storage Bag"
    ],
    howToUse: "Slot base arms together, screw pegs into pre-threaded brass inserts, and place 10 feet apart.",
    reviews: [
      { id: 111, user: "Sunita Iyer", rating: 5, date: "2026-03-08", title: "Kids and grandparents loved it", comment: "Simple, screen-free fun at our backyard BBQ." }
    ]
  },
  {
    id: 11,
    name: "Little Maestro Deluxe Art Studio & Easel Kit",
    slug: "creative-activity-set",
    category: "activity",
    categoryName: "Creative & Activity",
    ageGroup: "3-5",
    ageLabel: "3–5 Years",
    price: 1599,
    originalPrice: 2199,
    discount: 27,
    rating: 4.8,
    reviewCount: 35,
    badge: "Creative Pick",
    stock: 10,
    featured: false,
    trending: true,
    newArrival: true,
    bestSeller: false,
    editorPick: true,
    images: [
      "https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1560421683-680b9c8d4222?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "Complete non-toxic 86-piece painting and sketching studio in a polished wooden folding carry briefcase with dual easel.",
    description: "Foster unbounded creative expression. Features vibrant watercolor cakes, beeswax oil pastels, fine-tip markers, color pencils, and premium sketch paper in a travel-ready wooden case.",
    specifications: {
      "Case Material": "Solid Polished Pine with Brass Clasp & Handle",
      "Safety": "100% Non-toxic, Washable Pigments (AP Certified)",
      "Pieces": "86 Creative Art Tools"
    },
    included: [
      "24x Oil Pastels",
      "24x Watercolor Cakes & Paintbrush",
      "12x Colored Pencils",
      "12x Fine Tip Washable Markers",
      "1x Dual Tabletop Pop-up Easel Board",
      "1x Sketch Pad & Eraser"
    ],
    howToUse: "Unlatch brass clasps, fold up easel stand, and clip paper into place.",
    reviews: [
      { id: 112, user: "Farhan Qureshi", rating: 5, date: "2026-02-24", title: "Very impressive presentation", comment: "Gave this as a birthday gift and it looked so expensive and classy." }
    ]
  },
  {
    id: 12,
    name: "BrainSpark 3D Wooden Mechanical Puzzle Clock",
    slug: "educational-puzzle",
    category: "educational",
    categoryName: "Educational & STEM",
    ageGroup: "12+",
    ageLabel: "12+ Years",
    price: 1749,
    originalPrice: 2299,
    discount: 24,
    rating: 4.9,
    reviewCount: 48,
    badge: "STEM Star",
    stock: 8,
    featured: false,
    trending: true,
    newArrival: false,
    bestSeller: true,
    editorPick: true,
    images: [
      "https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=800&q=80",
      "https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?auto=format&fit=crop&w=800&q=80"
    ],
    shortDescription: "Laser-cut basswood working pendulum clock puzzle with gravity escapement and zero glue required for assembly.",
    description: "A mesmerizing convergence of historical clockwork horology and tactile puzzle solving. Precision laser-cut sheets assemble smoothly into a ticking geometric centerpiece.",
    specifications: {
      "Parts": "168 Laser Cut Precision Basswood Pieces",
      "Assembly Time": "4 - 6 Hours",
      "Mechanism": "Gravity Pendulum & Escapement Wheel"
    },
    included: [
      "5x Pre-cut Basswood Plywood Sheets",
      "1x Sandpaper & Wax Block",
      "1x Steel Axis Rods & Spacers",
      "1x Detailed 3D Visual Assembly Manual"
    ],
    howToUse: "Follow numbered step-by-step schematics. Wax moving gear teeth for smooth frictionless rotation.",
    reviews: [
      { id: 113, user: "Tanvi Kapoor", rating: 5, date: "2026-03-02", title: "Masterpiece on my bookshelf", comment: "Assembling this was so relaxing and it actually ticks when wound up!" }
    ]
  }
];
