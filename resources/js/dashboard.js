document.addEventListener('DOMContentLoaded', () => {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // staggered entrance for stat cards
  document.querySelectorAll('.soft-lift').forEach((item, index) => {
    item.style.opacity = '0';
    item.style.transform = 'translateY(8px)';
    item.style.transition = 'all 0.35s ease ' + (index * 0.05) + 's';
    setTimeout(() => {
      item.style.opacity = '1';
      item.style.transform = 'translateY(0)';
    }, 50);
  });

  // staggered slide-in for the receipt list
  document.querySelectorAll('.pd-item').forEach((item, index) => {
    item.style.transition = 'all 0.4s cubic-bezier(.2,.7,.3,1) ' + (0.15 + index * 0.06) + 's';
    setTimeout(() => {
      item.style.opacity = '1';
      item.style.transform = 'translateX(0)';
    }, 60);
  });

  // count-up animation for the stat numbers
  const formatRupiah = (n) => 'Rp ' + Math.round(n).toLocaleString('id-ID');
  const formatNumber = (n) => Math.round(n).toLocaleString('id-ID');

  document.querySelectorAll('.pd-count').forEach((el) => {
    const target = parseFloat(el.dataset.value || '0');
    const fmt = el.dataset.format === 'rupiah' ? formatRupiah : formatNumber;

    if (reduceMotion || !target) {
      el.textContent = fmt(target);
      return;
    }

    const duration = 900;
    const start = performance.now();
    const tick = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3); // ease-out-cubic
      el.textContent = fmt(target * eased);
      if (progress < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  });
});