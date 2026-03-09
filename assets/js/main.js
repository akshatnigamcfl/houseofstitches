// related product slider
$(document).ready(function () {
  $('.owl-carousel.offerproduct').owlCarousel({
    loop: true,
    margin: 35,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    nav: false,
    responsive: {
      0: {
        items: 2
      },
      600: {
        items: 3
      },
      1000: {
        items: 4
      },
    }
  })
});

// sticky header js
window.addEventListener("scroll", function () {
  const header = document.querySelector(".site-header");
  header.classList.toggle("headerfix", window.scrollY > 50);
});

// toltip js
document.addEventListener('DOMContentLoaded', () => {
  tippy('[data-tippy-content]', {
    trigger: 'mouseenter',
    placement: 'top',
    animation: 'shift-away',
    theme: 'light-border',
    delay: [100, 50],
  });
});

// infinite text effect 
(function () {
  const tracks = [
    document.querySelector('.text-single-one'),
    document.querySelector('.text-single-two')
  ].filter(Boolean);
  const loops = tracks.map(track => {
    const items = track.querySelectorAll('.js-text');
    const loop = horizontalLoop(items, {
      repeat: -1,
      speed: 1.5,
      draggable: true,
      reversed: false,
      paddingRight: parseFloat(getComputedStyle(items[0]).marginRight) || 0
    });
    track.addEventListener('mouseenter', () => loop.pause());
    track.addEventListener('mouseleave', () => loop.play());
    return loop;
  });
  let currentScroll = window.pageYOffset, scrollDirection = 1;
  window.addEventListener('scroll', () => {
    const direction = window.pageYOffset > currentScroll ? 1 : -1;
    if (direction !== scrollDirection) {
      loops.forEach(loop => gsap.to(loop, { timeScale: direction, overwrite: true }));
      scrollDirection = direction;
    }
    currentScroll = window.pageYOffset;
  });
  function horizontalLoop(items, config) {
    items = gsap.utils.toArray(items);
    config = config || {};
    const tl = gsap.timeline({
      repeat: config.repeat,
      paused: config.paused,
      defaults: { ease: "none" },
      onReverseComplete: () => tl.totalTime(tl.rawTime() + tl.duration() * 100)
    });
    const length = items.length;
    const startX = items[0].offsetLeft;
    const times = [];
    const widths = [];
    const xPercents = [];
    let curIndex = 0;
    const pixelsPerSecond = (config.speed || 1) * 100;
    const snap = config.snap === false ? (v) => v : gsap.utils.snap(config.snap || 1);
    const populateWidths = () => items.forEach((el, i) => {
      widths[i] = parseFloat(gsap.getProperty(el, "width", "px"));
      xPercents[i] = snap((parseFloat(gsap.getProperty(el, "x", "px")) / widths[i]) * 100 + gsap.getProperty(el, "xPercent"));
    });
    const getTotalWidth = () => {
      const last = items[length - 1];
      return last.offsetLeft +
        (xPercents[length - 1] / 100) * widths[length - 1] -
        startX +
        last.offsetWidth * gsap.getProperty(last, "scaleX") +
        (parseFloat(config.paddingRight) || 0);
    };
    populateWidths();
    gsap.set(items, { xPercent: i => xPercents[i] });
    gsap.set(items, { x: 0 });
    let totalWidth = getTotalWidth();
    for (let i = 0; i < length; i++) {
      const item = items[i];
      const curX = (xPercents[i] / 100) * widths[i];
      const distanceToStart = item.offsetLeft + curX - startX;
      const distanceToLoop = distanceToStart + widths[i] * gsap.getProperty(item, "scaleX");
      tl.to(item, {
        xPercent: snap(((curX - distanceToLoop) / widths[i]) * 100),
        duration: distanceToLoop / pixelsPerSecond
      }, 0)
        .fromTo(item,
          { xPercent: snap(((curX - distanceToLoop + totalWidth) / widths[i]) * 100) },
          { xPercent: xPercents[i], duration: (curX - distanceToLoop + totalWidth - curX) / pixelsPerSecond, immediateRender: false },
          distanceToLoop / pixelsPerSecond
        )
        .add("label" + i, distanceToStart / pixelsPerSecond);
      times[i] = distanceToStart / pixelsPerSecond;
    }
    function toIndex(index, vars) {
      vars = vars || {};
      if (Math.abs(index - curIndex) > length / 2) index += index > curIndex ? -length : length; // shortest path
      const newIndex = gsap.utils.wrap(0, length, index);
      let time = times[newIndex];

      if ((time > tl.time()) !== (index > curIndex)) {
        vars.modifiers = { time: gsap.utils.wrap(0, tl.duration()) };
        time += tl.duration() * (index > curIndex ? 1 : -1);
      }
      curIndex = newIndex;
      vars.overwrite = true;
      return tl.tweenTo(time, vars);
    }
    tl.next = (vars) => toIndex(curIndex + 1, vars);
    tl.previous = (vars) => toIndex(curIndex - 1, vars);
    tl.current = () => curIndex;
    tl.toIndex = (idx, vars) => toIndex(idx, vars);
    tl.updateIndex = () => (curIndex = Math.round(tl.progress() * (items.length - 1)));
    tl.times = times;
    tl.progress(1, true).progress(0, true);
    if (config.reversed) { tl.vars.onReverseComplete(); tl.reverse(); }
    if (config.draggable && typeof Draggable === "function") {
      const proxy = document.createElement("div");
      let ratio, startProgress, draggable, dragSnap, roundFactor;
      const wrap = gsap.utils.wrap(0, 1);
      const align = () => tl.progress(wrap(startProgress + (draggable.startX - draggable.x) * ratio));
      const syncIndex = () => tl.updateIndex();
      draggable = Draggable.create(proxy, {
        trigger: items[0].parentNode,
        type: "x",
        onPress() {
          startProgress = tl.progress();
          tl.progress(0);
          populateWidths();
          totalWidth = getTotalWidth();
          ratio = 1 / totalWidth;
          dragSnap = totalWidth / items.length;
          roundFactor = Math.pow(10, ((dragSnap + "").split(".")[1] || "").length);
          tl.progress(startProgress);
        },
        onDrag: align,
        onThrowUpdate: align,
        inertia: !!window.InertiaPlugin,
        snap(value) {
          const n = Math.round(parseFloat(value) / dragSnap) * dragSnap * roundFactor;
          return (n - (n % 1)) / roundFactor;
        },
        onRelease: syncIndex,
        onThrowComplete: () => (gsap.set(proxy, { x: 0 }), syncIndex())
      })[0];
    }
    return tl;
  }
})();

// video effect js
(function () {
  const stage = document.querySelector(".video-stage");
  if (!stage) return;
  const root = document.documentElement;
  window.addEventListener("scroll", () => {
    const rect = stage.getBoundingClientRect();
    const scrollProgress = Math.min(Math.max(-rect.top / rect.height, 0), 1);
    const width = 100 - scrollProgress * 60;
    root.style.setProperty("--videoW", width + "%");
    const radius = scrollProgress * 20;
    root.style.setProperty("--videoR", radius + "px");
  });
})();

// about section effect js
(function () {
  const fixedTop = document.querySelector('.navbar.fixed-top');
  function syncNavHeight() {
    const h = fixedTop ? fixedTop.offsetHeight : 0;
    document.documentElement.style.setProperty('--nav-h', h + 'px');
  }
  window.addEventListener('load', syncNavHeight, { passive: true });
  window.addEventListener('resize', syncNavHeight, { passive: true });
  window.addEventListener('orientationchange', syncNavHeight, { passive: true });
  setTimeout(syncNavHeight, 250);
})();

// preloader js
window.addEventListener("load", function () {
  document.body.classList.add("loaded");

  setTimeout(() => {
    const wrapper = document.querySelector(".loader-wrapper");
    if (wrapper && wrapper.parentNode) {
      wrapper.parentNode.removeChild(wrapper);
    }
    document.body.style.overflow = "";
  }, 1500);
});

// modal popup js
window.addEventListener("load", function () {
  const modalElement = document.getElementById('roleModal');
  if (!modalElement) return;
  const roleModal = new bootstrap.Modal(modalElement, {
    backdrop: 'static',
    keyboard: false
  });
  setTimeout(() => {
    roleModal.show();
    document.body.classList.add('no-scroll');
  }, 2000);
  modalElement.addEventListener('hidden.bs.modal', () => {
    document.body.classList.remove('no-scroll');
  });
  const cards = document.querySelectorAll('.role-card');
  const continueBtn = document.getElementById('continueBtn');
  let selectedRole = null;
  cards.forEach(card => {
    card.addEventListener('click', () => {
      cards.forEach(c => c.classList.remove('active'));
      card.classList.add('active');
      selectedRole = card.dataset.role;
      continueBtn.disabled = false;
    });
  });
  document.getElementById('cancelBtn').addEventListener('click', () => {
    roleModal.hide();
  });
  continueBtn.addEventListener('click', () => {
    console.log('Selected role:', selectedRole);
    roleModal.hide();
  });
});

// scroll to top js
(function ($) {
  "use strict";
  $(document).ready(function () {
    "use strict";
    var progressPath = document.querySelector('.progress-wrap path');
    if (!progressPath) return;
    var pathLength = progressPath.getTotalLength();
    progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
    progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
    progressPath.style.strokeDashoffset = pathLength;
    progressPath.getBoundingClientRect();
    progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
    var updateProgress = function () {
      var scroll = $(window).scrollTop();
      var height = $(document).height() - $(window).height();
      var progress = pathLength - (scroll * pathLength / height);
      progressPath.style.strokeDashoffset = progress;
    }
    updateProgress();
    $(window).scroll(updateProgress);
    var offset = 50;
    var duration = 550;
    jQuery(window).on('scroll', function () {
      if (jQuery(this).scrollTop() > offset) {
        jQuery('.progress-wrap').addClass('active-progress');
      } else {
        jQuery('.progress-wrap').removeClass('active-progress');
      }
    });
    jQuery('.progress-wrap').on('click', function (event) {
      event.preventDefault();
      jQuery('html, body').animate({ scrollTop: 0 }, duration);
      return false;
    })
  });

})(jQuery);

// account sidebar js
document.addEventListener("DOMContentLoaded", () => {
  const s = document.getElementById("accountSidebar"),
    t = document.querySelector(".mobile-sidebar-toggle");
  if (!s || !t) return;
  t.onclick = e => { e.preventDefault(); s.classList.toggle("d-none"); };
  document.onclick = e => {
    if (window.innerWidth <= 991 && !s.contains(e.target) && !t.contains(e.target))
      s.classList.add("d-none");
  };
  window.onresize = () => window.innerWidth > 991 && s.classList.remove("d-none");
});

// password show hide js (safe for big main.js)
document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("click", function (e) {
    const icon = e.target.closest(".toggle-password");
    if (!icon) return;
    const input = icon.previousElementSibling;
    if (!input || input.tagName !== "INPUT") return;
    const isPassword = input.type === "password";
    input.type = isPassword ? "text" : "password";
    icon.classList.toggle("bi-eye", !isPassword);
    icon.classList.toggle("bi-eye-slash", isPassword);
  });
});

// Order slips UI 
(() => {
  document.addEventListener("DOMContentLoaded", () => {
    const TABLE_SELECTOR = "#orderTable";
    const SLIP_BASE_PATH = "/slips";
    const TYPE_CODE = { PO: "PO", GRN: "GRN", Invoice: "INV" };
    const table = document.querySelector(TABLE_SELECTOR);
    if (!table) {
      console.warn(`[slips] Table ${TABLE_SELECTOR} not found. Aborting.`);
      return;
    }
    const rows = table.querySelectorAll("tbody tr");
    if (!rows.length) {
      console.warn("[slips] No rows in #orderTable > tbody.");
      return;
    }
    const makeSlipLink = (orderId, label, enabled) => {
      const code = TYPE_CODE[label] || label;
      const el = document.createElement(enabled ? "a" : "span");
      el.className = "btn btn-outline-secondary btn-slip";
      const dot = document.createElement("span");
      dot.className = "dot " + (label === "PO" ? "po" : label === "GRN" ? "grn" : "inv");
      const txt = document.createElement("span");
      txt.textContent = label.toUpperCase();
      el.append(dot, txt);
      if (enabled) {
        const url = `${SLIP_BASE_PATH}/${orderId}/${code}.pdf`;
        el.href = url;
        el.download = `${orderId}_${code}.pdf`;
        el.rel = "noopener";
        el.target = "_blank";
        el.role = "button";
      } else {
        el.setAttribute("aria-disabled", "true");
        el.classList.add("disabled");
      }
      return el;
    };
    rows.forEach((row) => {
      const ds = row.dataset || {};
      const orderId = ds.order || row.getAttribute("data-order");
      const hasPO = (ds.hasPo ?? row.getAttribute("data-has-po")) === "true";
      const hasGRN = (ds.hasGrn ?? row.getAttribute("data-has-grn")) === "true";
      const hasINV = (ds.hasInvoice ?? row.getAttribute("data-has-invoice")) === "true";
      if (!orderId) {
        console.warn("[slips] Missing data-order on row:", row);
        return;
      }
      const slot = row.querySelector(".slips");
      if (!slot) {
        console.warn(`[slips] Missing .slips cell for ${orderId}`);
        return;
      }
      slot.replaceChildren(
        makeSlipLink(orderId, "PO", hasPO),
        makeSlipLink(orderId, "GRN", hasGRN),
        makeSlipLink(orderId, "Invoice", hasINV)
      );
      row.querySelector("[data-download-all]")?.addEventListener("click", (e) => {
        e.preventDefault();
        const links = slot.querySelectorAll("a.btn-slip");
        let i = 0;
        const openNext = () => {
          if (i >= links.length) return;
          links[i++].click();
          setTimeout(openNext, 300);
        };
        openNext();
      });
    });
  });
})();

// countdown timer js
(function () {
  if (!document.getElementById("days")) return;
  const offerDuration = 3 * 60 * 60 * 1000; // 3 hours
  const offerEndTime = new Date().getTime() + offerDuration;
  const countdownTimer = setInterval(() => {
    const now = new Date().getTime();
    const distance = offerEndTime - now;
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    document.getElementById("days").textContent = days.toString().padStart(2, '0');
    document.getElementById("hours").textContent = hours.toString().padStart(2, '0');
    document.getElementById("minutes").textContent = minutes.toString().padStart(2, '0');
    document.getElementById("seconds").textContent = seconds.toString().padStart(2, '0');
    if (distance < 0) {
      clearInterval(countdownTimer);
      document.querySelector(".countdown").innerHTML = "";
      document.querySelector(".offer-section").innerHTML += `<div class="expired">⚠️ Offer Expired — Stay Tuned for the Next Deal!</div>`;
    }
  }, 1000);
})();