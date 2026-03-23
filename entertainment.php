<?php
require_once 'db.php';
require_once 'auth.php'; // This also starts the session and connects to the DB
$currentUser = getCurrentUser(); // Returns user data if logged in, or null if not
?><!DOCTYPE html>
<html lang="en">
<head>
  <title>UrbanPulse | Entertainment</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="navfooter.css">
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="entertainment.css">
  <link rel="stylesheet" href="burgermenu.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
  <style>
    .active { color: #c8102e !important; text-decoration: underline !important; text-decoration-color: #c8102e !important; text-decoration-thickness: 2px !important; }
    /* Search box — same as home.php */
    #searchBox:empty::before { content: attr(data-placeholder); color: #aaa; font-style: italic; pointer-events: none; }
    #searchBox:focus { outline: none; }
    #searchBox::-webkit-scrollbar { display: none; }
    .search-bar-inner { display: flex !important; align-items: center !important; gap: 1rem !important; padding: 0.85rem 2rem !important; width: 100% !important; background: #fff !important; }
    /* Card hover */
    a.card-link { display: block; text-decoration: none; color: inherit; }
    a.card-link:hover .news-card { box-shadow: 0 6px 20px rgba(0,0,0,.13); transform: translateY(-3px); }
    a.card-link:hover .news-card-title { color: #c8102e; }
    a.card-link:hover .sidebar-story { border-color: #c8102e; }
    .news-card { transition: box-shadow .2s, transform .2s; }
    /* Image fills */
    .news-card-image { overflow: hidden; border-radius: 6px; aspect-ratio: 16/9; height: auto; }
    .news-card-image img, .hero-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hero-image { overflow: hidden; border-radius: 8px; }
  </style>
</head>
<body>

  <!-- BREAKING NEWS -->
  <?php require_once 'nav.php'; ?>



  <!-- SEARCH DROP BAR — same as home.php -->
  <div class="search-bar-drop" id="searchBarDrop" aria-hidden="true">
    <div class="search-bar-inner">
      <div id="searchBox"
        role="searchbox"
        contenteditable="true"
        aria-label="Search UrbanPulse"
        data-placeholder="Enter search item"
        spellcheck="false"></div>
      <button class="search-bar-close" id="searchClose" aria-label="Close search">&#10005;</button>
    </div>
    <div id="results" class="search-bar-results"></div>
  </div>

  <!-- ENTERTAINMENT SUB-NAV -->
  <nav class="entertainment-nav">
    <div class="entertainment-nav-container">
      <a href="#" class="active">All</a>
      <a href="#">Movies</a>
      <a href="#">Music</a>
      <a href="#">TV Shows</a>
      <a href="#">Celebrity</a>
      <a href="#">Style</a>
      <a href="#">Buzz</a>
    </div>
  </nav>

  <main>
    <div class="container">

      <!-- TOOLS BAR — same layout as home.php -->
      <section class="tools-bar" aria-label="Entertainment page tools">
        <div class="tools-field">
          <label class="tools-label" for="articleSearch">Search stories</label>
          <input class="tools-input" type="search" id="articleSearch" placeholder="Search by headline, topic, author, or keyword">
        </div>
        <div class="tools-field">
          <label class="tools-label" for="categoryFilter">Filter by category</label>
          <select class="tools-select" id="categoryFilter">
            <option value="all">All categories</option>
            <option value="celebrity">Celebrity</option>
            <option value="movies">Movies</option>
            <option value="tv">TV Shows</option>
            <option value="music">Music</option>
            <option value="buzz">Buzz</option>
            <option value="style">Style</option>
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
      <div id="filterEmpty" class="filter-empty">No stories match your current search and filter combination.</div>

      <div class="page-layout">
        <div class="main-content">

          <!-- HERO -->
          <a href="article-cinema-renaissance.php" class="card-link">
            <article class="hero-article filter-item" data-category="movies" data-date="2026-02-22" data-search="cinema renaissance directors fourth wall 70mm AI film festival Elena Thorne movies entertainment 2026">
              <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?w=1200&auto=format&fit=crop" alt="Cinema Renaissance">
              </div>
              <span class="hero-category">Movies</span>
              <h1 class="hero-title">The Renaissance of Cinema: 2026's Boldest Directors</h1>
              <p class="hero-excerpt">2026's cinema renaissance is being driven by bold directors like Paul Thomas Anderson and Ryan Coogler alongside rising global voices such as Bi Gan, blending innovation with powerful storytelling. Together, they're redefining film through diverse perspectives, experimental styles, and stories that resonate across cultures.</p>
              <div class="hero-meta">
                <span class="hero-author">Elena Thorne</span> • March 18, 2026
              </div>
            </article>
          </a>

          <!-- LATEST NEWS -->
          <section>
            <div class="section-header">
              <h2 class="section-title">Latest News</h2>
            </div>
            <div class="news-grid">

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="music" data-date="2026-03-15" data-search="Coachella 2026 lineup festival music live J. Rivera entertainment">
                  <div class="news-card-image">
                    <img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=600&auto=format&fit=crop" alt="Coachella">
                  </div>
                  <span class="news-card-category">Music</span>
                  <h3 class="news-card-title">Coachella 2026 Lineup Leaked</h3>
                  <p class="news-card-excerpt">The leaked Coachella lineup has fans speculating about the festival's headliners and surprise collaborations. The early reveal stirs excitement and debate, showing how anticipation drives engagement in live music culture.</p>
                  <div class="news-card-meta">J. Rivera • March 15, 2026</div>
                </article>
              </a>

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="tv" data-date="2026-03-12" data-search="streaming cancels show controversy TV T.Cook entertainment 2026">
                  <div class="news-card-image">
                    <img src="https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?w=600&auto=format&fit=crop" alt="Streaming">
                  </div>
                  <span class="news-card-category">TV</span>
                  <h3 class="news-card-title">Streaming Giant Cancels Top-Rated Show</h3>
                  <p class="news-card-excerpt">The cancellation of the hit series highlights tensions between audience demand and business strategies. Fans are frustrated as metrics-driven decisions override creative success, sparking discussions on how streaming platforms value content.</p>
                  <div class="news-card-meta">T. Cook • March 12, 2026</div>
                </article>
              </a>

              <a href="article-cinema-renaissance.php" class="card-link">
                <article class="news-card filter-item" data-category="movies" data-date="2026-03-12" data-search="35mm projection film analog cinema A.Varda movies entertainment 2026">
                  <div class="news-card-image">
                    <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=600&auto=format&fit=crop" alt="35mm Film">
                  </div>
                  <span class="news-card-category">Movies</span>
                  <h3 class="news-card-title">The Return of 35mm Projection</h3>
                  <p class="news-card-excerpt">The revival of 35mm projection celebrates the tactile artistry of film. Audiences enjoy a more authentic cinematic experience, emphasizing nostalgia and craftsmanship in an era of digital dominance.</p>
                  <div class="news-card-meta">A. Varda • March 12, 2026</div>
                </article>
              </a>

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="tv" data-date="2026-03-10" data-search="UrbanStream price hike streaming subscription TV staff entertainment 2026">
                  <div class="news-card-image">
                    <img src="https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=600&auto=format&fit=crop" alt="Streaming Platform">
                  </div>
                  <span class="news-card-category">TV</span>
                  <h3 class="news-card-title">UrbanStream+ Price Hike</h3>
                  <p class="news-card-excerpt">UrbanStream's price hike reflects the challenges of balancing rising production costs with customer retention. The move has fueled debate about subscription value, showing how pricing changes impact streaming loyalty.</p>
                  <div class="news-card-meta">Staff • March 10, 2026</div>
                </article>
              </a>

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="buzz" data-date="2026-03-14" data-search="interactive theatre Shakespeare immersive stage W.Shake buzz entertainment 2026">
                  <div class="news-card-image">
                    <img src="https://images.unsplash.com/photo-1503095396549-807759245b35?w=600&auto=format&fit=crop" alt="Theatre">
                  </div>
                  <span class="news-card-category">Buzz</span>
                  <h3 class="news-card-title">Interactive Theatre: New Shakespeare</h3>
                  <p class="news-card-excerpt">Interactive Shakespeare blends classic storytelling with audience participation, creating a dynamic theatrical experience. This approach revitalizes theatre by making viewers part of the narrative, merging tradition with innovation.</p>
                  <div class="news-card-meta">W. Shake • March 14, 2026</div>
                </article>
              </a>

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="music" data-date="2026-03-06" data-search="Coachella VR meta festival virtual reality music Z.G entertainment 2026">
                  <div class="news-card-image">
                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&auto=format&fit=crop" alt="VR Festival">
                  </div>
                  <span class="news-card-category">Music</span>
                  <h3 class="news-card-title">Meta-Festival: Coachella VR</h3>
                  <p class="news-card-excerpt">The Coachella VR festival expands access to live music, letting audiences participate from anywhere. Virtual reality brings immersive performances to fans, blending technology with traditional festival culture.</p>
                  <div class="news-card-meta">Z. G • March 06, 2026</div>
                </article>
              </a>

            </div>
          </section>

          <!-- POP CULTURE BUZZ -->
          <section class="mt-5">
            <div class="section-header">
              <h2 class="section-title">Pop Culture Buzz</h2>
            </div>
            <div class="trending-bottom-grid">
              <div class="trending-bottom-item filter-item" data-category="movies" data-date="2026-03-18" data-search="Oscars 2026 highlights awards movies film critic entertainment">
                <span class="item-category">Movies</span>
                <h3 class="sidebar-title">Oscars 2026 Highlights</h3>
                <div class="item-meta">Film Critic • March 18, 2026</div>
              </div>
              <div class="trending-bottom-item filter-item" data-category="style" data-date="2026-03-17" data-search="neon green trend style fashion runway entertainment Style Watch">
                <span class="item-category">Style</span>
                <h3 class="sidebar-title">The Neon Green Trend</h3>
                <div class="item-meta">Style Watch • March 17, 2026</div>
              </div>
              <div class="trending-bottom-item filter-item" data-category="buzz" data-date="2026-03-16" data-search="next gen console specs gaming technology buzz Gamer Hub entertainment">
                <span class="item-category">Buzz</span>
                <h3 class="sidebar-title">Next-Gen Console Specs</h3>
                <div class="item-meta">Gamer Hub • March 16, 2026</div>
              </div>
              <div class="trending-bottom-item filter-item" data-category="buzz" data-date="2026-03-07" data-search="smart glasses screen technology K.Jobs buzz entertainment 2026">
                <span class="item-category">Buzz</span>
                <h3 class="sidebar-title">Smart Glasses as New Screen</h3>
                <div class="item-meta">K. Jobs • March 07, 2026</div>
              </div>
              <div class="trending-bottom-item filter-item" data-category="music" data-date="2026-03-14" data-search="global top 50 tracks music entertainment Urban Beats charts 2026">
                <span class="item-category">Music</span>
                <h3 class="sidebar-title">Global Top 50 Tracks</h3>
                <div class="item-meta">Urban Beats • March 14, 2026</div>
              </div>
            </div>
          </section>

        </div>

        <!-- SIDEBAR -->
        <aside class="sidebar">
          <section class="sidebar-section">
            <h2 class="sidebar-heading">Trending Now</h2>
            <div class="sidebar-stories">
              <div class="sidebar-story">
                <span class="sidebar-category">Celeb</span>
                <h3 class="sidebar-title">Secret Bali Wedding Rumors</h3>
                <div class="sidebar-meta">Rumor Mill • March 18, 2026</div>
              </div>
              <div class="sidebar-story">
                <span class="sidebar-category">Box Office</span>
                <h3 class="sidebar-title">Indie Film Breaks Records</h3>
                <div class="sidebar-meta">Cinema Data • March 13, 2026</div>
              </div>
            </div>
          </section>
          <section class="sidebar-section mt-4">
            <h2 class="sidebar-heading">Editor's Pick</h2>
            <div class="sidebar-stories">
              <div class="sidebar-story">
                <span class="sidebar-category">Movies</span>
                <h3 class="sidebar-title">The Future of 70mm</h3>
                <div class="sidebar-meta">A. Varda • March 19, 2026</div>
              </div>
            </div>
          </section>
        </aside>

      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-content">
        <div class="footer-section">
          <h3>UrbanPulse</h3>
          <p>Independent journalism you can trust. Delivering truth in every story since 2026.</p>
          <div class="footer-social">
            <a href="#" aria-label="Facebook">FB</a>
            <a href="#" aria-label="Twitter">TW</a>
            <a href="#" aria-label="Instagram">IG</a>
            <a href="#" aria-label="Github">GH</a>
          </div>
        </div>
        <div class="footer-section">
          <h4>Categories</h4>
          <ul>
            <li><a href="technology.php">Technology</a></li>
            <li><a href="sports.php">Sports</a></li>
            <li><a href="entertainment.php">Entertainment</a></li>
            <li><a href="worldnews.php">World News</a></li>
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
          <p>We, the UrbanPulse team, pledge to deliver news that keeps people informed, aware, and always updated. Inspired by our school's champion radio broadcasting team, we carry the same goal: to share information clearly, quickly, and with purpose.</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2026 UrbanPulse News. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- BURGER -->
  <div class="menu-overlay" id="menuOverlay" hidden></div>
  <aside class="burger-menu" id="burgerMenu" aria-hidden="true" aria-label="Site menu" inert>
    <div class="burger-top">
      <button type="button" class="menu-close" id="menuClose" aria-label="Close menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M18 6 6 18"></path><path d="M6 6l12 12"></path>
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
          <a class="burger-link" data-nav href="technology.php">Technology</a>
          <a class="burger-link" data-nav href="sports.php">Sports</a>
          <a class="burger-link" data-nav href="entertainment.php">Entertainment</a>
          <a class="burger-link" data-nav href="worldnews.php">World News</a>
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
          <a class="account-register" href="#">Register</a>
        </div>
        <a class="burger-cta" href="Login.php">SIGN IN</a>
        <a class="burger-support" href="#">Support</a>
      </div>
    </div>
  </aside>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="burger.js"></script>
  <script src="search.js"></script>
  <script src="filter.js"></script>
</body>
</html>