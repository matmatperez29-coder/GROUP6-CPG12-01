(() => {
  'use strict';

  const STORAGE_KEY = 'up_theme';
  const root = document.documentElement;
  const toggle = document.getElementById('themeToggle');

  function getStoredTheme() {
    try {
      return localStorage.getItem(STORAGE_KEY);
    } catch (error) {
      return null;
    }
  }

  function setStoredTheme(theme) {
    try {
      localStorage.setItem(STORAGE_KEY, theme);
    } catch (error) {}
  }

  function currentTheme() {
    return root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
  }

  function updateToggle(theme) {
    if (!toggle) return;
    const isDark = theme === 'dark';
    toggle.setAttribute('aria-pressed', String(isDark));
    toggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
    toggle.setAttribute('title', isDark ? 'Switch to light mode' : 'Switch to dark mode');
  }

  function applyTheme(theme) {
    if (theme === 'dark') {
      root.setAttribute('data-theme', 'dark');
    } else {
      root.removeAttribute('data-theme');
    }
    updateToggle(theme);
  }

  applyTheme(getStoredTheme() === 'dark' ? 'dark' : 'light');

  if (toggle) {
    toggle.addEventListener('click', () => {
      const nextTheme = currentTheme() === 'dark' ? 'light' : 'dark';
      setStoredTheme(nextTheme);
      applyTheme(nextTheme);
    });
  }

  window.addEventListener('storage', (event) => {
    if (event.key === STORAGE_KEY) {
      applyTheme(event.newValue === 'dark' ? 'dark' : 'light');
    }
  });
})();