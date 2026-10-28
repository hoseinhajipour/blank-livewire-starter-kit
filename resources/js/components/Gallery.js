import { h, ref, computed, onMounted, onBeforeUnmount, nextTick, Teleport } from 'vue';
import './gallery.css';
export default {
 props: { items: { type: Array, default: () => [] } },
 setup(props) {
  const viewport = ref(null), rail = ref(null), group = ref(null), dialog = ref(null);
  const active = ref(null), hover = ref(false), focus = ref(false), paused = ref(false), repeat = ref(2);
  const slides = computed(() => Array.from({length:repeat.value}, () => props.items).flat());
  let frame, observer, time = 0, offset = 0, width = 0, opener, overflow;
  const preference = matchMedia('(prefers-reduced-motion: reduce)');
  function paint() { if (rail.value) rail.value.style.transform = `translate3d(${-offset}px,0,0)`; }
  function measure() {
   const available = viewport.value.clientWidth;
   const card = window.innerWidth <= 600 ? available : (available - 36) / 3;
   viewport.value.style.setProperty('--card-width', `${card}px`);
   repeat.value = Math.max(1, Math.ceil((available + card + 18) / ((card + 18) * Math.max(1, props.items.length))));
   nextTick(() => { width = group.value.getBoundingClientRect().width; offset = width ? offset % width : 0; paint(); });
  }
  function tick(now) {
   const elapsed = time ? Math.min((now-time)/1000, .05) : 0; time = now;
   if (width && !hover.value && !focus.value && !paused.value && active.value === null && !preference.matches) {
    offset = (offset + elapsed * 18) % width; paint();
   }
   frame = requestAnimationFrame(tick);
  }
  function step(direction) {
   if (!width) return;
   const card = group.value.querySelector('button').getBoundingClientRect().width + 18;
   offset = ((offset + card * direction) % width + width) % width; paint();
  }
  function open(index,event) {
   opener = event.currentTarget; overflow = document.body.style.overflow;
   active.value = index % props.items.length; document.body.style.overflow = 'hidden';
   nextTick(() => dialog.value.focus());
  }
  function close() { active.value = null; document.body.style.overflow = overflow || ''; opener?.focus({preventScroll:true}); }
  function next(direction) { active.value = (active.value + direction + props.items.length) % props.items.length; }
  function keys(event) {
   if(event.key === 'Escape') close();
   if(event.key === 'ArrowRight') next(1);
   if(event.key === 'ArrowLeft') next(-1);
   if(event.key === 'Tab') {
    const buttons = [...dialog.value.querySelectorAll('button')];
    if(event.shiftKey && (document.activeElement === buttons[0] || document.activeElement === dialog.value)) {event.preventDefault(); buttons.at(-1).focus();}
    else if(!event.shiftKey && document.activeElement === buttons.at(-1)) {event.preventDefault(); buttons[0].focus();}
   }
  }
  onMounted(() => { observer = new ResizeObserver(measure); observer.observe(viewport.value); measure(); frame = requestAnimationFrame(tick); });
  onBeforeUnmount(() => { cancelAnimationFrame(frame); observer?.disconnect(); if(active.value !== null) document.body.style.overflow = overflow || ''; });
  const button = (label,text,action,cls='') => h('button',{type:'button',class:cls,'aria-label':label,onClick:action},text);
  return () => !props.items.length ? null : h('div',{class:'vue-clinic-gallery',dir:'rtl'},[
   h('div',{class:'vcg-viewport',ref:viewport,dir:'ltr',onMouseenter:()=>hover.value=true,onMouseleave:()=>hover.value=false,onFocusin:()=>focus.value=true,onFocusout:e=>{if(!e.currentTarget.contains(e.relatedTarget)) focus.value=false;}},[
    h('div',{class:'vcg-rail',ref:rail},[0,1].map(copy=>h('div',{class:'vcg-group',ref:copy===0?group:undefined,key:copy},slides.value.map((item,i)=>h('button',{
     class:'vcg-card',type:'button',key:i,tabindex:copy||i>=props.items.length?-1:0,'aria-label':`بزرگ‌نمایی ${item.title}`,onClick:e=>open(i,e)
    },[h('img',{src:item.src,alt:item.alt,draggable:false}),h('span',{class:'vcg-caption',dir:'rtl'},item.title),h('span',{class:'vcg-zoom','aria-hidden':'true'},'+')])))))
   ]),
   h('div',{class:'vcg-controls'},[button('تصاویر قبلی','→',()=>step(-1)),button(paused.value?'شروع حرکت':'توقف حرکت',paused.value?'شروع حرکت':'توقف حرکت',()=>paused.value=!paused.value,'vcg-pause'),button('تصاویر بعدی','←',()=>step(1))]),
   active.value===null?null:h(Teleport,{to:'body'},h('div',{class:'vcg-modal',role:'dialog','aria-modal':'true','aria-label':props.items[active.value].title,tabindex:-1,ref:dialog,onKeydown:keys,onClick:e=>{if(e.target===e.currentTarget)close();}},[
    button('بستن تصویر','×',close,'vcg-close'),button('تصویر قبلی','→',()=>next(-1)),h('figure',[h('img',{src:props.items[active.value].src,alt:props.items[active.value].alt}),h('figcaption',props.items[active.value].title)]),button('تصویر بعدی','←',()=>next(1))
   ]))
  ]);
 }
};
