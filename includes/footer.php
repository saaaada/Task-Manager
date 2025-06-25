</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
  <small>&copy; <?= date('Y') ?> Task Manager. All Rights Reserved.</small>
</footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Dark Mode Script -->
<script>
  const toggleBtn = document.getElementById('themeToggle');
  const htmlTag = document.documentElement;

  toggleBtn.addEventListener('click', () => {
    const current = htmlTag.getAttribute('data-bs-theme') || 'dark'; // default is dark
    const newTheme = current === 'dark' ? 'light' : 'dark';

    htmlTag.setAttribute('data-bs-theme', newTheme);
    toggleBtn.textContent = newTheme === 'dark' ? '☀️' : '🌙'; // ☀️ = dark mode is on
  });
</script>


</body>
</html>
