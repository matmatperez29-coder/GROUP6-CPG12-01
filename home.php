<?php
require_once 'db.php';
require_once 'auth.php'; // This also starts the session and connects to the DB
$currentUser = getCurrentUser(); // Returns user data if logged in, or null if not

// Fetch approved submitted articles from DB
$db = getDB();
$dbArticles = [];
try {
    $stmt = $db->query("
        SELECT s.id, s.title, s.category, s.summary, s.image_url, s.submitted_at,
               u.name AS author_name
        FROM article_submissions s
        JOIN users u ON s.author_id = u.id
        WHERE s.status = 'approved'
        ORDER BY s.submitted_at DESC
        LIMIT 20
    ");
    $dbArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $dbArticles = [];
}

$catColors = ['technology'=>'#0066cc','sports'=>'#ff6b35','entertainment'=>'#9b59b6','worldnews'=>'#27ae60'];
?>
<!doctype html>
<html lang="en">
  <head>
    <title>UrbanPulse | Landing Page</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="navfooter.css" />
    <link rel="stylesheet" href="home.css" />
    <link rel="stylesheet" href="burgermenu.css" />
    <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png" />
    <style>
      .active {
        color: #c8102e;
        text-decoration-color: #c8102e;
        text-decoration: underline;
        text-decoration-thickness: 1.5px;
      }
      /* contenteditable search box placeholder */
      #searchBox:empty::before {
        content: attr(data-placeholder);
        color: #aaa;
        font-style: italic;
        pointer-events: none;
      }
      #searchBox:focus { outline: none; }
      #searchBox::-webkit-scrollbar { display: none; }
      .search-bar-inner {
        display: flex !important;
        align-items: center !important;
        gap: 1rem !important;
        padding: 0.85rem 2rem !important;
        width: 100% !important;
        background: #fff !important;
      }
    </style>
  </head>
  <body>
    <!-- BREAKING NEWS STICKER -->
    <?php require_once 'nav.php'; ?>

<main>
      <div class="container">
        <section class="tools-bar" aria-label="Home page tools">
          <div class="tools-field">
            <label class="tools-label" for="articleSearch">Search stories</label>
            <input class="tools-input" type="search" id="articleSearch" placeholder="Search by headline, topic, author, or keyword">
          </div>
          <div class="tools-field">
            <label class="tools-label" for="categoryFilter">Filter by category</label>
            <select class="tools-select" id="categoryFilter">
              <option value="all">All categories</option>
              <option value="technology">Technology</option>
              <option value="sports">Sports</option>
              <option value="entertainment">Entertainment</option>
              <option value="worldnews">World News</option>
            </select>
          </div>
          <div class="tools-field">
            <label class="tools-label" for="dateFilter">Filter by date</label>
            <select class="tools-select" id="dateFilter">
              <option value="all">All dates</option>
              <option value="today">Today</option>
              <option value="startWeek">This week</option>
              <option value="startMonth">This month</option>
            </select>
          </div>
        </section>

        <div id="filterEmpty" class="filter-empty">No home page stories match your current search and filter combination.</div>
        <!-- Top Stories Banner -->
        <div class="top-banner">
          <h2>TOP STORIES</h2>
        </div>

        <!-- Hero Story (Large Top Story) -->
        <section class="hero-featured-home" data-filter-section>
        <a href="article-ai-agentic-revolution.php" class="card-link"><div class="hero-story filter-item" data-category="technology" data-date="2026-01-12" data-search="agentic AI autonomous systems enterprise productivity human-in-the-loop oversight Aris Thorne technology 2026">
          <div class="hero-image"><img src="https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=900&auto=format&fit=crop" alt="Artificial Intelligence concept" loading="lazy"></div>
          <div class="hero-content">
            <h1 class="hero-title">The Transition to Agentic AI and Autonomous Systems</h1>
            <p class="hero-summary">
              Following the "Agentic Revolution" of 2025, AI has shifted from simple chatbots to autonomous agents
              capable of executing complex workflows without human intervention. This evolution has transformed
              enterprise productivity but has sparked intense global debate over the lack of human-in-the-loop oversight.
            </p>
            <div class="hero-meta">
              <span class="category-tag">TECHNOLOGY</span>
              <span class="time-stamp">Jan 12, 2026 · 10:00 AM PST · Aris Thorne</span>
            </div>
          </div>
        </div></a>
        </section>

        <!-- Secondary Stories Grid (BBC 3-column layout) -->
        <div class="stories-grid" data-filter-section>

          <a href="article-eagles-super-bowl.php" class="card-link"><div class="story-card filter-item" data-category="sports" data-date="2025-02-09" data-search="Philadelphia Eagles Super Bowl LIX Kansas City Chiefs Marcus Thompson football NFL championship">
            <div class="story-image"><img src="https://images.unsplash.com/photo-1566577739112-5180d4bf9390?w=600&auto=format&fit=crop" alt="News" loading="lazy"></div>
            <div class="story-content">
              <h3 class="story-title">Philadelphia Eagles Triumph in Super Bowl LIX</h3>
              <p class="story-summary">The Eagles claimed their second franchise championship, defeating the Kansas City Chiefs 40–22 at the Caesars Superdome — denying them a historic "three-peat."</p>
              <div class="story-meta">
                <span class="category-tag">Sports</span>
                <span class="time-stamp">Feb 9, 2025 · Marcus Thompson</span>
              </div>
            </div>
          </div></a>

          <a href="article-gpt6-beta.php" class="card-link"><div class="story-card filter-item" data-category="technology" data-date="2026-02-18" data-search="GPT-6 beta emotional reasoning AI digital consciousness ethicists Julian Vane technology 2026">
            <div class="story-image"><img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=600&auto=format&fit=crop" alt="News" loading="lazy"></div>
            <div class="story-content">
              <h3 class="story-title">GPT-6 Early Beta: Users Report "Near-Human" Emotional Reasoning</h3>
              <p class="story-summary">Early testers have documented the AI exhibiting sophisticated emotional intelligence and nuanced ethical reasoning, prompting ethicists to call for new definitions of digital consciousness.</p>
              <div class="story-meta">
                <span class="category-tag">Technology</span>
                <span class="time-stamp">Feb 18, 2026 · Julian Vane</span>
              </div>
            </div>
          </div></a>

          <a href="article-plastic-oceans.php" class="card-link"><div class="story-card filter-item" data-category="worldnews" data-date="2026-02-21" data-search="plastic-free oceans Blue Horizon accord Geneva G20 coral reefs Julian Vane world news 2026">
            <div class="story-image"><img src="https://images.unsplash.com/photo-1518020382113-a7e8fc38eac9?w=600&auto=format&fit=crop" alt="News" loading="lazy"></div>
            <div class="story-content">
              <h3 class="story-title">Global Summit Targets Plastic-Free Oceans by 2040</h3>
              <p class="story-summary">World leaders ratified the "Blue Horizon" accord in Geneva, mandating a 90% reduction in single-use plastics — potentially restoring 40% of damaged coral reefs by 2050.</p>
              <div class="story-meta">
                <span class="category-tag">World News</span>
                <span class="time-stamp">Feb 21, 2026 · Julian Vane</span>
              </div>
            </div>
          </div></a>

        </div>

        <!-- Section Divider -->
        <div class="section-divider"></div>

        <!-- Latest Updates Section -->
        <div class="latest-section" data-filter-section>
          <h2 class="section-heading">LATEST UPDATES</h2>

          <!-- Compact Story List (BBC style) -->
          <div class="compact-stories">

            <a href="article-gpt6-beta.php" class="card-link"><div class="compact-story filter-item" data-category="technology" data-date="2026-02-18" data-search="GPT-6 beta emotional reasoning AI Julian Vane technology">
              <div class="compact-image"><img src="https://images.unsplash.com/photo-1676277791608-ac54525aa94d?w=300&auto=format&fit=crop" alt="News" loading="lazy"></div>
              <div class="compact-content">
                <h4>GPT-6 Early Beta: Users Report "Near-Human" Emotional Reasoning</h4>
                <p class="compact-meta"><span class="category-tag">TECHNOLOGY</span> · Feb 18, 2026 · 2:15 PM EST · Julian Vane</p>
              </div>
            </div></a>

            <a href="article-eagles-super-bowl.php" class="card-link"><div class="compact-story filter-item" data-category="sports" data-date="2025-02-09" data-search="Philadelphia Eagles Super Bowl LIX Marcus Thompson football NFL championship Kansas City Chiefs">
              <div class="compact-image"><img src="https://images.unsplash.com/photo-1566577739112-5180d4bf9390?w=300&auto=format&fit=crop" alt="News" loading="lazy"></div>
              <div class="compact-content">
                <h4>Philadelphia Eagles Triumph in Super Bowl LIX</h4>
                <p class="compact-meta"><span class="category-tag">SPORTS</span> · Feb 9, 2025 · 6:30 PM EST · Marcus Thompson</p>
              </div>
            </div></a>

            <a href="article-wimbledon.php" class="card-link"><div class="compact-story filter-item" data-category="sports" data-date="2025-07-13" data-search="Jannik Sinner Iga Swiatek Wimbledon 2025 tennis Elena Costas grass court finals">
              <div class="compact-image"><img src="https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?w=300&auto=format&fit=crop" alt="News" loading="lazy"></div>
              <div class="compact-content">
                <h4>Jannik Sinner and Iga Świątek Rule Wimbledon 2025</h4>
                <p class="compact-meta"><span class="category-tag">SPORTS</span> · Jul 13, 2025 · 2:00 PM GMT · Elena Costas</p>
              </div>
            </div></a>

            <a href="article-asean.php" class="card-link"><div class="compact-story filter-item" data-category="worldnews" data-date="2026-02-23" data-search="ASEAN trade pact digital currency framework Southeast Asia Aris Thorne world news 2026">
              <div class="compact-image"><img src="https://images.unsplash.com/photo-1523961131990-5ea7c61b2107?w=300&auto=format&fit=crop" alt="News" loading="lazy"></div>
              <div class="compact-content">
                <h4>ASEAN Trade Pact Establishes Digital Currency Framework</h4>
                <p class="compact-meta"><span class="category-tag">WORLD NEWS</span> · Feb 23, 2026 · 8:15 AM PHT · Aris Thorne</p>
              </div>
            </div></a>

            <a href="article-cinema-renaissance.php" class="card-link"><div class="compact-story filter-item" data-category="entertainment" data-date="2026-02-22" data-search="cinema directors fourth wall AI film festival 70mm Elena Thorne entertainment 2026">
              <div class="compact-image"><img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=300&auto=format&fit=crop" alt="News" loading="lazy"></div>
              <div class="compact-content">
                <h4>The Renaissance of Cinema: 2026's Boldest Directors Breaking the Fourth Wall</h4>
                <p class="compact-meta"><span class="category-tag">ENTERTAINMENT</span> · Feb 22, 2026 · Elena Thorne</p>
              </div>
            </div></a>

          </div>
        </div>

        <!-- Section Divider -->
        <div class="section-divider"></div>

        <!-- Category Sections (BBC style) -->
        <div class="category-section" data-filter-section>
          <h2 class="section-heading">TECHNOLOGY</h2>
          <div class="category-grid">

            <a href="article-humanoid-robots.php" class="card-link"><div class="category-card filter-item" data-category="technology" data-date="2025-11-14" data-search="humanoid robots manufacturing bipedal AI labor automotive Sarah Jenkins technology 2025">
              <div class="category-image"><img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=600&auto=format&fit=crop" alt="Technology" loading="lazy"></div>
              <h3>Humanoid Robots Join Global Manufacturing Lines</h3>
              <p class="story-summary">Major automotive plants integrated bipedal robots to handle hazardous materials and repetitive assembly tasks.
                <span class="more-text" style="display: none">
                  This marks the first time general-purpose physical AI has outperformed specialized machinery in adaptability and safety metrics. The integration has sparked labor discussions across 14 countries.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Nov 14, 2025 · 9:45 AM GMT · Sarah Jenkins</span>
            </div></a>

            <a href="article-meta-messenger.php" class="card-link"><div class="category-card filter-item" data-category="technology" data-date="2026-02-18" data-search="Meta Messenger desktop shutdown Facebook April 2026 Sharona Nicole Semilla technology">
              <div class="category-image"><img src="https://images.unsplash.com/photo-1611605698335-8b1569810432?w=600&auto=format&fit=crop" alt="Technology" loading="lazy"></div>
              <h3>Meta to Shut Down Messenger Desktop Website</h3>
              <p class="story-summary">Meta is officially pulling the plug on Messenger.com in April 2026, ending the platform's decade-long run as a standalone desktop experience.
                <span class="more-text" style="display: none">
                  Users will be redirected to the main Facebook interface, completing a two-year consolidation strategy aimed at simplifying Meta's product ecosystem globally.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Feb 18, 2026 · 10:09 PM PHT · Sharona Nicole Semilla</span>
            </div></a>

            <a href="article-infinix.php" class="card-link"><div class="category-card filter-item" data-category="technology" data-date="2026-02-23" data-search="Infinix NOTE 60 solid-state battery smartphone Sam Chen technology 2026">
              <div class="category-image"><img src="https://images.unsplash.com/photo-1512054502232-10a0a035d672?w=600&auto=format&fit=crop" alt="Technology" loading="lazy"></div>
              <h3>Infinix Unveils NOTE 60 Series with Revolutionary Battery Tech</h3>
              <p class="story-summary">The NOTE 60 Series introduces a solid-state battery hybrid that allows for a week of moderate usage on a single charge.
                <span class="more-text" style="display: none">
                  This release has forced competitors to pivot away from traditional lithium-ion designs in favor of high-density energy alternatives, reshaping the mid-range smartphone market.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Feb 23, 2026 · 2:30 PM CST · Sam Chen</span>
            </div></a>

          </div>
        </div>

        <!-- Section Divider -->
        <div class="section-divider"></div>

        <!-- Sports Section -->
        <div class="category-section" data-filter-section>
          <h2 class="section-heading">SPORTS</h2>
          <div class="category-grid">

            <a href="article-okc-thunder.php" class="card-link"><div class="category-card filter-item" data-category="sports" data-date="2025-06-22" data-search="Oklahoma City Thunder NBA championship Shai Gilgeous-Alexander Indiana Pacers Sarah Jenkins basketball 2025">
              <div class="category-image"><img src="https://images.unsplash.com/photo-1546519638405-a4d4e8df12b5?w=600&auto=format&fit=crop" alt="Sports" loading="lazy"></div>
              <h3>Oklahoma City Thunder Win First Title in 46 Years</h3>
              <p class="story-summary">In the first NBA Finals Game 7 since 2016, the OKC Thunder defeated the Indiana Pacers 103–91 to capture the 2025 NBA Championship.
                <span class="more-text" style="display: none">
                  Shai Gilgeous-Alexander became the first player since 2000 to win the scoring title, regular-season MVP, and Finals MVP in the same season. The franchise's first title since 1979.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Jun 22, 2025 · 8:00 PM CST · Sarah Jenkins</span>
            </div></a>

            <a href="article-psg.php" class="card-link"><div class="category-card filter-item" data-category="sports" data-date="2025-05-31" data-search="PSG Paris Saint-Germain Champions League Inter Milan Desire Doue treble James Pratt soccer football 2025">
              <div class="category-image"><img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?w=600&auto=format&fit=crop" alt="Sports" loading="lazy"></div>
              <h3>PSG Claims Maiden Champions League Trophy</h3>
              <p class="story-summary">Paris Saint-Germain finally achieved their long-sought European glory, dismantling Inter Milan 5–0 in the UEFA Champions League Final at the Allianz Arena in Munich.
                <span class="more-text" style="display: none">
                  Under manager Luis Enrique, 19-year-old Désiré Doué scored twice and earned Man of the Match. PSG became only the second French club to win the competition and the first to complete a continental treble.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">May 31, 2025 · 9:00 PM CET · James Pratt</span>
            </div></a>

            <a href="article-dodgers.php" class="card-link"><div class="category-card filter-item" data-category="sports" data-date="2025-11-02" data-search="Dodgers World Series Blue Jays back-to-back Miguel Rojas Will Smith Yamamoto David Sutherland baseball 2025">
              <div class="category-image"><img src="https://images.unsplash.com/photo-1508344928928-7165b67de128?w=600&auto=format&fit=crop" alt="Sports" loading="lazy"></div>
              <h3>Dodgers Repeat as World Series Champions</h3>
              <p class="story-summary">The Los Angeles Dodgers became the first team in the 21st century to win back-to-back World Series titles, defeating the Toronto Blue Jays 5–4 in an 11-inning Game 7 thriller.
                <span class="more-text" style="display: none">
                  Miguel Rojas hit a game-tying home run with two outs in the 9th. Will Smith blasted the go-ahead homer in the 11th, and Yoshinobu Yamamoto closed out in relief to cement a modern dynasty.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Nov 2, 2025 · 8:00 PM EST · David Sutherland</span>
            </div></a>

          </div>
        </div>

        <!-- Section Divider -->
        <div class="section-divider"></div>

        <!-- Entertainment Section -->
        <div class="category-section" data-filter-section>
          <h2 class="section-heading">ENTERTAINMENT</h2>
          <div class="category-grid">

            <a href="article-cinema-renaissance.php" class="card-link"><div class="category-card filter-item" data-category="entertainment" data-date="2026-02-22" data-search="cinema directors fourth wall AI film festival 70mm Elena Thorne entertainment renaissance 2026">
              <h3>The Renaissance of Cinema: 2026's Boldest Directors Breaking the Fourth Wall</h3>
              <p class="story-summary">From immersive AI-driven narratives to the return of 70mm film, this year's festival circuit is proving that the big screen experience is more alive than ever.
                <span class="more-text" style="display: none">
                  Directors are breaking traditional storytelling boundaries, experimenting with real-time AI-generated sequences that adapt to viewer emotion and audience participation.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Feb 22, 2026 · 8 MIN READ · Elena Thorne</span>
            </div></a>

            <a href="article-aero.php" class="card-link"><div class="category-card filter-item" data-category="entertainment" data-date="2026-02-22" data-search="AERO AI rapper music streaming charts record labels Binary B. entertainment 2026">
              <h3>AI Rapper 'AERO' Hits Number One on Global Charts</h3>
              <p class="story-summary">The AI-generated artist AERO has topped global streaming charts for the second consecutive week, reigniting fierce debates about authenticity in the music industry.
                <span class="more-text" style="display: none">
                  Record labels are divided — some view AERO as a threat to human artists, while others are racing to license similar AI tools for their own rosters and production pipelines.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Feb 22, 2026 · Binary B.</span>
            </div></a>

            <a href="article-vinyl.php" class="card-link"><div class="category-card filter-item" data-category="entertainment" data-date="2026-02-22" data-search="vinyl records digital downloads music sales Liam West entertainment record stores 2026">
              <h3>Vinyl Sales Outpace Digital Downloads for Third Year Running</h3>
              <p class="story-summary">Physical vinyl records have outsold digital downloads for the third consecutive year, marking a seismic shift in how audiences choose to experience music.
                <span class="more-text" style="display: none">
                  Industry analysts attribute the trend to younger listeners seeking a tangible connection to artists, driving a renaissance of independent record stores globally.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Feb 22, 2026 · Liam West</span>
            </div></a>

          </div>
        </div>

        <!-- Section Divider -->
        <div class="section-divider"></div>

        <!-- World News Section -->
        <div class="category-section" data-filter-section>
          <h2 class="section-heading">WORLD NEWS</h2>
          <div class="category-grid">

            <a href="article-plastic-oceans.php" class="card-link"><div class="category-card filter-item" data-category="worldnews" data-date="2026-02-21" data-search="plastic-free oceans Blue Horizon accord Geneva G20 coral reefs Julian Vane world news 2026">
              <h3>Global Summit Targets Plastic-Free Oceans by 2040</h3>
              <p class="story-summary">World leaders ratified the "Blue Horizon" accord in Geneva, mandating a 90% reduction in single-use plastics across G20 nations.
                <span class="more-text" style="display: none">
                  Oceanographers suggest this treaty could restore up to 40% of damaged coral reefs by 2050 through reduced chemical runoff and debris entering ocean ecosystems.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Feb 21, 2026 · 10:00 AM GMT · Julian Vane</span>
            </div></a>

            <a href="article-mars.php" class="card-link"><div class="category-card filter-item" data-category="worldnews" data-date="2026-02-22" data-search="Mars Base Alpha greenhouse harvest microgreens colony Sarah Jenkins world news 2026">
              <h3>Mars Base Alpha Reports First Successful Greenhouse Harvest</h3>
              <p class="story-summary">Scientists at the Mars Base Alpha colony successfully harvested their first crop of self-sustaining microgreens, a critical milestone in long-term human habitation beyond Earth.
                <span class="more-text" style="display: none">
                  The achievement proves that closed-loop agricultural systems can function in Martian gravity, accelerating proposals for a permanent Mars colony by 2035.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Feb 22, 2026 · 11:30 PM EST · Sarah Jenkins</span>
            </div></a>

            <a href="article-asean.php" class="card-link"><div class="category-card filter-item" data-category="worldnews" data-date="2026-02-23" data-search="ASEAN trade pact digital currency Southeast Asia Aris Thorne world news 2026">
              <h3>ASEAN Trade Pact Establishes Digital Currency Framework</h3>
              <p class="story-summary">Ten Southeast Asian nations signed a landmark trade pact introducing a unified digital currency framework to stabilize regional markets against global volatility.
                <span class="more-text" style="display: none">
                  The agreement aims to streamline cross-border payments and reduce reliance on external reserve currencies, with rollout expected by Q3 2026.
                </span>
                <button class="toggle-btn" onclick="toggleReadMore(this)">Read more</button>
              </p>
              <span class="time-tag">Feb 23, 2026 · 8:15 AM PHT · Aris Thorne</span>
            </div></a>

          </div>
        </div>

        <!-- Section Divider -->
        <div class="section-divider"></div>

        <!-- More Stories Grid -->
        <div class="more-stories" data-filter-section>
          <h2 class="section-heading">MORE STORIES</h2>
          <div class="more-grid">

            <a href="article-quantum.php" class="card-link"><div class="more-card filter-item" data-category="technology" data-date="2026-02-23" data-search="quantum materials 1D electron behavior scientists Elena Costas technology 2026">
              <h4>Quantum Materials: Scientists Confirm "True" 1D Electron Behavior</h4>
              <p class="more-meta"><span class="category-tag">TECHNOLOGY</span> · Feb 23, 2026 · Elena Costas</p>
            </div></a>

            <a href="article-australia-ai.php" class="card-link"><div class="more-card filter-item" data-category="technology" data-date="2026-02-22" data-search="Australia sovereign AI factory Marcus Thompson technology 2026">
              <h4>Australia Launches First Secure Sovereign AI Factory</h4>
              <p class="more-meta"><span class="category-tag">TECHNOLOGY</span> · Feb 22, 2026 · Marcus Thompson</p>
            </div></a>

            <a href="article-spacex.php" class="card-link"><div class="more-card filter-item" data-category="technology" data-date="2025-11-22" data-search="SpaceX Starship 5 orbital fuel transfer David Sutherland technology 2025">
              <h4>SpaceX Starship 5 Completes First Orbital Fuel Transfer</h4>
              <p class="more-meta"><span class="category-tag">TECHNOLOGY</span> · Nov 22, 2025 · David Sutherland</p>
            </div></a>

            <a href="article-satellites.php" class="card-link"><div class="more-card filter-item" data-category="worldnews" data-date="2026-02-23" data-search="internet satellite sub-orbital webs Elena Rodriguez world news 2026">
              <h4>The Internet's New Frontier: Sub-Orbital Satellite Webs</h4>
              <p class="more-meta"><span class="category-tag">WORLD NEWS</span> · Feb 23, 2026 · Elena Rodriguez</p>
            </div></a>

            <a href="article-disconnect.php" class="card-link"><div class="more-card filter-item" data-category="worldnews" data-date="2026-02-23" data-search="Brussels right to disconnect EU workers law Marcus Thompson world news 2026">
              <h4>Brussels Proposes 'Right to Disconnect' Law for EU Workers</h4>
              <p class="more-meta"><span class="category-tag">WORLD NEWS</span> · Feb 23, 2026 · Marcus Thompson</p>
            </div></a>

            <a href="article-amazon.php" class="card-link"><div class="more-card filter-item" data-category="worldnews" data-date="2026-02-20" data-search="Amazon reforestation Brazil five-year high David Sutherland world news 2026">
              <h4>Amazon Reforestation Hits Five-Year High in Brazil</h4>
              <p class="more-meta"><span class="category-tag">WORLD NEWS</span> · Feb 20, 2026 · David Sutherland</p>
            </div></a>

          </div>
        </div>
      </div>


      <!-- APPROVED SUBMITTED ARTICLES FROM DATABASE -->
      <?php if (!empty($dbArticles)): ?>
      <div class="container" style="margin-top:2.5rem;">
        <div class="section-banner" style="background:var(--color-secondary);padding:.75rem 1.5rem;margin-bottom:1.5rem;">
          <h2 style="color:white;font-family:var(--font-display);font-size:1.1rem;font-weight:900;letter-spacing:2px;text-transform:uppercase;margin:0;">
            📰 FROM OUR AUTHORS
          </h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
          <?php foreach ($dbArticles as $da):
            $slug = preg_replace('/[^a-z0-9]+/','-', strtolower($da['title']));
            $dateFormatted = date('M j, Y', strtotime($da['submitted_at']));
          ?>
          <a href="view-article.php?id=<?= $da['id'] ?>" class="card-link">
            <div class="category-card filter-item"
                 data-category="<?= htmlspecialchars($da['category']) ?>"
                 data-date="<?= date('Y-m-d', strtotime($da['submitted_at'])) ?>"
                 data-search="<?= htmlspecialchars($da['title'].' '.$da['summary'].' '.$da['author_name'].' '.$da['category']) ?>">
              <?php if ($da['image_url']): ?>
              <div class="category-image">
                <img src="<?= htmlspecialchars($da['image_url']) ?>"
                     alt="<?= htmlspecialchars($da['title']) ?>"
                     loading="lazy" style="width:100%;height:100%;object-fit:cover;">
              </div>
              <?php else: ?>
              <div class="category-image" style="background:<?= $catColors[$da['category']] ?? '#ccc' ?>;display:flex;align-items:center;justify-content:center;">
                <span style="color:white;font-size:2rem;opacity:.5;">📰</span>
              </div>
              <?php endif; ?>
              <div class="category-content">
                <span class="category-tag" style="background:<?= $catColors[$da['category']] ?? '#ccc' ?>">
                  <?= strtoupper(htmlspecialchars($da['category'])) ?>
                </span>
                <h3><?= htmlspecialchars($da['title']) ?></h3>
                <p class="category-excerpt"><?= htmlspecialchars($da['summary']) ?></p>
                <div class="category-meta">
                  <span><?= $dateFormatted ?></span>
                  <span>·</span>
                  <span><?= htmlspecialchars($da['author_name']) ?></span>
                </div>
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

    <!--FOOTER-->
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-content">
          <div class="footer-section">
            <h3>UrbanPulse</h3>
            <p>
              Independent journalism you can trust. Delivering truth in every
              story since 2026.
            </p>

            <div class="footer-social">
              <a href="#" aria-label="Facebook"> FB </a>
              <a href="#" aria-label="Twitter"> TW </a>
              <a href="#" aria-label="Instagram"> IG </a>
              <a href="#" aria-label="Github"> GH </a>
            </div>
          </div>

          <div class="footer-section">
            <h4>Categories</h4>
            <ul>
              <li><a href="technology.php"> Technology </a></li>
              <li><a href="sports.php"> Sports </a></li>
              <li><a href="entertainment.php"> Entertainment</a></li>
              <li><a href="worldnews.php"> World Names </a></li>
            </ul>
          </div>

          <div class="footer-section">
            <h4>Company</h4>
            <ul>
              <li><a href="about.php">About Us</a></li>
              <li><a href="contact.php">Contact</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">Advertise</a></li>
            </ul>
          </div>
          <div class="footer-section">
            <h4>Pledge</h4>
            <p id="pledge">
              We, the UrbanPulse team, pledge to deliver news that keeps people
              informed, aware, and always updated. Inspired by our school’s
              champion radio broadcasting team, we carry the same goal: to share
              information clearly, quickly, and with purpose.
            </p>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2026 UrbanPulse News. All rights reserved.</p>
        </div>
      </div>
    </footer>
    <!-- Mobile Burger Menu (Off-canvas) -->
    <div class="menu-overlay" id="menuOverlay" hidden></div>

    <aside
      class="burger-menu"
      id="burgerMenu"
      aria-hidden="true"
      aria-label="Site menu"
      inert
    >
      <div class="burger-top">
        <button
          type="button"
          class="menu-close"
          id="menuClose"
          aria-label="Close menu"
        >
          <svg
            width="22"
            height="22"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
          >
            <path d="M18 6 6 18"></path>
            <path d="M6 6l12 12"></path>
          </svg>
        </button>

        <div class="burger-brand">
          <div class="burger-logo">UrbanPulse</div>
          <div class="burger-tagline">Feel the Ripple!</div>
        </div>
      </div>

      <div class="burger-body">
        <div class="burger-section">
          <div class="burger-section-title">Browse</div>
          <nav class="burger-links" aria-label="Primary">
            <a class="burger-link" data-nav href="home.php">Home</a>
            <a
              class="burger-link"
              data-nav
              href="category-technology_updated.php"
              >Technology</a
            >
            <a class="burger-link" data-nav href="category-sport_updated.php"
              >Sports</a
            >
            <a
              class="burger-link"
              data-nav
              href="category-entertainment_updated.php"
              >Entertainment</a
            >
            <a class="burger-link" data-nav href="category-world_updated.php"
              >World News</a
            >
          </nav>
        </div>

        <div class="burger-divider"></div>

        <div class="burger-section">
          <div class="burger-section-title">Company</div>
          <nav class="burger-links" aria-label="Company">
            <a class="burger-link" data-nav href="about.php">About</a>
            <a class="burger-link" data-nav href="contact.php">Contact</a>
          </nav>
        </div>

        <div class="burger-divider"></div>

        <div class="burger-section burger-account">
          <div class="account-row">
            <div class="account-left">
              <span class="account-dot" aria-hidden="true"></span>
              <span class="account-name">Guest</span>
            </div>
            <a
              class="account-register"
              href="#"
              aria-label="Register (placeholder)"
              >Register</a
            >
          </div>

          <a class="burger-cta" href="#" aria-label="Sign in (placeholder)"
            >SIGN IN</a
          >
          <a class="burger-support" href="#" aria-label="Support (placeholder)"
            >Support</a
          >
        </div>
      </div>
    </aside>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="burger.js"></script>
    <script src="filter.js"></script>

    <script>
      /* ── Read More toggle ── */
      function toggleReadMore(btn) {
        const more = btn.previousElementSibling;
        const open = more.style.display === 'inline';
        more.style.display = open ? 'none' : 'inline';
        btn.textContent = open ? 'Read more' : 'Read less';
      }

      /* ── Inline search: filters .filter-item by data-search + heading text ── */
      (() => {
        const searchInput = document.getElementById('articleSearch');
        if (!searchInput) return;

        searchInput.addEventListener('input', function () {
          const query = this.value.trim().toLowerCase();
          const items = document.querySelectorAll('.filter-item');
          let visibleCount = 0;

          items.forEach(item => {
            const searchData = (item.dataset.search || '').toLowerCase();
            const headingEl  = item.querySelector('h1, h2, h3, h4');
            const headingText = headingEl ? headingEl.textContent.toLowerCase() : '';
            const summaryEl  = item.querySelector('p');
            const summaryText = summaryEl ? summaryEl.textContent.toLowerCase() : '';

            const matches = !query ||
              searchData.includes(query) ||
              headingText.includes(query) ||
              summaryText.includes(query);

            if (matches) {
              item.style.display = '';
              item.classList.remove('filter-hidden');
              item.classList.add('filter-visible');
              visibleCount++;
            } else {
              item.classList.add('filter-hidden');
              item.classList.remove('filter-visible');
              setTimeout(() => {
                if (item.classList.contains('filter-hidden')) item.style.display = 'none';
              }, 250);
            }
          });

          /* Hide empty parent sections */
          document.querySelectorAll('[data-filter-section]').forEach(sec => {
            const hasVisible = Array.from(sec.querySelectorAll('.filter-item'))
              .some(el => el.style.display !== 'none' && !el.classList.contains('filter-hidden'));
            sec.style.display = hasVisible ? '' : 'none';
          });

          /* Show/hide empty notice */
          const emptyEl = document.getElementById('filterEmpty');
          if (emptyEl) emptyEl.classList.toggle('is-visible', visibleCount === 0 && query.length > 0);
        });
      })();

      /* ── Philstar-style search drop bar toggle ── */
      (() => {
        const toggle = document.getElementById('searchToggle');
        const bar    = document.getElementById('searchBarDrop');
        const close  = document.getElementById('searchClose');
        const box    = document.getElementById('searchBox');
        if (!toggle || !bar) return;

        function openBar() {
          bar.classList.add('is-open');
          bar.setAttribute('aria-hidden', 'false');
          toggle.setAttribute('aria-expanded', 'true');
          if (box) setTimeout(() => box.focus(), 50);
        }
        function closeBar() {
          bar.classList.remove('is-open');
          bar.setAttribute('aria-hidden', 'true');
          toggle.setAttribute('aria-expanded', 'false');
        }

        toggle.addEventListener('click', () => {
          bar.classList.contains('is-open') ? closeBar() : openBar();
        });
        if (close) close.addEventListener('click', closeBar);
        document.addEventListener('keydown', e => {
          if (e.key === 'Escape' && bar.classList.contains('is-open')) closeBar();
        });
      })();
    </script>
  </body>
</html>
</html>