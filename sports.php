<?php $pageId = 'sports'; ?>
<!DOCTYPE html>
<html>
<head>
    <title> UrbanPulse | Sports Page </title>
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
    <link rel="stylesheet" href="sports.css">
    <link rel="stylesheet" href="burgermenu.css">
    <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">

    <style>
      .active {
        color: #c8102e;
        text-decoration-color: #c8102e;
        text-decoration: underline;
        text-decoration-thickness: 1.5px;
      }
    </style>

    <link rel="stylesheet" href="theme.css">
    <link rel="stylesheet" href="pulse-features.css">
</head>
<body data-page="<?php echo htmlspecialchars($pageId, ENT_QUOTES, 'UTF-8'); ?>">

	<!-- BREAKING NEWS STICKER -->
	<div class="BreakingNews">
		<span class="BreakingNewsLabel"> Breaking News </span>
		<div class="BreakingNewsContent">
			<span class="BreakingNewsItem">UMak HSU Filipino Radio Broadcasting Won Championship in DSPC</span>
            <span class="BreakingNewsItem">UMak HSU English Radio Broadcasting placed 2nd in DSPC</span>
            <span class="BreakingNewsItem">UMak HSU Filipibo RB will be fighting in RSPC NCR</span>
			<span class="BreakingNewsItem">UMak HSU Filipino Radio Broadcasting Won Championship in DSPC</span>
            <span class="BreakingNewsItem">UMak HSU English Radio Broadcasting placed 2nd in DSPC</span>
            <span class="BreakingNewsItem">UMak HSU Filipibo RB will be fighting in RSPC NCR</span>
		</div>
	</div>



<!-- NAVIGATION BAR -->
<header class="header-main">
  <div class="header-container">
    <!-- LEFT: Burger + Logo -->
    <div class="header-left">
      <button
        type="button"
        class="menu-toggle"
        id="menuToggle"
        aria-label="Open menu"
        aria-controls="burgerMenu"
        aria-expanded="false"
      >
        <span class="burger-icon" aria-hidden="true"
          ><span></span><span></span><span></span
        ></span>
      </button>
      <!-- LOGO & TAGLINE -->
      <span class="header-logo">
        <h1>UrbanPulse</h1>
        <p class="header-logo-tagline">Feel the Ripple!</p>
      </span>
    </div>

    <!-- CENTER: Navigation -->
    <nav class="main-nav">
      <a href="home.php"> Home </a>
      <a href="technology.php"> Technology </a>
      <a href="sports.php" class="active"> Sports </a>
      <a href="entertainment.php"> Entertainment </a>
      <a href="worldnews.php"> World News</a>
    </nav>

    <!-- RIGHT: Search + Login + Subscribe -->
    <div class="header-right">
      <!-- Search icon only -->
      <button class="search-toggle" id="searchToggle" aria-label="Open search" aria-expanded="false">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"></circle>
          <path d="m21 21-4.35-4.35"></path>
        </svg>
      </button>
      <button class="pulse-alert-trigger" id="pulseAlertToggle" type="button" aria-label="Open UrbanPulse alerts">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"></path>
          <path d="M10 21a2 2 0 0 0 4 0"></path>
        </svg>
        <span class="pulse-alert-badge" id="pulseAlertBadge" hidden>0</span>
      </button>
          <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch to dark mode" aria-pressed="false" title="Toggle light and dark mode">
            <span class="theme-toggle-track" aria-hidden="true">
              <span class="theme-toggle-icon theme-toggle-sun">☀</span>
              <span class="theme-toggle-thumb"></span>
              <span class="theme-toggle-icon theme-toggle-moon">☾</span>
            </span>
          </button>

      <span class="header-right-divider"></span>
      <div class="header-login">
        <a href="login.php" target="_blank">
          <img src="IMAGES/usericon.png" alt="User" width="24" height="24" />
        </a>
      </div>
      <span class="header-right-divider"></span>
      <div class="header-subscription">
        <a href="subscription.php"><strong>Subscribe</strong></a>
      </div>
    </div>
  </div>
</header>



    <main>
        <div class="container">
            <section class="page-intro">
                <div>
                    <span class="page-kicker">UrbanPulse Sports Desk</span>
                    <h1 class="page-title">Big wins, defining moments, and the stories behind the scorelines</h1>
                    <p class="page-description">This page now uses the sports stories from your PDF and turns them into a cleaner category page with working search, filters, read more and less, and comments. Every image area is left ready for your manual upload.</p>
                </div>
                <div class="page-stamp">Updated from your PDF content</div>
            </section>

            <section class="tools-bar" aria-label="Sports tools">
                <div class="tools-field">
                    <label class="tools-label" for="articleSearch">Search stories</label>
                    <input class="tools-input" type="search" id="articleSearch" placeholder="Search by team, player, event, or keyword">
                </div>
                <div class="tools-field">
                    <label class="tools-label" for="categoryFilter">Filter by sport</label>
                    <select class="tools-select" id="categoryFilter">
                        <option value="all">All sports</option>
                        <option value="football">American Football</option>
                        <option value="basketball">Basketball</option>
                        <option value="soccer">Football / Soccer</option>
                        <option value="tennis">Tennis</option>
                        <option value="baseball">Baseball</option>
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

<?php include __DIR__ . '/includes/editorial-tools.php'; ?>

            <div id="filterEmpty" class="filter-empty">No sports stories match your current search and filter combination.</div>

            <section class="hero-featured" data-filter-section>
                <a href="article-eagles-super-bowl.php" class="card-link"><article class="hero-main filter-item" data-category="football" data-date="2025-02-09" data-search="Eagles Chiefs Super Bowl LIX Jalen Hurts Patrick Mahomes Cooper DeJean Marcus Thompson football NFL title">
                    <div class="media-slot hero-image"><span>Hero image slot</span><small>Insert 16:9 Eagles vs Chiefs image</small></div>
                    <span class="hero-category">American Football</span>
                    <h2 class="hero-title">Eagles Dethrone Chiefs to Claim Super Bowl LIX Title</h2>
                    <p class="hero-excerpt">Philadelphia overwhelmed Kansas City 40-22 at the Caesars Superdome and denied Patrick Mahomes a three-peat. The defense set the tone with six sacks and three takeaways while Jalen Hurts led the offense to a statement win.</p>
                    <div id="sportsHeroMore" class="read-more-content" hidden>
                        <p class="hero-copy">Rookie Cooper DeJean delivered one of the signature plays of the night with a 38-yard pick-six, becoming only the second rookie to do it on the Super Bowl stage. Hurts added nearly 300 passing yards and two rushing touchdowns, including the trademark tush push that helped seal the result.</p>
                        <p class="hero-copy">The championship gave Philadelphia its second title and served as redemption for the franchise after falling to Kansas City in Super Bowl LVII.</p>
                    </div>
                    <button class="read-more-btn" type="button" data-read-more="sportsHeroMore" aria-expanded="false">Read more</button>
                    <div class="hero-meta">
                        <span class="hero-author">Marcus Thompson</span>
                        <span>•</span>
                        <span>February 9, 2025</span>
                        <span>•</span>
                        <span>6:30 PM EST</span>
                    </div>
                </article></a>

                <aside class="hero-sidebar">
                    <article class="sidebar-story filter-item" data-category="basketball" data-date="2025-06-22" data-search="Thunder OKC NBA Finals Gilgeous-Alexander Holmgren Haliburton Sarah Jenkins basketball championship">
                        <span class="sidebar-category">Basketball</span>
                        <h3 class="sidebar-title">Thunder Strike Gold with OKC's First NBA Title Since 1979</h3>
                        <div class="sidebar-meta"><span>Sarah Jenkins</span><span>•</span><span>June 22, 2025</span></div>
                    </article>
                    <article class="sidebar-story filter-item" data-category="soccer" data-date="2025-05-31" data-search="PSG Champions League Inter Milan treble Luis Enrique James Pratt soccer football UCL">
                        <span class="sidebar-category">Football / Soccer</span>
                        <h3 class="sidebar-title">PSG Complete a Historic Treble with a Ruthless 5-0 Final</h3>
                        <div class="sidebar-meta"><span>James Pratt</span><span>•</span><span>May 31, 2025</span></div>
                    </article>
                    <a href="article-wimbledon.php" class="card-link"><article class="sidebar-story filter-item" data-category="tennis" data-date="2025-07-13" data-search="Wimbledon Sinner Swiatek Carlos Alcaraz Amanda Anisimova Elena Costas tennis finals">
                        <span class="sidebar-category">Tennis</span>
                        <h3 class="sidebar-title">Sinner and Swiatek Own the Wimbledon Spotlight</h3>
                        <div class="sidebar-meta"><span>Elena Costas</span><span>•</span><span>July 13, 2025</span></div>
                    </article></a>
                    <article class="sidebar-story filter-item" data-category="baseball" data-date="2025-11-02" data-search="Dodgers Blue Jays World Series Ohtani Yamamoto David Sutherland baseball back to back titles">
                        <span class="sidebar-category">Baseball</span>
                        <h3 class="sidebar-title">Dodgers Go Back-to-Back in an 11-Inning World Series Thriller</h3>
                        <div class="sidebar-meta"><span>David Sutherland</span><span>•</span><span>November 2, 2025</span></div>
                    </article>
                </aside>
            </section>

            <div class="section-divider"></div>

            <section data-filter-section>
                <div class="section-header">
                    <h2 class="section-title">Fast scoreboard snapshot</h2>
                    <span class="section-link">Season-defining headlines</span>
                </div>
                <div class="quick-stats">
                    <div class="stat-card filter-item" data-category="football" data-date="2025-02-09" data-search="40-22 Eagles Chiefs Super Bowl score">
                        <strong>40-22</strong>
                        <span>Eagles over Chiefs in Super Bowl LIX</span>
                    </div>
                    <div class="stat-card filter-item" data-category="basketball" data-date="2025-06-22" data-search="103-91 Thunder Pacers Game 7 NBA finals score">
                        <strong>103-91</strong>
                        <span>Thunder over Pacers in Game 7</span>
                    </div>
                    <div class="stat-card filter-item" data-category="soccer" data-date="2025-05-31" data-search="5-0 PSG Inter Milan Champions League final score">
                        <strong>5-0</strong>
                        <span>PSG rout Inter Milan in the UCL final</span>
                    </div>
                    <div class="stat-card filter-item" data-category="tennis" data-date="2025-07-13" data-search="6-0 6-0 Swiatek Wimbledon final score double bagel">
                        <strong>6-0, 6-0</strong>
                        <span>Swiatek's historic Wimbledon final</span>
                    </div>
                </div>
            </section>

            <div class="section-divider"></div>

            <section data-filter-section>
                <div class="section-header">
                    <h2 class="section-title">Latest stories</h2>
                    <span class="section-link">Card layout</span>
                </div>
                <div class="story-grid">
                    <article class="story-card filter-item" data-category="basketball" data-date="2025-06-22" data-search="Thunder OKC NBA title Gilgeous-Alexander Holmgren Jalen Williams Pacers basketball">
                        <div class="media-slot story-image"><span>Image slot</span><small>Insert OKC title celebration image</small></div>
                        <span class="story-pill">Basketball</span>
                        <h3 class="story-title">Thunder Strike Gold: OKC Wins Its First NBA Title Since 1979</h3>
                        <p class="story-excerpt">Shai Gilgeous-Alexander powered Oklahoma City to a 103-91 Game 7 win over Indiana and capped an unforgettable season with MVP and Finals MVP honors.</p>
                        <div id="sportsCard1" class="read-more-content" hidden><p class="sport-copy">After Tyrese Haliburton went down early in the third quarter, OKC ripped off a 19-2 run. Chet Holmgren's rim protection and Jalen Williams' scoring helped secure the Larry O'Brien Trophy.</p></div>
                        <button class="read-more-btn" type="button" data-read-more="sportsCard1" aria-expanded="false">Read more</button>
                        <div class="story-meta"><span class="story-author">Sarah Jenkins</span><span>•</span><span>June 22, 2025</span></div>
                    </article>
                    <article class="story-card filter-item" data-category="soccer" data-date="2025-05-31" data-search="PSG treble Champions League Inter Milan Doue Hakimi Kvaratskhelia soccer football">
                        <div class="media-slot story-image"><span>Image slot</span><small>Insert PSG trophy lift image</small></div>
                        <span class="story-pill">Football / Soccer</span>
                        <h3 class="story-title">PSG Secure a Maiden Champions League and Complete the Treble</h3>
                        <p class="story-excerpt">Paris Saint-Germain crushed Inter Milan 5-0 in Munich and became the first French club to complete a continental treble.</p>
                        <div id="sportsCard2" class="read-more-content" hidden><p class="sport-copy">Désiré Doué scored twice while Achraf Hakimi, Khvicha Kvaratskhelia, and Senny Mayulu added goals in the most lopsided single-leg Champions League final on record.</p></div>
                        <button class="read-more-btn" type="button" data-read-more="sportsCard2" aria-expanded="false">Read more</button>
                        <div class="story-meta"><span class="story-author">James Pratt</span><span>•</span><span>May 31, 2025</span></div>
                    </article>
                    <a href="article-wimbledon.php" class="card-link"><article class="story-card filter-item" data-category="tennis" data-date="2025-07-13" data-search="Sinner Swiatek Wimbledon Alcaraz Anisimova tennis grass Elena Costas">
                        <div class="media-slot story-image"><span>Image slot</span><small>Insert Wimbledon finals image</small></div>
                        <span class="story-pill">Tennis</span>
                        <h3 class="story-title">Sinner and Swiatek Dominate Historic Wimbledon Finals</h3>
                        <p class="story-excerpt">Jannik Sinner outlasted Carlos Alcaraz, while Iga Swiatek delivered a rare double-bagel final to win her first Wimbledon crown.</p>
                        <div id="sportsCard3" class="read-more-content" hidden><p class="sport-copy">Sinner stopped Alcaraz's 20-match grass winning streak, and Swiatek's 6-0, 6-0 victory became the first double-bagel Grand Slam final since 1988.</p></div>
                        <button class="read-more-btn" type="button" data-read-more="sportsCard3" aria-expanded="false">Read more</button>
                        <div class="story-meta"><span class="story-author">Elena Costas</span><span>•</span><span>July 13, 2025</span></div>
                    </article></a>
                </div>
            </section>

            <div class="section-divider"></div>

            <section class="sport-section" data-filter-section>
                <div class="sport-header">
                    <h2 class="sport-title">Championship spotlight</h2>
                    <span class="section-link">Longer reads</span>
                </div>
                <div class="sport-grid">
                    <article class="sport-main filter-item" data-category="baseball" data-date="2025-11-02" data-search="Dodgers Blue Jays World Series Ohtani Rojas Will Smith Yamamoto baseball">
                        <div class="media-slot sport-main-image"><span>Feature image slot</span><small>Insert Dodgers World Series image</small></div>
                        <span class="story-pill">Baseball</span>
                        <h3 class="sport-main-title">Dodger Dynasty: L.A. Clinches Back-to-Back Titles in an 11-Inning Classic</h3>
                        <p class="sport-copy">Los Angeles rallied from a 4-2 ninth-inning deficit before edging Toronto 5-4 in Game 7 to become the first repeat World Series champion in 25 years.</p>
                        <div id="sportsFeatureMore" class="read-more-content" hidden>
                            <p class="sport-copy">Miguel Rojas tied the game with a two-out solo shot in the ninth, and Will Smith delivered the decisive blow in the eleventh. Yoshinobu Yamamoto then shut the door after working in relief just a day after a 96-pitch start.</p>
                            <p class="sport-copy">Shohei Ohtani finished the postseason batting .333, helping seal the Dodgers' place as one of baseball's defining modern dynasties.</p>
                        </div>
                        <button class="read-more-btn" type="button" data-read-more="sportsFeatureMore" aria-expanded="false">Read more</button>
                        <div class="hero-meta"><span class="hero-author">David Sutherland</span><span>•</span><span>November 2, 2025</span><span>•</span><span>8:00 PM EST</span></div>
                    </article>

                    <aside class="sport-sidebar">
                        <a href="article-eagles-super-bowl.php" class="card-link"><article class="compact-story filter-item" data-category="football" data-date="2025-02-09" data-search="Hurts MVP tush push Chiefs Eagles Super Bowl football">
                            <span class="story-pill">Football</span>
                            <h4 class="compact-title">Hurts' all-around control turned the Super Bowl into a statement performance</h4>
                            <div class="compact-meta"><span>Marcus Thompson</span><span>•</span><span>Player of the night</span></div>
                        </article></a>
                        <article class="compact-story filter-item" data-category="basketball" data-date="2025-06-22" data-search="Holmgren 5 blocks Jalen Williams 20 points Thunder Pacers basketball">
                            <span class="story-pill">Basketball</span>
                            <h4 class="compact-title">Holmgren and Williams gave OKC the push it needed in the third quarter</h4>
                            <div class="compact-meta"><span>Sarah Jenkins</span><span>•</span><span>Game 7 swing</span></div>
                        </article>
                        <article class="compact-story filter-item" data-category="soccer" data-date="2025-05-31" data-search="Luis Enrique French club first continental treble PSG soccer">
                            <span class="story-pill">Football / Soccer</span>
                            <h4 class="compact-title">Luis Enrique finally led PSG to the European breakthrough they chased for years</h4>
                            <div class="compact-meta"><span>James Pratt</span><span>•</span><span>Historic night</span></div>
                        </article>
                        <a href="article-wimbledon.php" class="card-link"><article class="compact-story filter-item" data-category="tennis" data-date="2025-07-13" data-search="double bagel Grand Slam final Swiatek Sinner Wimbledon tennis">
                            <span class="story-pill">Tennis</span>
                            <h4 class="compact-title">Wimbledon delivered one breakthrough and one unforgettable statement win</h4>
                            <div class="compact-meta"><span>Elena Costas</span><span>•</span><span>Centre Court story</span></div>
                        </article></a>
                    </aside>
                </div>
            </section>

            <div class="section-divider"></div>

            <section data-filter-section>
                <div class="section-header">
                    <h2 class="section-title">Full rundown</h2>
                    <span class="section-link">List layout</span>
                </div>
                <div class="story-list">
                    <a href="article-eagles-super-bowl.php" class="card-link"><article class="list-story filter-item" data-category="football" data-date="2025-02-09" data-search="Eagles Chiefs Super Bowl DeJean Hurts football">
                        <div class="media-slot list-image"><span>Image slot</span><small>Insert Super Bowl celebration image</small></div>
                        <div class="list-content">
                            <span class="story-pill">American Football</span>
                            <h3 class="list-title">Philadelphia's defense wrote the script from start to finish</h3>
                            <p class="list-copy">Six sacks, three turnovers, and a pick-six from Cooper DeJean turned the biggest game of the year into a showcase for the Eagles' balance on both sides of the ball.</p>
                            <div class="story-meta"><span class="story-author">Marcus Thompson</span><span>•</span><span>Super Bowl LIX</span></div>
                        </div>
                    </article></a>
                    <article class="list-story filter-item" data-category="basketball" data-date="2025-06-22" data-search="Shai MVP scoring title Finals MVP Thunder basketball">
                        <div class="media-slot list-image"><span>Image slot</span><small>Insert Shai or Thunder finals image</small></div>
                        <div class="list-content">
                            <span class="story-pill">Basketball</span>
                            <h3 class="list-title">Shai's season ended with the rarest kind of sweep of individual honors</h3>
                            <p class="list-copy">He became the first player since Shaquille O'Neal in 2000 to win the scoring title, league MVP, and Finals MVP in the same year.</p>
                            <div class="story-meta"><span class="story-author">Sarah Jenkins</span><span>•</span><span>NBA Finals</span></div>
                        </div>
                    </article>
                    <article class="list-story filter-item" data-category="soccer" data-date="2025-05-31" data-search="Doue Hakimi Kvaratskhelia Mayulu PSG Champions League soccer">
                        <div class="media-slot list-image"><span>Image slot</span><small>Insert Allianz Arena final image</small></div>
                        <div class="list-content">
                            <span class="story-pill">Football / Soccer</span>
                            <h3 class="list-title">PSG finally looked like the complete version of themselves</h3>
                            <p class="list-copy">They dominated possession, overwhelmed Inter, and turned the club's most important final into a performance with no visible cracks.</p>
                            <div class="story-meta"><span class="story-author">James Pratt</span><span>•</span><span>Champions League Final</span></div>
                        </div>
                    </article>
                </div>
            </section>

            <div class="section-divider"></div>

            <section class="newsletter-section">
                <div>
                    <h2 class="newsletter-title">Get the next sports wave before it becomes everyone else's headline</h2>
                    <p class="newsletter-description">This section stays styled like the rest of UrbanPulse, but it now fits the sports page better and no longer feels detached from the content above it.</p>
                </div>
                <a href="subscription.php" class="newsletter-cta">Subscribe now</a>
            </section>

            <section class="comment-section">
                <h3>Leave a Comment <span id="commentCount">0</span></h3>
                <form id="commentForm">
                    <div class="form-row">
                        <div class="field">
                            <label for="username">Name</label>
                            <input type="text" id="username" maxlength="60" placeholder="Your name">
                        </div>
                        <div class="field">
                            <label for="comment">Comment</label>
                            <textarea id="comment" maxlength="500" placeholder="Share your reaction to the sports desk"></textarea>
                        </div>
                    </div>
                    <div class="comment-actions">
                        <span id="commentCounter">500 characters remaining</span>
                        <button class="comment-submit" type="submit">Post comment</button>
                    </div>
                </form>
                <ul id="commentsContainer"></ul>
            </section>
        </div>
    </main>
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
              href="technology.php"
              >Technology</a
            >
            <a class="burger-link" data-nav href="sports.php"
              >Sports</a
            >
            <a
              class="burger-link"
              data-nav
              href="entertainment.php"
              >Entertainment</a
            >
            <a class="burger-link" data-nav href="worldnews.php"
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
	<script src="theme.js"></script>
	<script src="interactions.js"></script>
	<script src="comments_updated.js"></script>
<script src="pulse-features.js"></script>
<script src="editorial-tools.js"></script>
</body>
</html>