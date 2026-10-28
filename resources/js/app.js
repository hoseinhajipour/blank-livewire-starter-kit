const menu = document.querySelector('#menu-toggle');
const nav = document.querySelector('#main-nav');
menu?.addEventListener('click', () => nav?.classList.toggle('is-open'));

const gallery = document.querySelector('[data-gallery]');
if (gallery) {
  const images = JSON.parse(gallery.dataset.gallery);
  const image = document.querySelector('#gallery-image');
  const counter = document.querySelector('#gallery-counter');
  let active = 0;
  const render = () => {
    image.src = `/images/${images[active]}`;
    counter.textContent = `۰${active + 1} / ۰${images.length}`;
  };
  document.querySelector('[data-gallery-prev]')?.addEventListener('click', () => { active = (active + images.length - 1) % images.length; render(); });
  document.querySelector('[data-gallery-next]')?.addEventListener('click', () => { active = (active + 1) % images.length; render(); });
  setInterval(() => { active = (active + 1) % images.length; render(); }, 5200);
}
