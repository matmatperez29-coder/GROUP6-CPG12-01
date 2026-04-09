<?php
require_once 'db.php';
require_once 'auth.php';
$currentUser = getCurrentUser();
?>
<?php $pageId = 'worldnews'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>UrbanPulse | World News</title>
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
  <link rel="stylesheet" href="worldnews.css">
  <link rel="stylesheet" href="burgermenu.css">
  <link rel="stylesheet" href="theme.css">
  <link rel="stylesheet" href="pulse-features.css">
  <link rel="icon" type="image/x-icon" href="IMAGES/UrbanPulse.png">
</head>
<body data-page="<?php echo htmlspecialchars($pageId, ENT_QUOTES, 'UTF-8'); ?>">

  <?php require_once 'nav.php'; ?>

  <!-- FILTER BAR -->
  <div class="filter-bar">
    <div class="filter-inner">
      <span class="filter-label">Filter By:</span>
      <select id="categoryFilter">
        <option value="all">All Categories</option>
        <option value="politics">Politics</option>
        <option value="environment">Environment</option>
        <option value="economy">Economy</option>
        <option value="health">Health</option>
        <option value="humanity">Humanity</option>
        <option value="society">Society</option>
        <option value="climate">Climate</option>
      </select>
      <select id="dateFilter">
        <option value="all">All Dates</option>
        <option value="today">Today</option>
        <option value="this-week">This Week</option>
        <option value="this-month">This Month</option>
      </select>
      <span class="filter-results" id="filterResults"></span>
    </div>
  </div>

  <div class="page-wrapper">

    <!-- FEATURED HERO -->
    <div class="hero-row">
      <a href="article-plastic-oceans.php" class="card-link" style="display:block;text-decoration:none;color:inherit;"><article class="featured-main news-item" data-category="politics" data-date="2026-03-20">
        <div class="featured-main-image" style="background-image:url('https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=1200')">
			  <div class="featured-main-overlay">
				<span class="badge cat-politics">Politics</span>
				<h1 class="featured-title">World Leaders Gather in Geneva for Historic Climate Summit</h1>
				<p class="featured-excerpt">More than 180 heads of state convened this week to negotiate binding carbon commitments in what analysts are calling the most consequential climate meeting in a decade.</p>
            <div class="featured-meta"><span>Maria Santos</span><span>March 20, 2026</span><span>5 min read</span></div>
          </div>
        </div>
      </article></a>
      <div class="featured-side">
        <article class="featured-side-item news-item" data-category="environment" data-date="2026-03-23">
          <div class="featured-side-image" style="background-image:url('https://i.guim.co.uk/img/media/e2d88502c87e6650ac622bc9ff48cfe95432bc0c/476_0_4483_3587/master/4483.jpg?width=620&dpr=2&s=none&crop=none')"></div>
          <div class="featured-side-content"><span class="badge cat-economy">Environment</span><h3 class="featured-side-title">Earth Being 'Pushed Beyond Its Limits' as Energy Imbalance Reaches Record High</h3><div class="featured-meta">Jonathan Watts • March 23, 2026</div></div>
        </article>
        <article class="featured-side-item news-item" data-category="health" data-date="2026-03-18">
          <div class="featured-side-image" style="background-image:url('https://gdb.voanews.com/03990000-0aff-0242-34e0-08dab21be46c_w1080_h608.jpg')"></div>
          <div class="featured-side-content"><span class="badge cat-health">Health</span><h3 class="featured-side-title">WHO Declares End to South Asian Respiratory Outbreak</h3><div class="featured-meta">Elena Ramos • March 18, 2026</div></div>
        </article>
        <article class="featured-side-item news-item" data-category="society" data-date="2026-03-12">
          <div class="featured-side-image" style="background-image:url('https://images.unsplash.com/photo-1477281765962-ef34e8bb0967?w=400')"></div>
          <div class="featured-side-content"><span class="badge cat-society">Society</span><h3 class="featured-side-title">Youth Unemployment Rates Rise in Developing Nations</h3><div class="featured-meta">Carlos Mureithi • March 12, 2026</div></div>
        </article>
      </div>
    </div>

    <!-- MAIN LAYOUT -->
    <div class="main-layout">
      <div class="main-col">

        <!-- Global Briefing -->
        <section>
          <div class="section-header">
            <div class="section-header-top"><h2 class="section-title">Global Briefing</h2><a href="#" class="section-link">View All →</a></div>
            <div class="section-header-line"></div>
          </div>
          <div class="briefing-list">
            <article class="briefing-item news-item" data-category="politics" data-date="2026-03-17"><div class="briefing-cat">Politics</div><div class="briefing-title">First Thing: Israel says Iran's security chief Ali Larijani killed in airstrike</div><div class="briefing-meta">Clea Skopeliti • March 17, 2026 • 2 min read</div></article>
            <article class="briefing-item news-item" data-category="climate" data-date="2026-03-21"><div class="briefing-cat">Climate</div><div class="briefing-title">Earth Being 'Pushed Beyond Its Limits' as Energy Imbalance Reaches Record High</div><div class="briefing-meta">Jonathan Watts • March 21, 2026 • 3 min read</div></article>
            <article class="briefing-item news-item" data-category="humanity" data-date="2026-03-17"><div class="briefing-cat">Humanity</div><div class="briefing-title">International NGOs Expand Food Aid in Conflict Zones</div><div class="briefing-meta">Sam Mednick • March 17, 2026</div></article>
            <article class="briefing-item news-item" data-category="health" data-date="2026-03-20"><div class="briefing-cat">Health</div><div class="briefing-title">Global Malaria Deaths Fall 20% After New Vaccine Rollout</div><div class="briefing-meta">WHO • March 20, 2026 • 4 min read</div></article>
            <article class="briefing-item news-item" data-category="society" data-date="2026-03-19"><div class="briefing-cat">Society</div><div class="briefing-title">UNESCO Names 12 New World Heritage Sites Across Three Continents</div><div class="briefing-meta">Staff • March 19, 2026 • 2 min read</div></article>
            <article class="briefing-item news-item" data-category="humanity" data-date="2026-03-19"><div class="briefing-cat">Humanity</div><div class="briefing-title">Aid Convoy Reaches Isolated Communities in Eastern DRC</div><div class="briefing-meta">UNHCR • March 19, 2026 • 3 min read</div></article>
          </div>
        </section>

        <!-- Worldwide Dispatches -->
        <section>
          <div class="section-header">
            <div class="section-header-top"><h2 class="section-title">Worldwide Dispatches</h2></div>
            <div class="section-header-line"></div>
          </div>
          <div class="globe-grid">
            <article class="globe-card news-item" data-category="environment" data-date="2026-03-06"><div class="globe-card-image" style="background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT66AOJ6Jc7THESUFPUbVxEByV065A--hSfiQ&s')"></div><div class="globe-card-content"><div class="globe-region">🌍 Southern Europe</div><span class="badge cat-politics">Environment</span><h4>Severe Drought Impacts Agriculture in Southern Europe</h4><span class="globe-meta">Lorenzo Tondo • March 06, 2026</span></div></article>
            <article class="globe-card news-item" data-category="humanity" data-date="2026-03-07"><div class="globe-card-image" style="background-image:url('https://redcross.sg/images/2024/Press_Releases/Singapore_Red_Cross_SEA_Floods_Appeal.JPG')"></div><div class="globe-card-content"><div class="globe-region">🌍 South Asia</div><span class="badge cat-humanity">Humanity</span><h4>Volunteers Mobilize to Support Flood Victims in South Asia</h4><span class="globe-meta">Al Jazeera Staff • March 07, 2026</span></div></article>
            <article class="globe-card news-item" data-category="politics" data-date="2026-03-05"><div class="globe-card-image" style="background-image:url('https://europeanwesternbalkans.com/wp-content/uploads/2026/03/656614930_905067112152390_3094144116388564861_n-1024x683.jpg')"></div><div class="globe-card-content"><div class="globe-region">🌎 Eastern Europe</div><span class="badge cat-climate">Politics</span><h4>Elections in Eastern Europe Highlight Political Divisions</h4><span class="globe-meta">Andrew Higgins • March 05, 2026</span></div></article>
            <article class="globe-card news-item" data-category="economy" data-date="2026-03-06"><div class="globe-card-image" style="background-image:url('https://media.cnn.com/api/v1/images/stellar/prod/230428112802-sau-reservoir-catalonia-spain.jpg?c=original')"></div><div class="globe-card-content"><div class="globe-region">🌏 Spain, Europe</div><span class="badge cat-economy">Economy</span><h4>Spain Faces Water Crisis as Reservoir Levels Drop</h4><span class="globe-meta">Elena Sevillano • March 06, 2026</span></div></article>
            <article class="globe-card news-item" data-category="environment" data-date="2026-03-10"><div class="globe-card-image" style="background-image:url('https://i.guim.co.uk/img/media/e0d851825d12a5ac3a3ac3bef0351507bf5c68b5/0_344_5180_3108/master/5180.jpg?width=1200&height=900&quality=85&auto=format&fit=crop&s=33b3e9ccc33b95867e8a53d94fad393c')"></div><div class="globe-card-content"><div class="globe-region">🌏 Brazil, South America</div><span class="badge cat-economy">Environment</span><h4>Amazon Deforestation Rates Rise Again in Brazil</h4><span class="globe-meta">Andre Cabette Fabio • March 10, 2026</span></div></article>
            <article class="globe-card news-item" data-category="health" data-date="2026-03-18"><div class="globe-card-image" style="background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTg1SJzJ_e0zgBpSnd5AYE0UAu3ZkoMaeYo9g&s')"></div><div class="globe-card-content"><div class="globe-region">🌎 North America</div><span class="badge cat-health">Health</span><h4>Canada Launches Universal Dental Care Program for All Citizens</h4><span class="globe-meta">Sophie Martin • March 18, 2026</span></div></article>
            <article class="globe-card news-item" data-category="society" data-date="2026-03-09"><div class="globe-card-image" style="background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSK6H5FwSSuFEiqtT8UTSQQr4hbMn5VXORJrA&s')"></div><div class="globe-card-content"><div class="globe-region">🌏 Nigeria, Africa</div><span class="badge cat-society">Society</span><h4>Nigeria Expands Digital Education Programs for Youth</h4><span class="globe-meta">Chinedu Asadu • March 09, 2026</span></div></article>
            <article class="globe-card news-item" data-category="economy" data-date="2026-03-17"><div class="globe-card-image" style="background-image:url('https://substackcdn.com/image/fetch/f_auto,q_auto:good,fl_progressive:steep/https%3A%2F%2Fsubstack-post-media.s3.amazonaws.com%2Fpublic%2Fimages%2Fa5ee6c85-2c18-4b56-9916-803822910e65_2886x1843.png')"></div><div class="globe-card-content"><div class="globe-region">🌍 Germany, Europe</div><span class="badge cat-politics">Economy</span><h4>Germany's Economy Slows Amid Industrial Decline</h4><span class="globe-meta">Marek Kowalski • March 17, 2026</span></div></article>
            <article class="globe-card news-item" data-category="health" data-date="2026-03-13"><div class="globe-card-image" style="background-image:url('https://d1ns4ht6ytuzzo.cloudfront.net/oxfamdata/oxfamdatapublic/styles/news_detail_748x373/public/2019-07/19-Odisha_Parivatan_VivekM_MG_8322.jpg?itok=LvJQm-iU')"></div><div class="globe-card-content"><div class="globe-region">🌏 India, Asia</div><span class="badge cat-humanity">Health</span><h4>India Expands Public Healthcare Access in Rural Areas</h4><span class="globe-meta">Rhea Mogul • March 13, 2026</span></div></article>
          </div>
        </section>

      </div><!-- /main-col -->

      <!-- SIDEBAR -->
      <aside class="sidebar">

        <div class="sidebar-box">
          <div class="world-map-widget">
            <div class="world-map-widget-title">Interactive World Map</div>
            <div class="region-chips">
              <button class="chip active" data-region="all">All</button>
              <button class="chip" data-region="asia">Asia</button>
              <button class="chip" data-region="mideast">Middle East</button>
              <button class="chip" data-region="americas">Americas</button>
              <button class="chip" data-region="europe">Europe</button>
              <button class="chip" data-region="africa">Africa</button>
            </div>
            <div class="world-map-container">
              <svg viewBox="0 0 1000 500" xmlns="http://www.w3.org/2000/svg" style="background:#cce8d9;">
                <path d="M120,80 L240,70 L270,120 L280,180 L240,220 L200,240 L170,220 L140,200 L110,160 Z" fill="#a8d5b5" stroke="#7bb89a" stroke-width="1.5"/>
                <path d="M210,260 L270,250 L290,280 L295,340 L280,390 L250,410 L220,400 L200,370 L195,320 L200,280 Z" fill="#a8d5b5" stroke="#7bb89a" stroke-width="1.5"/>
                <path d="M430,60 L510,55 L530,80 L520,120 L490,130 L460,125 L435,110 L425,85 Z" fill="#a8d5b5" stroke="#7bb89a" stroke-width="1.5"/>
                <path d="M440,150 L530,140 L560,170 L565,240 L550,310 L510,360 L470,370 L440,340 L420,280 L415,210 L425,170 Z" fill="#a8d5b5" stroke="#7bb89a" stroke-width="1.5"/>
                <path d="M530,50 L760,40 L800,80 L810,140 L780,180 L720,190 L660,180 L600,170 L560,150 L535,120 L525,80 Z" fill="#a8d5b5" stroke="#7bb89a" stroke-width="1.5"/>
                <path d="M700,190 L760,185 L780,210 L770,240 L740,250 L710,240 L695,215 Z" fill="#a8d5b5" stroke="#7bb89a" stroke-width="1.5"/>
                <path d="M720,290 L820,280 L850,310 L845,360 L810,385 L760,385 L725,360 L710,320 Z" fill="#a8d5b5" stroke="#7bb89a" stroke-width="1.5"/>
                <path d="M280,30 L360,25 L375,60 L350,80 L300,75 L275,55 Z" fill="#b8dfc5" stroke="#7bb89a" stroke-width="1"/>
              </svg>
              <div class="map-hotspot" style="left:19%;top:30%" data-region="americas" data-cat="Society" data-title="New York Passes Landmark Tenant Protection Act" data-desc="The NYC Council voted to expand rent stabilization to over 200,000 units — the city's most significant housing reform in decades." data-meta="Staff Reporter • March 21, 2026" data-link="#"><div class="map-tooltip">New York — Society</div></div>
              <div class="map-hotspot" style="left:22%;top:50%" data-region="americas" data-cat="Climate" data-title="Atacama Solar Farm Becomes World's Largest Installation" data-desc="Chile's new Atacama Desert solar array now powers over three million homes, setting a world record for single-site renewable capacity." data-meta="Ana Rivera • March 19, 2026" data-link="#"><div class="map-tooltip">Chile — Climate</div></div>
              <div class="map-hotspot" style="left:15%;top:20%" data-region="americas" data-cat="Health" data-title="Canada Launches Universal Dental Care for All Citizens" data-desc="Ottawa's new national dental program covers 35 million Canadians, with full rollout expected within 18 months." data-meta="Sophie Martin • March 18, 2026" data-link="#"><div class="map-tooltip">Canada — Health</div></div>
              <div class="map-hotspot" style="left:47%;top:22%" data-region="europe" data-cat="Politics" data-title="World Leaders Sign Historic Net-Zero Commitment at Geneva Summit" data-desc="Over 180 heads of state reached a binding agreement to achieve net-zero by 2045, with a $500B transition fund for developing nations." data-meta="Maria Santos • March 20, 2026" data-link="#"><div class="map-tooltip">Geneva — Politics</div></div>
              <div class="map-hotspot" style="left:51%;top:16%" data-region="europe" data-cat="Politics" data-title="Poland Assumes EU Council Presidency Amid Ukraine Push" data-desc="Warsaw formally took the EU rotating presidency, pledging to prioritise Ukraine reconstruction funding and eastern border security." data-meta="Marek Kowalski • March 17, 2026" data-link="#"><div class="map-tooltip">Warsaw — Politics</div></div>
              <div class="map-hotspot" style="left:49%;top:30%" data-region="europe" data-cat="Climate" data-title="Wildfire Near Athens Forces Evacuation of Three Villages" data-desc="Greek authorities evacuated 4,000 residents as fast-moving fires fuelled by Meltemi winds swept across Attica." data-meta="Staff • March 21, 2026" data-link="#"><div class="map-tooltip">Athens — Climate</div></div>
              <div class="map-hotspot" style="left:50%;top:53%" data-region="africa" data-cat="Humanity" data-title="UNICEF Opens 300 New Community Schools Across East Africa" data-desc="A major education drive funded by international donors brought schooling to over 120,000 children in rural Kenya, Tanzania, and Uganda." data-meta="Abebe Girma • March 20, 2026" data-link="#"><div class="map-tooltip">Nairobi — Humanity</div></div>
              <div class="map-hotspot" style="left:55%;top:44%" data-region="africa" data-cat="Humanity" data-title="Ethiopia's Renaissance Dam Begins Full Power Generation" data-desc="The dam now operates at full 5,150 MW capacity, transforming electricity access across Ethiopia and neighbouring countries." data-meta="Abebe Girma • March 20, 2026" data-link="#"><div class="map-tooltip">Ethiopia — Humanity</div></div>
              <div class="map-hotspot" style="left:47%;top:60%" data-region="africa" data-cat="Humanity" data-title="Aid Convoy Reaches Isolated Communities in Eastern DRC" data-desc="UNHCR-led convoy delivered food, medicine and shelter to 12,000 displaced people cut off by ongoing conflict." data-meta="UNHCR • March 19, 2026" data-link="#"><div class="map-tooltip">DRC — Humanity</div></div>
              <div class="map-hotspot" style="left:60%;top:32%" data-region="mideast" data-cat="Politics" data-title="Iran Threatens Gulf Energy Infrastructure After U.S. Ultimatum" data-desc="Tehran issued formal warnings targeting Gulf energy installations following escalating diplomatic tensions with Washington." data-meta="Reuters • March 24, 2026" data-link="#"><div class="map-tooltip">Tehran — Politics</div></div>
              <div class="map-hotspot" style="left:63%;top:40%" data-region="mideast" data-cat="Economy" data-title="Saudi Arabia's NEOM City Opens First Residential District" data-desc="The futuristic city project welcomed its first permanent residents as NEOM's linear urban core prepares for broader public access." data-meta="Fatima Al-Rashid • March 19, 2026" data-link="#"><div class="map-tooltip">Saudi Arabia — Economy</div></div>
              <div class="map-hotspot" style="left:57%;top:27%" data-region="mideast" data-cat="Politics" data-title="Israel Says Iran Security Chief Larijani Killed in Airstrike" data-desc="The Israeli military confirmed a targeted strike on a vehicle convoy in southern Lebanon, claiming Larijani as a high-value target." data-meta="Clea Skopeliti • March 17, 2026" data-link="#"><div class="map-tooltip">Lebanon — Politics</div></div>
              <div class="map-hotspot" style="left:68%;top:35%" data-region="asia" data-cat="Health" data-title="India Rolls Out World's Largest Universal Flu Vaccination Drive" data-desc="The Indian government launched a campaign targeting 600 million people, partnering with WHO to distribute a new broad-spectrum flu vaccine." data-meta="Priya Nair • March 18, 2026" data-link="#"><div class="map-tooltip">Mumbai — Health</div></div>
              <div class="map-hotspot" style="left:77%;top:29%" data-region="asia" data-cat="Economy" data-title="Beijing Files Formal Protest Over OPEC+ Production Cut" data-desc="China's foreign ministry summoned ambassadors from three Gulf states after OPEC+ announced a 1.2 million barrel-per-day output cut." data-meta="Lin Wei • March 21, 2026" data-link="#"><div class="map-tooltip">Beijing — Economy</div></div>
              <div class="map-hotspot" style="left:80%;top:40%" data-region="asia" data-cat="Society" data-title="Japan's Birth Rate Edges Up for First Time in 15 Years" data-desc="New government incentives including paid parental leave and subsidised childcare contributed to a modest but symbolic demographic uptick." data-meta="Yuki Tanaka • March 20, 2026" data-link="#"><div class="map-tooltip">Tokyo — Society</div></div>
            </div>
            <div class="map-story-panel" id="mapStoryPanel">
              <span class="map-story-close" id="mapStoryClose">✕</span>
              <div class="map-story-panel-inner">
                <div class="map-story-cat" id="mapStoryCat"></div>
                <div class="map-story-title" id="mapStoryTitle"></div>
                <div class="map-story-desc" id="mapStoryDesc"></div>
                <div class="map-story-meta" id="mapStoryMeta"></div>
                <a class="map-story-link" id="mapStoryLink" href="#">Read Full Story →</a>
              </div>
            </div>
            <div class="map-hint">Red markers indicate current news hotspots. Click a marker to view the story.</div>
            <div class="map-list" id="mapList">
              <div class="map-item" data-region="americas"><span class="map-item-dot"></span><div><div class="map-item-title">New York Passes Landmark Tenant Protection Act</div><div class="map-item-meta">United States · Society</div></div></div>
              <div class="map-item" data-region="americas"><span class="map-item-dot"></span><div><div class="map-item-title">Atacama Solar Farm Becomes World's Largest</div><div class="map-item-meta">Chile · Climate</div></div></div>
              <div class="map-item" data-region="americas"><span class="map-item-dot"></span><div><div class="map-item-title">Canada Launches Universal Dental Care Program</div><div class="map-item-meta">Canada · Health</div></div></div>
              <div class="map-item" data-region="europe"><span class="map-item-dot"></span><div><div class="map-item-title">Geneva Summit Final Communiqué Released</div><div class="map-item-meta">Switzerland · Politics</div></div></div>
              <div class="map-item" data-region="europe"><span class="map-item-dot"></span><div><div class="map-item-title">Poland Assumes EU Council Presidency</div><div class="map-item-meta">Poland · Politics</div></div></div>
              <div class="map-item" data-region="europe"><span class="map-item-dot"></span><div><div class="map-item-title">Wildfire Near Athens Forces Evacuation</div><div class="map-item-meta">Greece · Climate</div></div></div>
              <div class="map-item" data-region="africa"><span class="map-item-dot"></span><div><div class="map-item-title">UNICEF Opens 300 New Schools in East Africa</div><div class="map-item-meta">Kenya / Tanzania / Uganda · Humanity</div></div></div>
              <div class="map-item" data-region="africa"><span class="map-item-dot"></span><div><div class="map-item-title">Ethiopia Renaissance Dam Full Capacity</div><div class="map-item-meta">Ethiopia · Humanity</div></div></div>
              <div class="map-item" data-region="africa"><span class="map-item-dot"></span><div><div class="map-item-title">Aid Convoy Reaches Eastern DRC Communities</div><div class="map-item-meta">DR Congo · Humanity</div></div></div>
              <div class="map-item" data-region="mideast"><span class="map-item-dot"></span><div><div class="map-item-title">Iran Threatens Gulf Energy Infrastructure</div><div class="map-item-meta">Iran · Politics</div></div></div>
              <div class="map-item" data-region="mideast"><span class="map-item-dot"></span><div><div class="map-item-title">NEOM City Opens First Residential District</div><div class="map-item-meta">Saudi Arabia · Economy</div></div></div>
              <div class="map-item" data-region="mideast"><span class="map-item-dot"></span><div><div class="map-item-title">Israel Says Iran Security Chief Killed in Strike</div><div class="map-item-meta">Lebanon · Politics</div></div></div>
              <div class="map-item" data-region="asia"><span class="map-item-dot"></span><div><div class="map-item-title">India Rolls Out Universal Flu Vaccination Drive</div><div class="map-item-meta">India · Health</div></div></div>
              <div class="map-item" data-region="asia"><span class="map-item-dot"></span><div><div class="map-item-title">Beijing Protests OPEC+ Output Cut</div><div class="map-item-meta">China · Economy</div></div></div>
              <div class="map-item" data-region="asia"><span class="map-item-dot"></span><div><div class="map-item-title">Japan's Birth Rate Edges Up for First Time in 15 Years</div><div class="map-item-meta">Japan · Society</div></div></div>
            </div>
          </div>
        </div>

        <!-- LEADING GLOBAL HEADLINES -->
        <div class="sidebar-box">
          <div class="sidebar-widget">
            <div class="sidebar-widget-header">Leading Global Headlines</div>
            <div class="headline-list" id="headlineList">
              <a class="headline-card news-item" data-category="politics" data-date="2026-03-24" href="#"><span class="headline-rank">01</span><div class="headline-thumb" style="background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLmKjTOExiavk1zRWJBMIvlLfAvuF3gul1Jw&s')"></div><div class="headline-info"><div class="headline-category">Politics</div><div class="headline-title">Iran Threatens Gulf Energy Infrastructure After U.S. Ultimatum</div><div class="headline-meta">Maayan Lubell • March 24, 2026</div></div></a>
              <a class="headline-card news-item" data-category="economy" data-date="2026-03-18" href="#"><span class="headline-rank">02</span><div class="headline-thumb" style="background-image:url('https://www.morganstanley.com/content/dam/msdotcom/Insights/articles/iran-war-oil-shock-stock-market-impacts/tw-iran-war-oil-shock-stock-market-impacts-1200x628.jpg')"></div><div class="headline-info"><div class="headline-category">Economy</div><div class="headline-title">Iran War Oil Shock: Stock Market Impacts</div><div class="headline-meta">Daniel Kohen • March 18, 2026</div></div></a>
              <a class="headline-card news-item" data-category="economy" data-date="2026-03-22" href="#"><span class="headline-rank">03</span><div class="headline-thumb" style="background-image:url('https://images.gmanews.tv/webpics/2026/03/2026-03-04T104428Z_110062417_RC2JXJA61CPL_RTRMADP_3_IRAN-CRISIS-IRAQ-OIL_2026_03_23_23_24_14.JPG')"></div><div class="headline-info"><div class="headline-category">Economy</div><div class="headline-title">Oil Slides and Stocks Climb on Trump's Iran Reprieve</div><div class="headline-meta">Karen Brettell • March 22, 2026</div></div></a>
              <a class="headline-card news-item" data-category="environment" data-date="2026-03-08" href="#"><span class="headline-rank">04</span><div class="headline-thumb" style="background-image:url('https://i.guim.co.uk/img/media/803a439a4f1467d1164e173074260a81f0bd851e/0_150_2393_1436/master/2393.jpg?width=465&dpr=1&s=none&crop=none')"></div><div class="headline-info"><div class="headline-category">Environment</div><div class="headline-title">Arctic Ice Melting Faster Than Predicted, Scientists Warn</div><div class="headline-meta">Fiona Harvey • March 08, 2026</div></div></a>
              <a class="headline-card news-item" data-category="health" data-date="2026-03-19" href="#"><span class="headline-rank">05</span><div class="headline-thumb" style="background-image:url('https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=200')"></div><div class="headline-info"><div class="headline-category">Health</div><div class="headline-title">New COVID-19 Variant Monitored by WHO</div><div class="headline-meta">Helen Branswell • March 19, 2026</div></div></a>
            </div>
          </div>
        </div>

        <!-- NEWSLETTER -->
        <div class="sidebar-box">
          <div class="newsletter-inset">
            <h3>Stay in the Loop</h3>
            <p>Get the day's most important world news delivered to your inbox every morning — free, no noise.</p>
            <input class="newsletter-input" type="email" placeholder="Enter your email address">
            <button class="newsletter-btn">Subscribe Now</button>
            <p class="newsletter-note">No spam. Unsubscribe any time.</p>
          </div>
        </div>

      </aside>
    </div><!-- /main-layout -->

    <!-- PHOTOJOURNALISM -->
    <section class="photo-journal-section">
      <div class="section-header">
        <div class="section-header-top"><h2 class="section-title">Photojournalism</h2><a href="#" class="section-link">Full Gallery →</a></div>
        <div class="section-header-line"></div>
      </div>
      <div class="photo-masonry">
        <article class="photo-item size-xl news-item" data-category="society" data-date="2026-03-03"><div class="photo-img" style="background-image:url('https://www.columbiaspectator.com/resizer/v2/BFQERWT6DFFNNFU675RIWNDSNA.jpg?auth=02d0383624ad2a28ee6e1179507920ea9476c62093984d541ee0d8b76d1cbc82')"></div><div class="photo-overlay"><span class="photo-cat-pill">Society</span><div class="photo-loc-row">📍 New York, USA · March 03, 2026</div><p class="photo-cap">Protesters rally at City Hall against proposed NYPD buffer zone legislation restricting demonstrations near schools and places of worship.</p><span class="photo-credit">Photo: Skyler Gluck / UrbanPulse</span></div></article>
        <article class="photo-item size-tall news-item" data-category="humanity" data-date="2026-03-07"><div class="photo-img" style="background-image:url('https://www.kobotoolbox.org/assets/images/blog/krcs-kenya-01.jpg')"></div><div class="photo-overlay"><span class="photo-cat-pill">Humanity</span><div class="photo-loc-row">📍 Nairobi, Kenya · March 07, 2026</div><p class="photo-cap">A Kenya Red Cross Society volunteer assists a community member navigating a flooded area during the heavy rains and flooding crisis.</p><span class="photo-credit">Photo: Sayed Hassib / UrbanPulse</span></div></article>
        <article class="photo-item size-md news-item" data-category="economy" data-date="2026-03-21"><div class="photo-img" style="background-image:url('https://ijnet.org/sites/default/files/styles/full_width_node/public/migrated/2017/12/photographer.jpg?itok=HL__GFXv')"></div><div class="photo-overlay"><span class="photo-cat-pill">Economy</span><div class="photo-loc-row">📍 Washington, USA</div><p class="photo-cap">An exploration of the financial challenges faced by photojournalists worldwide in an evolving media landscape.</p><span class="photo-credit">Photo: Alex Potter / UrbanPulse</span></div></article>
        <article class="photo-item size-md news-item" data-category="humanity" data-date="2026-03-05"><div class="photo-img" style="background-image:url('https://images.squarespace-cdn.com/content/v1/5d0dc22f70b70c00015d510a/1579611302969-92244A7OWXJ9E9HC5GI1/image-asset.jpeg?format=2500w')"></div><div class="photo-overlay"><span class="photo-cat-pill">Humanity</span><div class="photo-loc-row">📍 Luzon, Philippines · March 05, 2026</div><p class="photo-cap">A visual journey along the roadside in the Philippines, capturing everyday life and overlooked realities of local communities.</p><span class="photo-credit">Photo: Hans Erickson Lim / UrbanPulse</span></div></article>
        <article class="photo-item size-sm news-item" data-category="health" data-date="2026-03-18"><div class="photo-img" style="background-image:url('https://image3.photobiz.com/8929/32_20210222193341_7867839_large.jpg')"></div><div class="photo-overlay"><span class="photo-cat-pill">Health</span><div class="photo-loc-row">📍 Miami, Florida · March 13, 2026</div><p class="photo-cap">A hospital staff member maintains sterile and safe conditions for patients and healthcare workers.</p><span class="photo-credit">Photo: Joshua Prezant / UrbanPulse</span></div></article>
        <article class="photo-item size-sm news-item" data-category="humanity" data-date="2026-03-17"><div class="photo-img" style="background-image:url('https://dims.apnews.com/dims4/default/4478e54/2147483647/strip/true/crop/6000x4000+0+0/resize/2720x1814!/format/webp/quality/90/?url=https%3A%2F%2Fassets.apnews.com%2Faa%2Fd6%2Fd2840cc34cfc268db80cb6f3f1c3%2Fca7700d8c6ee431788013ae57e1874c2')"></div><div class="photo-overlay"><span class="photo-cat-pill">Humanity</span><div class="photo-loc-row">📍 Kabul, Afghanistan · March 17, 2026</div><p class="photo-cap">Two uniformed personnel walk amid rubble, illustrating the aftermath of destruction in a conflict-affected area.</p><span class="photo-credit">Photo: Siddiqullah Alizai / UrbanPulse</span></div></article>
        <article class="photo-item size-sm news-item" data-category="environment" data-date="2026-03-19"><div class="photo-img" style="background-image:url('https://blog.adobe.com/en/publish/2021/10/19/media_10c4d05d6d9f9053722a8676cda3a3dd02fc6f586.jpg?width=750&format=jpg&optimize=medium')"></div><div class="photo-overlay"><span class="photo-cat-pill">Environment</span><div class="photo-loc-row">📍 Kenya, East Africa · March 19, 2026</div><p class="photo-cap">Conservation photography as a tool to raise awareness about environmental threats and advocate for protection of nature and wildlife.</p><span class="photo-credit">Photo: Mohamed Elashi / UrbanPulse</span></div></article>
        <article class="photo-item size-tall news-item" data-category="humanity" data-date="2026-03-16"><div class="photo-img" style="background-image:url('https://www.1854.photography/wp-content/uploads/2023/06/OTW_tiles14.jpg')"></div><div class="photo-overlay"><span class="photo-cat-pill">Humanity</span><div class="photo-loc-row">📍 Tehran, Iran · March 16, 2026</div><p class="photo-cap">An intimate portrayal of Iranian identity, capturing moments of resilience, grief, and everyday life.</p><span class="photo-credit">Photo: Parisa Azadi / UrbanPulse</span></div></article>
        <article class="photo-item size-xl news-item" data-category="humanity" data-date="2026-03-14"><div class="photo-img" style="background-image:url('https://cdn.theatlantic.com/thumbor/d-6Dl0M3iTRvvHk73OgfQEMOalo=/344x0:5848x4128/1200x900/media/img/mt/2026/03/G_2265951122-2/original.jpg')"></div><div class="photo-overlay"><span class="photo-cat-pill">Humanity</span><div class="photo-loc-row">📍 Addis Ababa · March 14, 2026</div><p class="photo-cap">Five members of Team USA's para cross-country team celebrate on the podium with their gold medals.</p><span class="photo-credit">Photo: Marco Mantovani / UrbanPulse</span></div></article>
        <article class="photo-item size-md news-item" data-category="humanity" data-date="2026-03-12"><div class="photo-img" style="background-image:url('https://www.rcrc-resilience-southeastasia.org/wp-content/uploads/2016/10/Koppu_Flood-affected-residents-of-Barangay-Delfin-Albano-Isabela-receive-relief-goods-frm-Red-Cross-Oct-20-2015-October-2015-c-Noel-Celis-IFRC-1024x659.jpg')"></div><div class="photo-overlay"><span class="photo-cat-pill">Humanity</span><div class="photo-loc-row">📍 Isabela, Philippines · March 12, 2026</div><p class="photo-cap">Flood-affected residents receive relief goods from the Red Cross following Typhoon devastation.</p><span class="photo-credit">Photo: Noel Celis / UrbanPulse</span></div></article>
        <article class="photo-item size-md news-item" data-category="environment" data-date="2026-03-10"><div class="photo-img" style="background-image:url('https://i.cbc.ca/ais/1.1545929,1386884819000/full/max/0/default.jpg?im=Crop%2Crect%3D%280%2C0%2C1180%2C663%29%3B')"></div><div class="photo-overlay"><span class="photo-cat-pill">Environment</span><div class="photo-loc-row">📍 Greenland · March 10, 2026</div><p class="photo-cap">Melting Arctic sea ice highlights the accelerating impacts of climate change on fragile polar ecosystems.</p><span class="photo-credit">Photo: Anya Berkut / UrbanPulse</span></div></article>
      </div>
    </section>

  </div><!-- /page-wrapper -->

  <footer class="footer">
    <div class="footer-container">
      <div class="footer-content">
        <div class="footer-section"><h3>UrbanPulse</h3><p>Independent journalism you can trust. Delivering truth in every story since 2026.</p><div class="footer-social"><a href="#" aria-label="Facebook">FB</a><a href="#" aria-label="Twitter">TW</a><a href="#" aria-label="Instagram">IG</a><a href="#" aria-label="Github">GH</a></div></div>
        <div class="footer-section"><h4>Categories</h4><ul><li><a href="technology.php">Technology</a></li><li><a href="sports.php">Sports</a></li><li><a href="entertainment.php">Entertainment</a></li><li><a href="worldnews.php">World News</a></li></ul></div>
        <div class="footer-section"><h4>Company</h4><ul><li><a href="about.php">About Us</a></li><li><a href="contact.php">Contact</a></li><li><a href="#">Careers</a></li><li><a href="#">Advertise</a></li></ul></div>
        <div class="footer-section"><h4>Pledge</h4><p id="pledge">We, the UrbanPulse team, pledge to deliver news that keeps people informed, aware, and always updated. Inspired by our school's champion radio broadcasting team, we carry the same goal: to share information clearly, quickly, and with purpose.</p></div>
      </div>
      <div class="footer-bottom"><p>&copy; 2026 UrbanPulse News. All rights reserved.</p></div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="burger.js"></script>
  <script src="theme.js"></script>
  <script src="search.js"></script>
  <script src="pulse-features.js"></script>
  <script src="editorial-tools.js"></script>
  <script>
    const TODAY       = '2026-03-24';
    const WEEK_START  = '2026-03-18';
    const MONTH_START = '2026-03-01';

    function applyPageFilter() {
      const cat  = document.getElementById('categoryFilter').value;
      const date = document.getElementById('dateFilter').value;
      let count  = 0;
      document.querySelectorAll('.news-item').forEach(item => {
        const matchCat  = cat === 'all' || item.dataset.category === cat;
        const itemDate  = item.dataset.date || '';
        let matchDate   = true;
        if (date === 'today')      matchDate = itemDate === TODAY;
        if (date === 'this-week')  matchDate = itemDate >= WEEK_START  && itemDate <= TODAY;
        if (date === 'this-month') matchDate = itemDate >= MONTH_START && itemDate <= TODAY;
        const show = matchCat && matchDate;
        item.style.display = show ? (item.classList.contains('headline-card') ? 'grid' : '') : 'none';
        if (show) count++;
      });
      const el = document.getElementById('filterResults');
      if (el) el.textContent = (cat !== 'all' || date !== 'all') ? count + ' article' + (count !== 1 ? 's' : '') : '';
      let rank = 1;
      document.querySelectorAll('#headlineList .headline-card').forEach(card => {
        if (card.style.display !== 'none') card.querySelector('.headline-rank').textContent = String(rank++).padStart(2, '0');
      });
    }

    document.getElementById('categoryFilter').addEventListener('change', applyPageFilter);
    document.getElementById('dateFilter').addEventListener('change', applyPageFilter);

    document.querySelectorAll('.chip').forEach(chip => {
      chip.addEventListener('click', () => {
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        const region = chip.dataset.region;
        document.querySelectorAll('.map-item').forEach(item => {
          item.style.display = (region === 'all' || item.dataset.region === region) ? 'flex' : 'none';
        });
        document.querySelectorAll('.map-hotspot').forEach(spot => {
          spot.classList.toggle('dimmed', !(region === 'all' || spot.dataset.region === region));
        });
        mapStoryPanel.classList.remove('open');
        mapStoryPanel.dataset.active = '';
        document.querySelectorAll('.map-hotspot').forEach(s => s.classList.remove('active-spot'));
      });
    });

    const mapStoryPanel = document.getElementById('mapStoryPanel');
    const mapStoryClose = document.getElementById('mapStoryClose');

    document.querySelectorAll('.map-hotspot').forEach(spot => {
      spot.addEventListener('click', () => {
        document.querySelectorAll('.map-hotspot').forEach(s => s.classList.remove('active-spot'));
        if (mapStoryPanel.classList.contains('open') && mapStoryPanel.dataset.active === spot.dataset.title) {
          mapStoryPanel.classList.remove('open');
          mapStoryPanel.dataset.active = '';
          return;
        }
        document.getElementById('mapStoryCat').textContent   = spot.dataset.cat;
        document.getElementById('mapStoryTitle').textContent = spot.dataset.title;
        document.getElementById('mapStoryDesc').textContent  = spot.dataset.desc;
        document.getElementById('mapStoryMeta').textContent  = spot.dataset.meta;
        document.getElementById('mapStoryLink').href         = spot.dataset.link;
        mapStoryPanel.dataset.active = spot.dataset.title;
        mapStoryPanel.classList.add('open');
        spot.classList.add('active-spot');
      });
    });

    mapStoryClose.addEventListener('click', () => {
      mapStoryPanel.classList.remove('open');
      mapStoryPanel.dataset.active = '';
      document.querySelectorAll('.map-hotspot').forEach(s => s.classList.remove('active-spot'));
    });
  </script>
</body>
</html>