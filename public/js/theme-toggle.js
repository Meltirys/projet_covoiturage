// Applique le thème sauvegardé au plus tôt (avant le paint)
(function () {
  if (localStorage.getItem("theme") === "dark") {
    document.documentElement.classList.add("dark");
  }
})();

function toggleTheme() {
  const isDark = document.documentElement.classList.toggle("dark");
  localStorage.setItem("theme", isDark ? "dark" : "light");
  updateToggleIcon(isDark);
}

function updateToggleIcon(isDark) {
  const btn = document.getElementById("theme-toggle-btn");
  if (btn)
    btn.innerHTML = isDark
      ? '<i class="fa-solid fa-sun" style="color: var(--color-gold)"></i>'
      : '<i class="fa-solid fa-moon" style="color: var(--color-gold)"></i>';
}

document.addEventListener("DOMContentLoaded", () => {
  const isDark = document.documentElement.classList.contains("dark");
  updateToggleIcon(isDark);
});
