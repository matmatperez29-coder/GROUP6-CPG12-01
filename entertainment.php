<?php
require_once 'db.php';
require_once 'auth.php';
$currentUser = getCurrentUser();
?>
<?php $pageId = 'entertainment'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>UrbanPulse | Entertainment</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script>
    (function () {
      try {
        if (localStorage.getItem('up_theme') === 'dark') {
          document.documentElement.setAttribute('data-theme', 'dark');
        }
      } catch (error) {}
    })();
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="navfooter.css">
  <link rel="stylesheet" href="technology.css">
  <link rel="stylesheet" href="burgermenu.css">
  <link rel="stylesheet" href="theme.css">
  <link rel="stylesheet" href="pulse-features.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
  <style>
    .active { color: #c8102e; text-decoration: underline; text-decoration-color: #c8102e; text-decoration-thickness: 1.5px; }
    #searchBox:empty::before { content: attr(data-placeholder); color: #aaa; font-style: italic; pointer-events: none; }
    #searchBox:focus { outline: none; }
    #searchBox::-webkit-scrollbar { display: none; }
    .search-bar-inner { display: flex !important; align-items: center !important; gap: 1rem !important; padding: 0.85rem 2rem !important; width: 100% !important; background: #fff !important; }

    a.card-link { display: block; text-decoration: none; color: inherit; }
    a.card-link:hover .news-card { box-shadow: 0 6px 20px rgba(0,0,0,.13); transform: translateY(-3px); }
    a.card-link:hover .news-card-title,
    a.card-link:hover .hero-title { color: var(--color-secondary, #c8102e); }
    .news-card { transition: box-shadow .2s, transform .2s; }

    .news-card-image { overflow: hidden; border-radius: 6px; width: 100%; aspect-ratio: 16/9; }
    .news-card-image img, .hero-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hero-image { overflow: hidden; border-radius: 8px; width: 100%; aspect-ratio: 16/9; margin-bottom: 1.25rem; }

    .hero-article { padding-bottom: 1.4rem; border-bottom: 1px solid var(--color-border, #e0e0e0); margin-bottom: 2rem; }
    .hero-category {
      display: inline-flex; align-items: center;
      background: rgba(200,16,46,0.09); color: var(--color-secondary, #c8102e);
      border-radius: 999px; padding: 0.35rem 0.75rem;
      font-size: 0.72rem; font-weight: 800; letter-spacing: 0.8px;
      text-transform: uppercase; margin-bottom: 0.85rem;
    }
    .hero-title {
      font-family: var(--font-display, 'Playfair Display', serif);
      font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 700;
      line-height: 1.1; color: var(--color-primary, #1a1a1a); margin-bottom: 0.85rem;
    }
    .hero-excerpt { font-size: 1rem; line-height: 1.75; color: var(--color-text, #2d2d2d); margin-bottom: 0.85rem; }
    .hero-meta { font-size: 0.86rem; color: var(--color-text-light, #666); }
    .hero-author { font-weight: 700; color: var(--color-primary, #1a1a1a); }

    .news-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1.5rem; }
    .news-card { display: flex; flex-direction: column; border-bottom: 1px solid var(--color-border, #e0e0e0); padding-bottom: 1.25rem; }
    .news-card-category {
      display: inline-flex; background: rgba(200,16,46,0.09); color: var(--color-secondary, #c8102e);
      border-radius: 999px; padding: 0.3rem 0.65rem;
      font-size: 0.68rem; font-weight: 800; letter-spacing: 0.8px;
      text-transform: uppercase; margin: 0.75rem 0 0.5rem;
    }
    .news-card-title {
      font-family: var(--font-display, 'Playfair Display', serif);
      font-size: 1.15rem; font-weight: 700; line-height: 1.25;
      color: var(--color-primary, #1a1a1a); margin-bottom: 0.55rem; transition: color .2s;
    }
    .news-card-excerpt { font-size: 0.9rem; line-height: 1.65; color: var(--color-text, #2d2d2d); margin-bottom: 0.65rem; flex: 1; }
    .news-card-meta { font-size: 0.82rem; color: var(--color-text-light, #666); margin-top: auto; }

    .trending-bottom-grid { display: flex; flex-direction: column; }
    .trending-bottom-item { padding: 1rem 0; border-bottom: 1px solid var(--color-border, #e0e0e0); }
    .trending-bottom-item:last-child { border-bottom: none; }
    .item-category {
      display: inline-block; font-size: 0.72rem; font-weight: 800;
      letter-spacing: 0.8px; text-transform: uppercase;
      color: var(--color-secondary, #c8102e); margin-bottom: 0.35rem;
    }
    .item-meta { font-size: 0.82rem; color: var(--color-text-light, #666); margin-top: 0.25rem; }

    .page-layout { display: grid; grid-template-columns: minmax(0, 1fr) 300px; gap: 2rem; }
    .sidebar { position: sticky; top: 110px; align-self: start; display: flex; flex-direction: column; gap: 1.5rem; }
    .sidebar-section { border-top: 3px solid var(--color-secondary, #c8102e); padding-top: 1rem; }
    .sidebar-heading { font-family: var(--font-display, 'Playfair Display', serif); font-size: 1.15rem; font-weight: 700; color: var(--color-primary, #1a1a1a); margin-bottom: 1rem; }
    .sidebar-story { padding: 0.9rem 0; border-bottom: 1px solid var(--color-border, #e0e0e0); }
    .sidebar-story:first-child { padding-top: 0; }
    .sidebar-story:last-child { border-bottom: none; }
    .sidebar-category {
      display: inline-block; font-size: 0.68rem; font-weight: 800;
      letter-spacing: 0.8px; text-transform: uppercase;
      color: var(--color-secondary, #c8102e); margin-bottom: 0.3rem;
    }
    .sidebar-title { font-family: var(--font-display, 'Playfair Display', serif); font-size: 1rem; font-weight: 700; color: var(--color-primary, #1a1a1a); margin: 0 0 0.35rem; line-height: 1.3; }
    .sidebar-meta { font-size: 0.8rem; color: var(--color-text-light, #666); }

    @media (max-width: 1100px) { .page-layout { grid-template-columns: 1fr; } .sidebar { position: static; } }
    @media (max-width: 760px) { .news-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 480px) { .news-grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body data-page="<?php echo htmlspecialchars($pageId, ENT_QUOTES, 'UTF-8'); ?>">

  <?php require_once 'nav.php'; ?>

  <main>
    <div class="container">

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
            <a href="article-cinema-renaissance.php" class="card-link"><article class="hero-article filter-item" data-category="movies" data-date="2026-02-22"
              data-search="cinema renaissance directors fourth wall 70mm AI film festival Elena Thorne movies entertainment 2026">
              <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?w=1200&auto=format&fit=crop" alt="Cinema Renaissance" loading="lazy">
              </div>
              <span class="hero-category">Movies</span>
              <h1 class="hero-title">The Renaissance of Cinema: 2026's Boldest Directors</h1>
              <p class="hero-excerpt">2026's cinema renaissance is being driven by bold directors like Paul Thomas Anderson and Ryan Coogler alongside rising global voices such as Bi Gan, blending innovation with powerful storytelling. Together, they're redefining film through diverse perspectives, experimental styles, and stories that resonate across cultures.</p>
              <div class="hero-meta">
                <span class="hero-author">Elena Thorne</span> • March 18, 2026
              </div>
            </article></a>
          </a>

          <!-- LATEST NEWS -->
          <section data-filter-section>
            <div class="section-header" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;padding-bottom:0.9rem;border-bottom:2px solid var(--color-border,#e0e0e0);">
              <h2 style="margin:0;font-family:var(--font-display,'Playfair Display',serif);font-size:clamp(1.4rem,2vw,1.95rem);color:var(--color-primary,#1a1a1a);">Latest News</h2>
            </div>
            <div class="news-grid">

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="music" data-date="2026-03-15" data-search="Coachella 2026 lineup festival music live J. Rivera entertainment">
                  <div class="news-card-image"><img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=600&auto=format&fit=crop" alt="Coachella" loading="lazy"></div>
                  <span class="news-card-category">Music</span>
                  <h3 class="news-card-title">Coachella 2026 Lineup Leaked</h3>
                  <p class="news-card-excerpt">The leaked Coachella lineup has fans speculating about headliners and surprise collaborations, showing how anticipation drives engagement in live music culture.</p>
                  <div class="news-card-meta">J. Rivera • March 15, 2026</div>
                </article>
              </a>

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="tv" data-date="2026-03-12" data-search="streaming cancels show controversy TV T.Cook entertainment 2026">
                  <div class="news-card-image"><img src="https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?w=600&auto=format&fit=crop" alt="Streaming" loading="lazy"></div>
                  <span class="news-card-category">TV</span>
                  <h3 class="news-card-title">Streaming Giant Cancels Top-Rated Show</h3>
                  <p class="news-card-excerpt">Fans are frustrated as metrics-driven decisions override creative success, sparking debate on how streaming platforms value content.</p>
                  <div class="news-card-meta">T. Cook • March 12, 2026</div>
                </article>
              </a>

              <a href="article-cinema-renaissance.php" class="card-link">
                <a href="article-cinema-renaissance.php" class="card-link"><article class="news-card filter-item" data-category="movies" data-date="2026-03-12" data-search="35mm projection film analog cinema A.Varda movies entertainment 2026">
                  <div class="news-card-image"><img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=600&auto=format&fit=crop" alt="35mm Film" loading="lazy"></div>
                  <span class="news-card-category">Movies</span>
                  <h3 class="news-card-title">The Return of 35mm Projection</h3>
                  <p class="news-card-excerpt">The revival of 35mm celebrates the tactile artistry of film, emphasizing nostalgia and craftsmanship in an era of digital dominance.</p>
                  <div class="news-card-meta">A. Varda • March 12, 2026</div>
                </article></a>
              </a>

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="tv" data-date="2026-03-10" data-search="UrbanStream price hike streaming subscription TV staff entertainment 2026">
                  <div class="news-card-image"><img src="https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=600&auto=format&fit=crop" alt="Streaming Platform" loading="lazy"></div>
                  <span class="news-card-category">TV</span>
                  <h3 class="news-card-title">UrbanStream+ Price Hike</h3>
                  <p class="news-card-excerpt">The move fueled debate about subscription value, showing how pricing changes impact streaming loyalty and subscriber retention.</p>
                  <div class="news-card-meta">Staff • March 10, 2026</div>
                </article>
              </a>

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="buzz" data-date="2026-03-14" data-search="interactive theatre Shakespeare immersive stage W.Shake buzz entertainment 2026">
                  <div class="news-card-image"><img src="https://images.unsplash.com/photo-1503095396549-807759245b35?w=600&auto=format&fit=crop" alt="Theatre" loading="lazy"></div>
                  <span class="news-card-category">Buzz</span>
                  <h3 class="news-card-title">Interactive Theatre: New Shakespeare</h3>
                  <p class="news-card-excerpt">Interactive Shakespeare blends classic storytelling with audience participation, revitalizing theatre by making viewers part of the narrative.</p>
                  <div class="news-card-meta">W. Shake • March 14, 2026</div>
                </article>
              </a>

              <a href="#" class="card-link">
                <article class="news-card filter-item" data-category="music" data-date="2026-03-06" data-search="Coachella VR meta festival virtual reality music Z.G entertainment 2026">
                  <div class="news-card-image"><img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&auto=format&fit=crop" alt="VR Festival" loading="lazy"></div>
                  <span class="news-card-category">Music</span>
                  <h3 class="news-card-title">Meta-Festival: Coachella VR</h3>
                  <p class="news-card-excerpt">Virtual reality brings immersive performances to fans everywhere, blending technology with traditional festival culture.</p>
                  <div class="news-card-meta">Z. G • March 06, 2026</div>
                </article>
              </a>

            </div>
          </section>

          <div class="section-divider"></div>

          <!-- POP CULTURE BUZZ -->
          <section data-filter-section>
            <div class="section-header" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;padding-bottom:0.9rem;border-bottom:2px solid var(--color-border,#e0e0e0);">
              <h2 style="margin:0;font-family:var(--font-display,'Playfair Display',serif);font-size:clamp(1.4rem,2vw,1.95rem);color:var(--color-primary,#1a1a1a);">Pop Culture Buzz</h2>
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
            <h3 class="sidebar-heading">Trending Now</h3>
            <div>
              <div class="sidebar-story">
                <span class="sidebar-category">Celebrity</span>
                <h4 class="sidebar-title">Secret Bali Wedding Rumors</h4>
                <div class="sidebar-meta">Rumor Mill • March 18, 2026</div>
              </div>
              <div class="sidebar-story">
                <span class="sidebar-category">Box Office</span>
                <h4 class="sidebar-title">Indie Film Breaks Records</h4>
                <div class="sidebar-meta">Cinema Data • March 13, 2026</div>
              </div>
            </div>
          </section>
          <section class="sidebar-section">
            <h3 class="sidebar-heading">Editor's Pick</h3>
            <div>
              <div class="sidebar-story">
                <span class="sidebar-category">Movies</span>
                <h4 class="sidebar-title">The Future of 70mm</h4>
                <div class="sidebar-meta">A. Varda • March 19, 2026</div>
              </div>
            </div>
          </section>
          <div style="background:linear-gradient(135deg,#111,#232323);color:white;border-radius:20px;padding:1.5rem;">
            <div style="font-size:.72rem;letter-spacing:1px;opacity:.75;margin-bottom:.75rem;text-transform:uppercase;">Inside Entertainment</div>
            <h4 style="margin:0 0 .5rem;font-family:var(--font-display,'Playfair Display',serif);font-size:1.2rem;">Stay ahead of the culture</h4>
            <p style="margin:0;line-height:1.7;color:rgba(255,255,255,0.8);font-size:.9rem;">From box office to buzz, we cover it all.</p>
          </div>
        </aside>

      </div>
    </div>
  </main>

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
          <p id="pledge">We, the UrbanPulse team, pledge to deliver news that keeps people informed, aware, and always updated. Inspired by our school's champion radio broadcasting team, we carry the same goal: to share information clearly, quickly, and with purpose.</p>
        </div>
      </div>
      <div class="footer-bottom"><p>&copy; 2026 UrbanPulse News. All rights reserved.</p></div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="burger.js"></script>
  <script src="theme.js"></script>
  <script src="search.js"></script>
  <script src="interactions.js"></script>
  <script src="pulse-features.js"></script>
  <script src="editorial-tools.js"></script>
</body>
</html>