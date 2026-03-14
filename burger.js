(() => {
		const body = document.body;
		const toggleBtn = document.getElementById('menuToggle');
		const closeBtn  = document.getElementById('menuClose');
		const menu      = document.getElementById('burgerMenu');
		const overlay   = document.getElementById('menuOverlay');

		if (!toggleBtn || !closeBtn || !menu || !overlay) return;

		let lastFocus = null;

		const focusableSelector = [
			'a[href]',
			'button:not([disabled])',
			'textarea:not([disabled])',
			'input:not([disabled])',
			'select:not([disabled])',
			'[tabindex]:not([tabindex="-1"])'
		].join(',');

		function setActiveLink() {
			const path = (window.location.pathname.split('/').pop() || 'home.html').toLowerCase();
			menu.querySelectorAll('.burger-link[data-nav]').forEach(a => {
				const href = (a.getAttribute('href') || '').toLowerCase();
				a.classList.toggle('active', href === path);
			});
		}

		function setMenuState(open) {
			toggleBtn.setAttribute('aria-expanded', String(open));
			menu.classList.toggle('is-open', open);
			overlay.classList.toggle('is-open', open);

			if (open) {
				overlay.hidden = false;
				menu.removeAttribute('inert');
				menu.setAttribute('aria-hidden', 'false');
				body.classList.add('menu-open');
				lastFocus = document.activeElement;
				setActiveLink();

				const first = menu.querySelector(focusableSelector);
				first && first.focus({ preventScroll: true });
			} else {
				overlay.hidden = true;
				menu.setAttribute('inert', '');
				menu.setAttribute('aria-hidden', 'true');
				body.classList.remove('menu-open');

				if (lastFocus && typeof lastFocus.focus === 'function') {
					lastFocus.focus({ preventScroll: true });
				}
			}
		}

		function openMenu(){ setMenuState(true); }
		function closeMenu(){ setMenuState(false); }

		toggleBtn.addEventListener('click', () => {
			const isOpen = toggleBtn.getAttribute('aria-expanded') === 'true';
			isOpen ? closeMenu() : openMenu();
		});

		closeBtn.addEventListener('click', closeMenu);
		overlay.addEventListener('click', closeMenu);

		document.addEventListener('keydown', (e) => {
			const isOpen = toggleBtn.getAttribute('aria-expanded') === 'true';
			if (!isOpen) return;

			if (e.key === 'Escape') {
				e.preventDefault();
				closeMenu();
				return;
			}

			if (e.key !== 'Tab') return;

			const focusables = Array.from(menu.querySelectorAll(focusableSelector))
				.filter(el => !el.hasAttribute('disabled'));

			if (!focusables.length) return;

			const first = focusables[0];
			const last  = focusables[focusables.length - 1];

			if (e.shiftKey && document.activeElement === first) {
				e.preventDefault();
				last.focus();
			} else if (!e.shiftKey && document.activeElement === last) {
				e.preventDefault();
				first.focus();
			}
		});

		menu.querySelectorAll('[data-nav]').forEach(a => {
			a.addEventListener('click', () => closeMenu());
		});
	})();