import { createApp } from 'vue';
import Gallery from './components/Gallery.js';
const menu = document.querySelector('#menu-toggle');
const nav = document.querySelector('#main-nav');
menu?.addEventListener('click', () => nav?.classList.toggle('is-open'));
function mount() {
 document.querySelectorAll('[data-vue-gallery]').forEach(el => {
  if (!el.__vue_app__) createApp(Gallery, { items: JSON.parse(el.dataset.items || '[]') }).mount(el);
 });
}
mount();
document.addEventListener('livewire:navigated', mount);
