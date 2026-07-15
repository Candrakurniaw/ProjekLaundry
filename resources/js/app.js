import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  const autoHide = (id, delay) => {
    const el = document.getElementById(id);
    if (el) setTimeout(() => el.remove(), delay);
  };
  autoHide('flashMessage', 4000);
  autoHide('flashError', 4000);
  autoHide('errorsList', 6000);
});
