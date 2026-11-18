(function () {
  const D = window.EKRAF_DATA;
  const CFG = window.EKRAF_CONFIG || {};
  const $ = (s, el = document) => el.querySelector(s);
  const $$ = (s, el = document) => [...el.querySelectorAll(s)];
  const esc = s => String(s ?? "").replace(/[&<>"']/g, c => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  const TONES = ["", "tone-sun", "tone-sky", "tone-leaf"];
  const photo = (src, cls = "", i = 0, alt = "") =>
    `<figure class="ph ${cls} ${TONES[i % TONES.length]}"><img src="${esc(src)}" alt="${esc(alt)}" loading="lazy" decoding="async" onerror="this.remove()"></figure>`;
  const delay = i => `style="--d:${Math.min(i, 8) * 90}ms"`;

  const MONTHS_SHORT = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV", "DES"];
  const MONTHS = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
  const parseISO = s => { const [y, m, d] = s.split("-").map(Number); return { y, m: m - 1, d }; };
  const key = (y, m, d) => `${y}-${String(m + 1).padStart(2, "0")}-${String(d).padStart(2, "0")}`;

  /* ===== Render dari data ===== */
  $("#subsektor-grid").innerHTML = D.subsektor
    .map((s, i) => `<div class="chip-s" style="--i:${i}"><span class="ico">${s.ico}</span><span class="chip-t">${esc(s.name)}</span></div>`).join("");

  $("#org-grid").innerHTML = D.struktur
    .map((o, i) => `<div class="org reveal reveal-zoom" ${delay(i)}>${photo(o.img, "", i, o.name)}<h4>${esc(o.name)}</h4><span>${esc(o.role)}</span></div>`).join("");

  $("#komunitas-grid").innerHTML = D.komunitas
    .map((k, i) => `<article class="k-card reveal" ${delay(i)}>${photo(k.img, "", i, k.name)}<h3>${esc(k.name)}</h3><p>${esc(k.desc)}</p></article>`).join("");

  $("#program-grid").innerHTML = D.program
    .map((p, i) => `<article class="p-row reveal ${i % 2 ? "reveal-right" : "reveal-left"}">${photo(p.img, "", i + 1, p.name)}<div><h3>${esc(p.name)}</h3><p>${esc(p.desc)}</p></div></article>`).join("");

  $("#event-grid").innerHTML = D.event.map((e, i) => {
    const t = parseISO(e.date);
    const meta = [`<p><i class="bi bi-geo-alt-fill"></i> ${esc(e.loc)}</p>`, e.time ? `<p><i class="bi bi-clock"></i> ${esc(e.time)}</p>` : ""].join("");
    return `<a class="e-card reveal" ${delay(i)} href="#calendar" aria-label="${esc(e.name)}, ${t.d} ${MONTHS[t.m]}">
      <div class="e-thumb">${photo(e.img, "arch", i, e.name)}<div class="date-badge"><b>${String(t.d).padStart(2, "0")}</b><small>${MONTHS_SHORT[t.m]}</small></div></div>
      <div class="e-body"><span class="tag">Event</span><h3>${esc(e.name)}</h3>${meta}</div>
      <span class="e-go" aria-hidden="true"><i class="bi bi-arrow-up-right"></i></span></a>`;
  }).join("");

  /* ===== UMKM: filter + pencarian + popup ===== */
  const cats = ["Semua", "Fashion", "Kriya"];
  const filters = $("#umkm-filters");
  const grid = $("#umkm-grid");
  const input = $("#umkm-search");
  let activeCat = "Semua";
  let firstRender = true;

  filters.innerHTML = cats.map((c, i) => `<button class="filter${i === 0 ? " active" : ""}" data-cat="${esc(c)}">${esc(c)}</button>`).join("");

  const matchCat = (cat, filter) => {
    if (filter === "Semua") return true;
    const c = (cat || "").toLowerCase();
    if (filter === "Fashion") return c === "fashion" || c === "fesyen";
    if (filter === "Kriya") return c === "kriya";
    return c === filter.toLowerCase();
  };

  function renderUmkm() {
    const q = input.value.trim().toLowerCase();
    const list = D.umkm.map((u, idx) => ({ u, idx })).filter(({ u }) =>
      matchCat(u.cat, activeCat) &&
      (u.name.toLowerCase().includes(q) || (u.loc && u.loc.toLowerCase().includes(q))));
    const anim = firstRender ? "reveal" : "pop";
    grid.innerHTML = list.length
      ? list.map(({ u, idx }, i) => `
        <article class="u-card ${anim}" ${delay(i)} role="button" tabindex="0" data-i="${idx}" aria-haspopup="dialog" aria-label="Lihat detail ${esc(u.name)}">
          <div class="u-media">${photo(u.img, "", idx, u.name)}<span class="tag">${esc(u.cat)}</span></div>
          <div class="u-body">
            <span class="u-cat">${esc(u.cat)}</span>
            <h3>${esc(u.name)}</h3>
            <p><i class="bi bi-geo-alt-fill"></i> ${esc(u.loc || "Badung")}, Badung</p>
            <span class="u-more">Lihat detail <i class="bi bi-arrow-up-right"></i></span>
          </div>
        </article>`).join("")
      : `<p class="empty">Belum ketemu. Coba kata kunci atau kategori lain ya.</p>`;
    firstRender = false;
  }
  filters.addEventListener("click", e => {
    const b = e.target.closest(".filter");
    if (!b) return;
    activeCat = b.dataset.cat;
    $$(".filter", filters).forEach(f => f.classList.toggle("active", f === b));
    renderUmkm();
  });
  input.addEventListener("input", renderUmkm);
  renderUmkm();

  /* --- Popup detail UMKM --- */
  const modal = $("#umkm-modal");
  let lastFocus = null;

  function fillModal(u, idx) {
    const wa = u.wa ? `https://wa.me/${encodeURIComponent(u.wa)}?text=${encodeURIComponent("Halo " + u.name + ", saya lihat info di website Ekraf Badung.")}` : "";
    const ig = u.ig ? `https://instagram.com/${encodeURIComponent(u.ig)}` : "";
    const map = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(u.name + " " + (u.loc || "") + " Badung")}`;
    $("#m-media").innerHTML = u.img
      ? `<div class="m-photo-wrap"><img src="${esc(u.img)}" alt="${esc(u.name)}" class="m-photo" onerror="this.parentElement.classList.add('has-fallback'); this.remove();"><div class="m-fallback"><i class="bi bi-shop"></i><span>${esc(u.name)}</span></div></div>`
      : `<div class="m-photo-wrap has-fallback"><div class="m-fallback"><i class="bi bi-shop"></i><span>${esc(u.name)}</span></div></div>`;
    $("#m-body").innerHTML = `
      <span class="tag">${esc(u.cat)}</span>
      <h3 id="m-title">${esc(u.name)}</h3>
      <p class="m-loc"><i class="bi bi-geo-alt-fill"></i> ${esc(u.loc || "Badung")}, Badung</p>
      <p class="m-desc">${esc(u.desc || "")}</p>
      ${u.products && u.products.length ? `<h4>Produk / layanan</h4><div class="m-chips">${u.products.map(p => `<span>${esc(p)}</span>`).join("")}</div>` : ""}
      <ul class="m-info">
        ${u.addr ? `<li><span><i class="bi bi-pin-map"></i></span><div><b>Alamat</b>${esc(u.addr)}</div></li>` : ""}
        ${u.hours ? `<li><span><i class="bi bi-clock"></i></span><div><b>Jam buka</b>${esc(u.hours)}</div></li>` : ""}
      </ul>
      <div class="m-actions">
        ${wa ? `<a class="btn btn-sun" href="${wa}" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i>&nbsp; WhatsApp</a>` : ""}
        ${ig ? `<a class="btn btn-ghost" href="${ig}" target="_blank" rel="noopener"><i class="bi bi-instagram"></i>&nbsp; Instagram</a>` : ""}
        <a class="btn btn-ghost" href="${map}" target="_blank" rel="noopener"><i class="bi bi-map"></i>&nbsp; Peta</a>
      </div>`;
    $("#m-body").scrollTop = 0;
  }
  function openModal(idx) {
    lastFocus = document.activeElement;
    fillModal(D.umkm[idx], idx);
    const sbw = window.innerWidth - document.documentElement.clientWidth;
    document.documentElement.style.setProperty("--sbw", sbw + "px");
    document.body.classList.add("lock");
    modal.hidden = false;
    requestAnimationFrame(() => requestAnimationFrame(() => modal.classList.add("open")));
    setTimeout(() => $(".modal-close", modal).focus({ preventScroll: true }), 60);
  }
  function closeModal() {
    if (modal.hidden) return;
    modal.classList.remove("open");
    setTimeout(() => {
      modal.hidden = true;
      document.body.classList.remove("lock");
      if (lastFocus) lastFocus.focus({ preventScroll: true });
    }, reduceMotion ? 0 : 380);
  }
  grid.addEventListener("click", e => {
    const c = e.target.closest(".u-card");
    if (c) openModal(+c.dataset.i);
  });
  grid.addEventListener("keydown", e => {
    const c = e.target.closest(".u-card");
    if (c && (e.key === "Enter" || e.key === " ")) { e.preventDefault(); openModal(+c.dataset.i); }
  });
  modal.addEventListener("click", e => { if (e.target.closest("[data-close]")) closeModal(); });
  document.addEventListener("keydown", e => {
    if (modal.hidden) return;
    if (e.key === "Escape") closeModal();
    if (e.key === "Tab") {   // jaga fokus tetap di dalam popup
      const f = $$("a[href], button", modal).filter(x => x.offsetParent !== null);
      if (!f.length) return;
      const first = f[0], last = f[f.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    }
  });

  /* ===== Kalender ===== */
  let events = D.kalender.slice();
  const now = new Date();
  let view = { y: now.getFullYear(), m: now.getMonth() };
  let selected = null;

  // Parser CSV sederhana (mendukung tanda kutip) untuk Google Sheets
  function parseCSV(text) {
    const rows = []; let row = [], cell = "", q = false;
    for (let i = 0; i < text.length; i++) {
      const c = text[i];
      if (q) {
        if (c === '"' && text[i + 1] === '"') { cell += '"'; i++; }
        else if (c === '"') q = false;
        else cell += c;
      } else if (c === '"') q = true;
      else if (c === ",") { row.push(cell); cell = ""; }
      else if (c === "\n" || c === "\r") { if (c === "\r" && text[i + 1] === "\n") i++; row.push(cell); rows.push(row); row = []; cell = ""; }
      else cell += c;
    }
    if (cell || row.length) { row.push(cell); rows.push(row); }
    return rows;
  }

  async function loadSheet() {
    if (!CFG.KALENDER_CSV_URL) return;
    try {
      const res = await fetch(CFG.KALENDER_CSV_URL);
      const rows = parseCSV(await res.text()).slice(1);
      const list = rows
        .map(r => ({ date: (r[0] || "").trim(), name: (r[1] || "").trim(), time: (r[2] || "").trim(), loc: (r[3] || "").trim() }))
        .filter(r => /^\d{4}-\d{2}-\d{2}$/.test(r.date) && r.name);
      if (list.length) { events = list; renderCal(); }
    } catch (err) { console.warn("Kalender: gagal memuat spreadsheet, memakai data contoh.", err); }
  }

  function renderCal() {
    const titleText = $("#cal-title .cal-title-text") || $("#cal-title");
    titleText.textContent = `${MONTHS[view.m]} ${view.y}`;
    const first = new Date(view.y, view.m, 1);
    const lead = (first.getDay() + 6) % 7; // Senin = 0
    const days = new Date(view.y, view.m + 1, 0).getDate();
    const byDay = {};
    events.forEach(e => { byDay[e.date] = (byDay[e.date] || 0) + 1; });

    let html = "";
    for (let i = 0; i < lead; i++) html += `<button class="cal-day" disabled aria-hidden="true"></button>`;
    for (let d = 1; d <= days; d++) {
      const k = key(view.y, view.m, d);
      const cls = ["cal-day"];
      if (byDay[k]) cls.push("has-ev");
      if (k === key(now.getFullYear(), now.getMonth(), now.getDate())) cls.push("today");
      if (k === selected) cls.push("sel");
      html += `<button class="${cls.join(" ")}" data-k="${k}" aria-label="${d} ${MONTHS[view.m]}${byDay[k] ? `, ${byDay[k]} kegiatan` : ""}" aria-pressed="${k === selected}">${d}</button>`;
    }
    $("#cal-grid").innerHTML = html;

    const prefix = `${view.y}-${String(view.m + 1).padStart(2, "0")}`;
    const list = events
      .filter(e => selected ? e.date === selected : e.date.startsWith(prefix))
      .sort((a, b) => a.date.localeCompare(b.date));
    $("#agenda-title").textContent = selected
      ? `Agenda ${parseISO(selected).d} ${MONTHS[parseISO(selected).m]}`
      : `Agenda ${MONTHS[view.m]}`;
    $("#cal-list").innerHTML = list.length
      ? list.map((e, i) => {
          const t = parseISO(e.date);
          const meta = [e.time && `<i class="bi bi-clock"></i> ${esc(e.time)}`, e.loc && `<i class="bi bi-geo-alt-fill"></i> ${esc(e.loc)}`].filter(Boolean).join("  ");
          return `<div class="ag pop" style="--d:${i * 70}ms"><div class="ag-date"><div><b>${String(t.d).padStart(2, "0")}</b><small>${MONTHS_SHORT[t.m]}</small></div></div><div><h5>${esc(e.name)}</h5><span>${meta}</span></div></div>`;
        }).join("")
      : `<p class="empty">Belum ada kegiatan di sini. Santai dulu~</p>`;
  }

  /* ===== Shortcut Pemilih Bulan & Tahun (Popover) ===== */
  const calTitleBtn = $("#cal-title");
  const calPicker = $("#cal-picker");
  let pickerYear = view.y;

  function renderPicker() {
    if (!calPicker) return;
    const yearEl = $("#cal-picker-year");
    if (yearEl) yearEl.textContent = pickerYear;

    const monthsBox = $("#cal-picker-months");
    if (monthsBox) {
      monthsBox.innerHTML = MONTHS.map((name, m) => {
        const isSel = (view.m === m && view.y === pickerYear);
        const isNow = (now.getMonth() === m && now.getFullYear() === pickerYear);
        const cls = ["cal-month-btn"];
        if (isSel) cls.push("active");
        if (isNow) cls.push("is-today");
        return `<button type="button" class="${cls.join(" ")}" data-m="${m}" aria-pressed="${isSel}" title="${esc(name)}">${esc(MONTHS_SHORT[m])}</button>`;
      }).join("");
    }
  }

  function openPicker() {
    if (!calPicker) return;
    pickerYear = view.y;
    renderPicker();
    calPicker.hidden = false;
    calTitleBtn.setAttribute("aria-expanded", "true");
  }

  function closePicker() {
    if (!calPicker || calPicker.hidden) return;
    calPicker.hidden = true;
    calTitleBtn.setAttribute("aria-expanded", "false");
  }

  if (calTitleBtn && calPicker) {
    calTitleBtn.addEventListener("click", e => {
      e.stopPropagation();
      if (calPicker.hidden) openPicker();
      else closePicker();
    });

    $("#cal-picker-prev-year")?.addEventListener("click", e => {
      e.stopPropagation();
      pickerYear--;
      renderPicker();
    });

    $("#cal-picker-next-year")?.addEventListener("click", e => {
      e.stopPropagation();
      pickerYear++;
      renderPicker();
    });

    $("#cal-picker-today")?.addEventListener("click", e => {
      e.stopPropagation();
      view.y = now.getFullYear();
      view.m = now.getMonth();
      selected = null;
      renderCal();
      closePicker();
    });

    $("#cal-picker-months")?.addEventListener("click", e => {
      const b = e.target.closest(".cal-month-btn");
      if (!b) return;
      e.stopPropagation();
      view.y = pickerYear;
      view.m = +b.dataset.m;
      selected = null;
      renderCal();
      closePicker();
    });

    calPicker.addEventListener("click", e => e.stopPropagation());
    document.addEventListener("click", e => {
      if (!e.target.closest(".cal-title-wrap")) closePicker();
    });
    document.addEventListener("keydown", e => {
      if (e.key === "Escape") closePicker();
    });
  }

  $("#cal-grid").addEventListener("click", e => {
    const b = e.target.closest(".cal-day[data-k]");
    if (!b) return;
    selected = selected === b.dataset.k ? null : b.dataset.k;
    renderCal();
  });
  const shift = n => { view.m += n; if (view.m < 0) { view.m = 11; view.y--; } if (view.m > 11) { view.m = 0; view.y++; } selected = null; closePicker(); renderCal(); };
  $("#cal-prev").addEventListener("click", () => shift(-1));
  $("#cal-next").addEventListener("click", () => shift(1));
  renderCal();
  loadSheet();

  /* ===== Navbar mobile ===== */
  const nav = $(".navbar");
  const toggle = $(".nav-toggle");
  const menu = $("#nav-menu");

  function setMenu(open) {
    menu.classList.toggle("open", open);
    toggle.setAttribute("aria-expanded", open);
    toggle.setAttribute("aria-label", open ? "Tutup menu" : "Buka menu");
  }
  toggle.addEventListener("click", () => setMenu(!menu.classList.contains("open")));

  function closeDropdowns() {
    $$(".dropdown.open").forEach(d => { d.classList.remove("open"); d.previousElementSibling.setAttribute("aria-expanded", "false"); });
  }
  $$(".nav-btn").forEach(btn => {
    btn.addEventListener("click", e => {
      e.stopPropagation();
      const dd = btn.nextElementSibling;
      const open = !dd.classList.contains("open");
      closeDropdowns();
      dd.classList.toggle("open", open);
      btn.setAttribute("aria-expanded", open);
    });
  });
  $$("#nav-menu a").forEach(a => a.addEventListener("click", () => { setMenu(false); closeDropdowns(); }));
  document.addEventListener("click", closeDropdowns);
  document.addEventListener("keydown", e => { if (e.key === "Escape") { setMenu(false); closeDropdowns(); } });
  window.matchMedia("(min-width: 960px)").addEventListener("change", e => { if (e.matches) setMenu(false); });

  /* ===== Navbar shadow + progress bar + to-top ===== */
  const bar = $("#progress");
  const toTop = $("#to-top");
  let ticking = false;
  function onScroll() {
    const y = window.scrollY;
    nav.classList.toggle("scrolled", y > 10);
    const max = document.documentElement.scrollHeight - window.innerHeight;
    bar.style.transform = `scaleX(${max > 0 ? Math.min(1, y / max) : 0})`;
    toTop.classList.toggle("show", y > 700);
    ticking = false;
  }
  window.addEventListener("scroll", () => { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }, { passive: true });
  onScroll();
  /* ===== Scroll halus dengan easing (tautan anchor & tombol ke atas) =====
     CSS scroll-behavior dimatikan lewat kelas .js-smooth supaya tidak bentrok dengan animasi ini. */
  document.documentElement.classList.add("js-smooth");
  let scrollAnim = 0, scrollCtl = null;
  const easeInOut = t => (t < .5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);
  function smoothTo(y) {
    cancelAnimationFrame(scrollAnim);
    scrollCtl?.abort();
    const start = window.scrollY, dist = y - start;
    if (reduceMotion || Math.abs(dist) < 4) { window.scrollTo(0, y); return; }
    const dur = Math.min(1100, Math.max(550, Math.abs(dist) * 0.35));
    scrollCtl = new AbortController();
    const stop = () => { cancelAnimationFrame(scrollAnim); scrollCtl.abort(); };
    ["wheel", "touchstart", "keydown", "mousedown"].forEach(ev => window.addEventListener(ev, stop, { once: true, passive: true, signal: scrollCtl.signal }));
    let t0 = null;
    const step = t => {
      t0 ??= t;
      const p = Math.min(1, (t - t0) / dur);
      window.scrollTo(0, start + dist * easeInOut(p));
      if (p < 1) scrollAnim = requestAnimationFrame(step); else scrollCtl.abort();
    };
    scrollAnim = requestAnimationFrame(step);
  }
  document.addEventListener("click", e => {
    const a = e.target.closest('a[href^="#"]');
    if (!a || e.defaultPrevented || e.metaKey || e.ctrlKey) return;
    const id = a.getAttribute("href");
    const el = id.length > 1 && document.getElementById(decodeURIComponent(id.slice(1)));
    if (!el) return;
    e.preventDefault();
    const navH = parseInt(getComputedStyle(document.documentElement).getPropertyValue("--nav-h")) || 76;
    smoothTo(Math.max(0, el.getBoundingClientRect().top + window.scrollY - navH - 8));
    history.pushState(null, "", id);
  });
  toTop.addEventListener("click", () => smoothTo(0));

  /* ===== Scroll-spy ===== */
  const navItems = $$(".nav-item[data-menu]");
  const spy = new IntersectionObserver(entries => {
    entries.forEach(en => {
      if (en.isIntersecting) {
        const k = en.target.dataset.menu;
        navItems.forEach(it => $(".nav-link, .nav-btn", it).classList.toggle("active", it.dataset.menu === k));
      }
    });
  }, { rootMargin: "-40% 0px -55% 0px" });
  $$("section[data-menu]").forEach(s => spy.observe(s));

  /* ===== Reveal on scroll (bertahap) ===== */
  const rev = new IntersectionObserver(entries => {
    entries.forEach(en => {
      if (!en.isIntersecting) return;
      const el = en.target;
      el.classList.add("show");
      rev.unobserve(el);
      // setelah animasi selesai, lepas kelas "reveal" supaya efek hover tidak tertahan delay
      const d = parseInt(el.style.getPropertyValue("--d")) || 0;
      setTimeout(() => el.classList.remove("reveal"), 1000 + d);
    });
  }, { threshold: .12, rootMargin: "0px 0px -6% 0px" });
  $$(".reveal, .section-head, .sticker-cloud").forEach(el => rev.observe(el));

  /* ===== Counter statistik hero ===== */
  $$(".hero-stats b[data-count]").forEach(el => {
    const to = +el.dataset.count, suf = el.dataset.suffix || "";
    if (reduceMotion) { el.textContent = to + suf; return; }
    const t0 = performance.now() + 500, dur = 1500;
    el.textContent = "0" + suf;
    (function tick(t) {
      const p = Math.max(0, Math.min(1, (t - t0) / dur));
      el.textContent = Math.round(to * (1 - Math.pow(1 - p, 3))) + suf;
      if (p < 1) requestAnimationFrame(tick);
    })(performance.now());
  });

  /* ===== Hero slideshow ===== */
  (function heroSlider() {
    const root = $("#hero-slider");
    if (!root) return;
    const slides = $$(".hs-slide", root);
    const dotsBox = $("#hs-dots");
    const textEl = $("#hs-text");
    const nowEl = $("#hs-now");
    const DELAY = 5000;            // ganti gambar tiap 5 detik
    const pad = n => String(n).padStart(2, "0");
    let cur = 0, timer = null, busy = false, hovering = false, visible = true;

    $("#hs-total").textContent = pad(slides.length);
    dotsBox.innerHTML = slides.map((_, i) => `<button class="hs-dot${i === 0 ? " active" : ""}" role="tab" aria-label="Gambar ${i + 1}" aria-selected="${i === 0}"></button>`).join("");
    const dots = $$(".hs-dot", dotsBox);
    dots.forEach(d => d.style.setProperty("--dur", DELAY + "ms"));
    textEl.textContent = slides[0].dataset.caption || "";

    function go(n) {
      n = (n + slides.length) % slides.length;
      if (n === cur || busy) return;
      busy = true;
      const prev = slides[cur], next = slides[n];
      slides.forEach(s => s.classList.remove("leaving"));
      prev.classList.remove("active");
      prev.classList.add("leaving");
      void next.offsetWidth;
      next.classList.add("active");
      dots.forEach((d, i) => { d.classList.remove("active"); d.setAttribute("aria-selected", i === n); });
      void dots[n].offsetWidth;
      dots[n].classList.add("active");
      nowEl.textContent = pad(n + 1);
      textEl.textContent = next.dataset.caption || "";
      textEl.classList.remove("swap"); void textEl.offsetWidth; textEl.classList.add("swap");
      cur = n;
      setTimeout(() => { prev.classList.remove("leaving"); busy = false; }, 1150);
    }
    function schedule() {
      clearTimeout(timer);
      if (hovering || !visible || document.hidden) return;
      timer = setTimeout(() => { go(cur + 1); schedule(); }, DELAY);
    }
    function restart() {
      const d = dots[cur];
      d.classList.remove("active"); void d.offsetWidth; d.classList.add("active");
      schedule();
    }
    function pause(on) {
      hovering = on;
      root.classList.toggle("paused", on || !visible || document.hidden);
      if (on) clearTimeout(timer); else restart();
    }

    $("#hs-next").addEventListener("click", () => { go(cur + 1); restart(); });
    $("#hs-prev").addEventListener("click", () => { go(cur - 1); restart(); });
    dots.forEach((d, i) => d.addEventListener("click", () => { go(i); restart(); }));
    root.addEventListener("mouseenter", () => pause(true));
    root.addEventListener("mouseleave", () => pause(false));
    root.addEventListener("keydown", e => {
      if (e.key === "ArrowRight") { go(cur + 1); restart(); }
      if (e.key === "ArrowLeft") { go(cur - 1); restart(); }
    });

    let sx = null;
    root.addEventListener("touchstart", e => { sx = e.touches[0].clientX; }, { passive: true });
    root.addEventListener("touchend", e => {
      if (sx === null) return;
      const dx = e.changedTouches[0].clientX - sx; sx = null;
      if (Math.abs(dx) > 40) { go(cur + (dx < 0 ? 1 : -1)); restart(); }
    }, { passive: true });

    document.addEventListener("visibilitychange", () => pause(hovering));
    new IntersectionObserver(([en]) => { visible = en.isIntersecting; pause(hovering); }, { threshold: .2 }).observe(root);
    schedule();
  })();

  $("#year").textContent = now.getFullYear();
})();
