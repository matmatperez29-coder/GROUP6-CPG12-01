document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Search Functionality Across Articles [cite: 152]
    const searchToggle = document.getElementById('searchToggle');
    const searchBar = document.getElementById('searchBar');
    const searchInput = document.getElementById('searchInput');

    if (searchToggle && searchBar && searchInput) {
        searchToggle.addEventListener('click', (e) => {
            // Prevent the search bar from closing when clicking inside the input
            if (e.target === searchInput) return; 
            
            searchBar.style.display = searchBar.style.display === 'none' ? 'block' : 'none';
            if (searchBar.style.display === 'block') {
                searchInput.focus();
            }
        });

        // Live filtering based on search input
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const articles = document.querySelectorAll('.hero-story, .story-card, .compact-story, .category-card, .more-card');

            articles.forEach(article => {
                const text = article.textContent.toLowerCase();
                article.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // 2. Breaking News Ticker Hover Pause [cite: 159]
    const ticker = document.querySelector('.BNcontent');
    if (ticker) {
        ticker.addEventListener('mouseenter', () => ticker.style.animationPlayState = 'paused');
        ticker.addEventListener('mouseleave', () => ticker.style.animationPlayState = 'running');
    }

    // 3. Bookmark / Save Article Feature (LocalStorage) [cite: 157]
    const setupBookmarks = () => {
        const stories = document.querySelectorAll('.story-card, .category-card, .hero-story');
        
        stories.forEach((story, index) => {
            // Create a unique ID for each article card based on index for demonstration
            const articleId = 'article-' + index; 
            
            const btn = document.createElement('button');
            btn.className = 'bookmark-btn';
            btn.style.cssText = 'background:none; border:none; color:var(--color-secondary); font-size:0.8rem; font-weight:bold; cursor:pointer; margin-top:10px; padding:0;';
            
            // Check localStorage to see if it's already saved
            let savedArticles = JSON.parse(localStorage.getItem('urbanPulseSaved')) || [];
            
            if (savedArticles.includes(articleId)) {
                btn.innerHTML = '★ Saved to Bookmarks';
                btn.classList.add('saved');
            } else {
                btn.innerHTML = '☆ Save Article';
            }

            btn.addEventListener('click', (e) => {
                e.preventDefault();
                let currentSaved = JSON.parse(localStorage.getItem('urbanPulseSaved')) || [];
                
                if (currentSaved.includes(articleId)) {
                    // Remove from saved
                    currentSaved = currentSaved.filter(id => id !== articleId);
                    btn.innerHTML = '☆ Save Article';
                    btn.classList.remove('saved');
                } else {
                    // Add to saved
                    currentSaved.push(articleId);
                    btn.innerHTML = '★ Saved to Bookmarks';
                    btn.classList.add('saved');
                }
                localStorage.setItem('urbanPulseSaved', JSON.stringify(currentSaved));
            });

            // Append button to the content area
            const contentArea = story.querySelector('.story-content, .hero-content') || story;
            contentArea.appendChild(btn);
        });
    };
    setupBookmarks();

    // 4. Reading Progress Indicator [cite: 163]
    const createProgressBar = () => {
        const bar = document.createElement('div');
        bar.id = 'reading-progress';
        bar.style.cssText = 'position: fixed; top: 0; left: 0; height: 4px; background-color: var(--color-secondary); width: 0%; z-index: 2000; transition: width 0.2s ease-out;';
        document.body.appendChild(bar);

        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            bar.style.width = scrolled + '%';
        });
    };
    createProgressBar();

    // 5. Read More / Read Less Toggle for Article Previews [cite: 154]
    const setupReadMore = () => {
        const summaries = document.querySelectorAll('.story-summary, .hero-summary, .category-card p');
        
        summaries.forEach(summary => {
            const originalText = summary.textContent;
            // Only truncate if the text is longer than 100 characters
            if (originalText.length > 100) {
                const truncatedText = originalText.substring(0, 100) + '...';
                summary.textContent = truncatedText;

                const toggleBtn = document.createElement('span');
                toggleBtn.innerHTML = ' Read More';
                toggleBtn.style.cssText = 'color: var(--color-secondary); cursor: pointer; font-weight: bold; font-size: 0.85rem;';
                
                let isExpanded = false;

                toggleBtn.addEventListener('click', () => {
                    isExpanded = !isExpanded;
                    if (isExpanded) {
                        summary.textContent = originalText;
                        toggleBtn.innerHTML = ' Read Less';
                    } else {
                        summary.textContent = truncatedText;
                        toggleBtn.innerHTML = ' Read More';
                    }
                    summary.appendChild(toggleBtn);
                });

                summary.appendChild(toggleBtn);
            }
        });
    };
    // Uncomment the line below to activate read more/less once you have actual summary text populated!
    // setupReadMore(); 

    // 6. Filter Articles by Category [cite: 153]
    const setupCategoryFilters = () => {
        const navLinks = document.querySelectorAll('.main-nav a');
        const articles = document.querySelectorAll('.story-card, .category-card, .compact-story, .more-card');

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const targetText = e.target.textContent.trim().toLowerCase();
                
                // Allow Home, About, and Contact to navigate normally
                if (['home', 'about', 'contact'].includes(targetText)) return; 
                
                e.preventDefault(); // Stop normal navigation for category links to show live filtering

                // Update active navigation class
                navLinks.forEach(l => l.classList.remove('active'));
                e.target.classList.add('active');

                // Filter the grid
                articles.forEach(article => {
                    // Try to find category tags inside the article
                    const tags = article.querySelectorAll('.category-tag, .compact-meta span:first-child');
                    let match = false;
                    
                    if (tags.length === 0) {
                        // Fallback: check if the text content contains the category word
                        if(article.textContent.toLowerCase().includes(targetText)) match = true;
                    } else {
                        tags.forEach(tag => {
                            if (tag.textContent.trim().toLowerCase().includes(targetText)) match = true;
                        });
                    }

                    article.style.display = match ? '' : 'none';
                });
            });
        });
    };
    setupCategoryFilters();
});