<?php
require_once 'db.php';
require_once 'auth.php'; // This also starts the session and connects to the DB
$currentUser = getCurrentUser(); // Returns user data if logged in, or null if not
?>
<!DOCTYPE html>
<html>
<head>
    <title> UrbanPulse | Technology Page </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="navfooter.css">
    <link rel="stylesheet" href="technology.css">
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

</head>
<body>

	<!-- BREAKING NEWS STICKER -->
	<?php require_once 'nav.php'; ?>




    <main>
        <div class="container">
            <section class="page-intro">
                <div>
                    <span class="page-kicker">UrbanPulse Technology</span>
                    <h1 class="page-title">AI systems, hardware shifts, and the ideas shaping tomorrow's tools</h1>
                    <p class="page-description">Your technology page now uses the stories from the PDF and keeps the UrbanPulse header, footer, burger menu, and overall feel. Search, filters, read more and less, and comments are all wired in, while every image area is ready for your manual upload.</p>
                </div>
                <div class="page-stamp">Updated from your PDF content</div>
            </section>

            <section class="tools-bar" aria-label="Technology tools">
                <div class="tools-field">
                    <label class="tools-label" for="articleSearch">Search stories</label>
                    <input class="tools-input" type="search" id="articleSearch" placeholder="Search AI, hardware, science, consumer tech">
                </div>
                <div class="tools-field">
                    <label class="tools-label" for="categoryFilter">Filter by topic</label>
                    <select class="tools-select" id="categoryFilter">
                        <option value="all">All technology</option>
                        <option value="ai">AI and Robotics</option>
                        <option value="hardware">Infrastructure and Hardware</option>
                        <option value="science">Cybersecurity and Science</option>
                        <option value="consumer">Consumer Technology</option>
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

            <div id="filterEmpty" class="filter-empty">No technology stories match your current search and filter combination.</div>

            <div class="page-layout">
                <div class="main-content">
                    <article class="hero-article filter-item" data-category="ai" data-date="2026-02-23" data-search="Agentic AI autonomous systems workflows supply chains trust safety Aris Thorne">
                        <div class="media-slot hero-image"><span>Hero image slot</span><small>Insert AI systems or robotics image</small></div>
                        <span class="hero-category">AI and Robotics</span>
                        <h2 class="hero-title">The Transition to Agentic AI and Autonomous Systems</h2>
                        <p class="hero-excerpt">The latest wave of AI is moving beyond simple prompt-and-response tools. Enterprises are now deploying agents that can manage multi-step workflows, assign responsibility, and optimize operations with far less human guidance.</p>
                        <div id="techHeroMore" class="read-more-content" hidden>
                            <p class="hero-copy">That productivity jump also creates a harder question: when AI handles thousands of micro-decisions each day, traditional human review becomes unrealistic. The conversation is shifting from direct oversight to how trust, safety, and accountability are engineered into the logic itself.</p>
                            <p class="hero-copy">In other words, this is not just a software update. It is becoming an operating model change for entire organizations.</p>
                        </div>
                        <button class="read-more-btn" type="button" data-read-more="techHeroMore" aria-expanded="false">Read more</button>
                        <div class="hero-meta"><span class="hero-author">Aris Thorne</span><span>•</span><span>February 23, 2026</span><span>•</span><span>9:00 AM PST</span></div>
                    </article>

                    <div class="section-divider"></div>

                    <section data-filter-section>
                        <div class="section-header">
                            <h2 class="section-title">Signals to watch</h2>
                            <span class="section-link">Big themes</span>
                        </div>
                        <div class="signal-strip">
                            <div class="signal-card filter-item" data-category="ai" data-date="2026-02-23" data-search="persistent memory emotional intelligence GPT-6 beta">
                                <strong>Persistent memory</strong>
                                <span>GPT-6 style continuity becomes a defining AI conversation</span>
                            </div>
                            <div class="signal-card filter-item" data-category="hardware" data-date="2026-02-23" data-search="orbital fuel transfer Starship 5 Artemis III">
                                <strong>Orbital refueling</strong>
                                <span>Starship architecture takes a major step toward the Moon and Mars</span>
                            </div>
                            <div class="signal-card filter-item" data-category="science" data-date="2026-02-23" data-search="1D electron behavior room temperature superconductors quantum materials">
                                <strong>1D electron flow</strong>
                                <span>Quantum materials research edges closer to huge hardware gains</span>
                            </div>
                        </div>
                    </section>

                    <div class="section-divider"></div>

                    <section data-filter-section>
                        <div class="section-header">
                            <h2 class="section-title">Latest news</h2>
                            <span class="section-link">Card layout</span>
                        </div>
                        <div class="news-grid">
                            <article class="news-card filter-item" data-category="ai" data-date="2026-02-23" data-search="GPT-6 beta near-human emotional reasoning persistent memory privacy Julian Vane">
                                <div class="media-slot news-card-image"><span>Image slot</span><small>Insert GPT or AI memory image</small></div>
                                <span class="news-card-category">AI and Robotics</span>
                                <h3 class="news-card-title">GPT-6 Early Beta Users Report Near-Human Emotional Reasoning</h3>
                                <p class="news-card-excerpt">The beta reportedly remembers preferences and emotional tone across long conversations, making the experience feel more continuous and personal than earlier models.</p>
                                <div id="techCard1" class="read-more-content" hidden><p class="review-copy">That same memory layer raises fresh privacy questions, and the debate is already moving toward how persistent AI memory should be protected and governed.</p></div>
                                <button class="read-more-btn" type="button" data-read-more="techCard1" aria-expanded="false">Read more</button>
                                <div class="news-card-meta"><span class="news-card-author">Julian Vane</span><span>•</span><span>11:15 AM EST</span></div>
                            </article>
                            <article class="news-card filter-item" data-category="ai" data-date="2026-02-23" data-search="Humanoid robots manufacturing lines Optimus Digit Electric Atlas Sarah Jenkins robotics">
                                <div class="media-slot news-card-image"><span>Image slot</span><small>Insert humanoid robot factory image</small></div>
                                <span class="news-card-category">AI and Robotics</span>
                                <h3 class="news-card-title">Humanoid Robots Join Global Manufacturing Lines</h3>
                                <p class="news-card-excerpt">General-purpose bipedal robots are now moving from pilot tests into full deployments across automotive and logistics facilities.</p>
                                <div id="techCard2" class="read-more-content" hidden><p class="review-copy">The shift changes the role of factory workers too, pulling more value into supervision, orchestration, and fleet management rather than pure physical labor.</p></div>
                                <button class="read-more-btn" type="button" data-read-more="techCard2" aria-expanded="false">Read more</button>
                                <div class="news-card-meta"><span class="news-card-author">Sarah Jenkins</span><span>•</span><span>2:45 PM GMT</span></div>
                            </article>
                            <article class="news-card filter-item" data-category="hardware" data-date="2026-02-23" data-search="Messenger desktop website April 2026 Meta messenger.com Sharona Nicole Semilla">
                                <div class="media-slot news-card-image"><span>Image slot</span><small>Insert Messenger or Meta image</small></div>
                                <span class="news-card-category">Infrastructure and Hardware</span>
                                <h3 class="news-card-title">Meta to Shut Down Messenger Desktop Website in April 2026</h3>
                                <p class="news-card-excerpt">Messenger.com is heading for retirement as Meta folds desktop messaging more tightly into Facebook's main ecosystem.</p>
                                <div id="techCard3" class="read-more-content" hidden><p class="review-copy">The move streamlines Meta's platform strategy, but it also frustrates users who preferred a standalone and distraction-free messaging space.</p></div>
                                <button class="read-more-btn" type="button" data-read-more="techCard3" aria-expanded="false">Read more</button>
                                <div class="news-card-meta"><span class="news-card-author">Sharona Nicole Semilla</span><span>•</span><span>10:09 PM PHT</span></div>
                            </article>
                            <article class="news-card filter-item" data-category="hardware" data-date="2026-02-23" data-search="Starship 5 orbital fuel transfer Artemis III David Sutherland SpaceX Moon Mars">
                                <div class="media-slot news-card-image"><span>Image slot</span><small>Insert Starship orbit image</small></div>
                                <span class="news-card-category">Infrastructure and Hardware</span>
                                <h3 class="news-card-title">SpaceX Starship 5 Completes First Orbital Fuel Transfer</h3>
                                <p class="news-card-excerpt">A successful cryogenic transfer in orbit strengthened the case for lunar cargo missions and future long-duration Mars plans.</p>
                                <div id="techCard4" class="read-more-content" hidden><p class="review-copy">For NASA's Artemis III plans, it removes one of the biggest technical obstacles and makes the Moon architecture feel much more concrete.</p></div>
                                <button class="read-more-btn" type="button" data-read-more="techCard4" aria-expanded="false">Read more</button>
                                <div class="news-card-meta"><span class="news-card-author">David Sutherland</span><span>•</span><span>3:30 PM CST</span></div>
                            </article>
                            <article class="news-card filter-item" data-category="science" data-date="2026-02-23" data-search="Quantum materials true 1D electron behavior Elena Costas superconductors pinball phase">
                                <div class="media-slot news-card-image"><span>Image slot</span><small>Insert quantum material visualization</small></div>
                                <span class="news-card-category">Cybersecurity and Science</span>
                                <h3 class="news-card-title">Quantum Materials Researchers Confirm True 1D Electron Behavior</h3>
                                <p class="news-card-excerpt">Scientists observed electrons moving in a one-dimensional file inside synthetic crystals, opening a path toward more resilient and faster hardware.</p>
                                <div id="techCard5" class="read-more-content" hidden><p class="review-copy">The newly confirmed pinball phase is especially important because it could help future systems move closer to room-temperature superconductors.</p></div>
                                <button class="read-more-btn" type="button" data-read-more="techCard5" aria-expanded="false">Read more</button>
                                <div class="news-card-meta"><span class="news-card-author">Elena Costas</span><span>•</span><span>11:00 AM EST</span></div>
                            </article>
                            <article class="news-card filter-item" data-category="science" data-date="2026-02-23" data-search="Australia sovereign AI factory NVIDIA Cisco Marcus Thompson Sydney digital sovereignty">
                                <div class="media-slot news-card-image"><span>Image slot</span><small>Insert sovereign AI factory image</small></div>
                                <span class="news-card-category">Cybersecurity and Science</span>
                                <h3 class="news-card-title">Australia Launches Its First Secure Sovereign AI Factory</h3>
                                <p class="news-card-excerpt">NVIDIA and Cisco helped build a Sydney facility designed to keep sensitive AI workloads and national data within Australian borders.</p>
                                <div id="techCard6" class="read-more-content" hidden><p class="review-copy">It is a direct response to digital sovereignty concerns and a sign that AI infrastructure is becoming a geopolitical issue, not just a technical one.</p></div>
                                <button class="read-more-btn" type="button" data-read-more="techCard6" aria-expanded="false">Read more</button>
                                <div class="news-card-meta"><span class="news-card-author">Marcus Thompson</span><span>•</span><span>8:00 AM AEST</span></div>
                            </article>
                        </div>
                    </section>

                    <div class="section-divider"></div>

                    <section data-filter-section>
                        <div class="section-header">
                            <h2 class="section-title">Consumer and industry deep dive</h2>
                            <span class="section-link">Mixed layout</span>
                        </div>
                        <div class="deep-dive-list">
                            <article class="review-card filter-item" data-category="consumer" data-date="2026-02-23" data-search="Infinix Note 60 battery Snapdragon Active Matrix Sam Chen consumer technology smartphone">
                                <div class="review-image"><div class="media-slot"><span>Image slot</span><small>Insert Infinix NOTE 60 image</small></div></div>
                                <div class="review-content">
                                    <span class="review-label">Consumer Technology</span>
                                    <h3 class="review-title">Infinix Unveils NOTE 60 Series with Revolutionary Battery Tech</h3>
                                    <p class="review-copy">The NOTE 60 Pro pairs a 6,500 mAh battery with a slim body, brings Snapdragon chips back to the lineup, and adds an active matrix display for mini-games and smart alerts.</p>
                                    <div id="techReview1" class="read-more-content" hidden><p class="review-copy">Its biggest promise is simple but important: light users can stretch usage close to a full week, which directly attacks one of the longest-running pain points in phones.</p></div>
                                    <button class="read-more-btn" type="button" data-read-more="techReview1" aria-expanded="false">Read more</button>
                                    <div class="review-meta"><span>Sam Chen</span><span>•</span><span>2:30 PM CST</span></div>
                                </div>
                            </article>
                            <article class="review-card filter-item" data-category="ai" data-date="2026-02-23" data-search="human-on-the-loop safety governance agentic systems autonomous decisions trust">
                                <div class="review-image"><div class="media-slot"><span>Image slot</span><small>Insert governance or control room image</small></div></div>
                                <div class="review-content">
                                    <span class="review-label">Industry Watch</span>
                                    <h3 class="review-title">Why Human-on-the-Loop Governance Is Becoming Harder to Sustain</h3>
                                    <p class="review-copy">As autonomous agents start handling thousands of decisions a day, manual review stops scaling. That shifts the focus toward guardrails and system design instead of direct human approval.</p>
                                    <div class="review-meta"><span>Derived from the lead AI story</span></div>
                                </div>
                            </article>
                            <article class="review-card filter-item" data-category="hardware" data-date="2026-02-23" data-search="Moon Mars cargo architecture Starship fuel transfer hardware space missions">
                                <div class="review-image"><div class="media-slot"><span>Image slot</span><small>Insert Moon mission image</small></div></div>
                                <div class="review-content">
                                    <span class="review-label">Mission Hardware</span>
                                    <h3 class="review-title">Orbital Refueling Changes the Size of What Space Missions Can Attempt</h3>
                                    <p class="review-copy">By proving a ship can launch and then refuel in space, the architecture for heavier Moon cargo, repeated missions, and deeper exploration becomes much more realistic.</p>
                                    <div class="review-meta"><span>Derived from the Starship story</span></div>
                                </div>
                            </article>
                        </div>
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
                                    <textarea id="comment" maxlength="500" placeholder="Share your thoughts on the technology desk"></textarea>
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

                <aside class="sidebar">
                    <div class="sidebar-section" data-filter-section>
                        <h3 class="sidebar-heading">Trending topics</h3>
                        <div class="trending-list">
                            <div class="trending-item filter-item" data-category="ai" data-date="2026-02-23" data-search="GPT-6 persistent memory emotional intelligence">
                                <div class="trending-number">01</div>
                                <div>
                                    <span class="trending-category">AI</span>
                                    <h4 class="trending-title">Persistent memory is changing what users expect from AI chat</h4>
                                    <div class="trending-meta">Julian Vane</div>
                                </div>
                            </div>
                            <div class="trending-item filter-item" data-category="ai" data-date="2026-02-23" data-search="humanoid robots manufacturing Tesla Agility Boston Dynamics">
                                <div class="trending-number">02</div>
                                <div>
                                    <span class="trending-category">Robotics</span>
                                    <h4 class="trending-title">Factory floors are becoming the real test bed for humanoid robots</h4>
                                    <div class="trending-meta">Sarah Jenkins</div>
                                </div>
                            </div>
                            <div class="trending-item filter-item" data-category="science" data-date="2026-02-23" data-search="pinball phase superconductors quantum materials science">
                                <div class="trending-number">03</div>
                                <div>
                                    <span class="trending-category">Science</span>
                                    <h4 class="trending-title">The pinball phase could matter far beyond the lab</h4>
                                    <div class="trending-meta">Elena Costas</div>
                                </div>
                            </div>
                            <div class="trending-item filter-item" data-category="consumer" data-date="2026-02-23" data-search="Infinix NOTE 60 battery lifespan consumer tech">
                                <div class="trending-number">04</div>
                                <div>
                                    <span class="trending-category">Consumer</span>
                                    <h4 class="trending-title">Battery life is becoming a headline feature again</h4>
                                    <div class="trending-meta">Sam Chen</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-promo">
                        <div class="sidebar-promo-label">INSIDE TECH</div>
                        <h4 class="sidebar-promo-title">Ready image areas, cleaner structure, and working interactions</h4>
                        <p class="sidebar-promo-text">This block stays visually consistent with the page and gives the sidebar a finished feel instead of looking empty.</p>
                    </div>

                    <div class="sidebar-section" data-filter-section>
                        <h3 class="sidebar-heading">Editor's picks</h3>
                        <div>
                            <article class="sidebar-story filter-item" data-category="hardware" data-date="2026-02-23" data-search="Messenger website desktop Meta security ecosystem">
                                <span class="sidebar-category">Infrastructure</span>
                                <h4 class="sidebar-title">Meta's Messenger change says a lot about platform consolidation</h4>
                                <div class="sidebar-meta">Sharona Nicole Semilla</div>
                            </article>
                            <article class="sidebar-story filter-item" data-category="hardware" data-date="2026-02-23" data-search="Starship 5 fuel transfer Artemis Moon Mars">
                                <span class="sidebar-category">Space hardware</span>
                                <h4 class="sidebar-title">The Moon story is also a Mars story once refueling works</h4>
                                <div class="sidebar-meta">David Sutherland</div>
                            </article>
                            <article class="sidebar-story filter-item" data-category="science" data-date="2026-02-23" data-search="Sovereign AI Factory Australia Cisco NVIDIA">
                                <span class="sidebar-category">Security</span>
                                <h4 class="sidebar-title">Sovereign AI infrastructure is turning into a serious national priority</h4>
                                <div class="sidebar-meta">Marcus Thompson</div>
                            </article>
                        </div>
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
	<script src="interactions.js"></script>
	<script src="comments_updated.js"></script>
</body>
</html>