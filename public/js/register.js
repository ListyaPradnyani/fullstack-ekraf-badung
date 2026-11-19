/* Form pendaftaran UMKM di landing page: pratinjau foto, cek ukuran/jumlah berkas, validasi ringan, anti kirim ganda. */
(function () {
  const form = document.querySelector("[data-reg]");
  const alertBox = document.querySelector(".reg-alert");
  if (alertBox) { alertBox.focus({ preventScroll: true }); }
  if (!form) return;

  const MAX_MB = 4;
  const showErr = (el, msg) => {
    let n = el.parentElement.querySelector(".err.js");
    if (!msg) { n?.remove(); el.classList.remove("bad"); return; }
    if (!n) { n = document.createElement("small"); n.className = "err js"; el.insertAdjacentElement("afterend", n); }
    n.textContent = msg; el.classList.add("bad");
  };

  form.querySelectorAll('input[type="file"]').forEach(inp => {
    const box = inp.dataset.previews ? form.querySelector(`[data-previews="${inp.id}"]`) : null;
    const overview = document.getElementById(`${inp.id}-overview`);
    let urls = [];
    let accumulatedFiles = [];

    const updateOverview = () => {
      if (!overview) return;
      const countEl = overview.querySelector(".count-num");
      const max = +inp.dataset.max || 5;
      const count = accumulatedFiles.length;
      if (countEl) countEl.textContent = count;
      overview.classList.toggle("has-files", count > 0);
      overview.classList.toggle("full", count >= max);
    };

    const renderPreviews = () => {
      urls.forEach(URL.revokeObjectURL);
      urls = [];
      if (!box) return;
      box.innerHTML = "";

      accumulatedFiles.forEach((file, idx) => {
        const u = URL.createObjectURL(file);
        urls.push(u);

        const item = document.createElement("div");
        item.className = "preview-item";

        const im = new Image();
        im.src = u;
        im.alt = file.name;
        item.appendChild(im);

        const badge = document.createElement("span");
        badge.className = "preview-badge";
        badge.textContent = `#${idx + 1}`;
        item.appendChild(badge);

        const delBtn = document.createElement("button");
        delBtn.type = "button";
        delBtn.className = "preview-remove";
        delBtn.innerHTML = "&times;";
        delBtn.title = `Hapus ${file.name}`;
        delBtn.setAttribute("aria-label", `Hapus ${file.name}`);

        delBtn.addEventListener("click", e => {
          e.preventDefault();
          e.stopPropagation();
          accumulatedFiles.splice(idx, 1);
          syncFilesToInput();
          renderPreviews();
          updateOverview();
        });

        item.appendChild(delBtn);
        box.appendChild(item);
      });
    };

    const syncFilesToInput = () => {
      try {
        const dt = new DataTransfer();
        accumulatedFiles.forEach(f => dt.items.add(f));
        inp.files = dt.files;
      } catch (err) {
        // Fallback for older browser engines
      }
      if (accumulatedFiles.length === 0) {
        inp.value = "";
      }
    };

    if (inp.multiple) {
      inp.addEventListener("change", () => {
        const newlySelected = [...inp.files];
        const max = +inp.dataset.max || 5;
        let errMsg = "";

        if (newlySelected.some(f => f.size > MAX_MB * 1024 * 1024)) {
          errMsg = `Ukuran tiap berkas maksimal ${MAX_MB} MB.`;
        }

        if (errMsg) {
          syncFilesToInput();
          showErr(inp, errMsg);
          return;
        }

        let hitLimit = false;

        newlySelected.forEach(f => {
          const exists = accumulatedFiles.some(
            existing => existing.name === f.name && existing.size === f.size && existing.lastModified === f.lastModified
          );
          if (exists) {
            return;
          }
          if (accumulatedFiles.length >= max) {
            hitLimit = true;
            return;
          }
          accumulatedFiles.push(f);
        });

        syncFilesToInput();
        renderPreviews();
        updateOverview();

        if (hitLimit) {
          showErr(inp, `Maksimal ${max} foto produk. Hanya foto dalam batas kuota yang disimpan.`);
        } else {
          showErr(inp, "");
        }
      });
    } else {
      inp.addEventListener("change", () => {
        urls.forEach(URL.revokeObjectURL); urls = [];
        if (box) box.innerHTML = "";
        const files = [...inp.files];
        let msg = "";
        if (files.some(f => f.size > MAX_MB * 1024 * 1024)) msg = `Ukuran tiap berkas maksimal ${MAX_MB} MB.`;
        if (msg) { inp.value = ""; showErr(inp, msg); return; }
        showErr(inp, "");
        if (box) files.forEach(f => {
          const u = URL.createObjectURL(f); urls.push(u);
          const im = new Image(); im.src = u; im.alt = f.name; box.appendChild(im);
        });
      });
    }
  });

  form.addEventListener("submit", e => {
    const pw = form.elements.password, pc = form.elements.password_confirmation;
    if (pw && pc && pw.value !== pc.value) { showErr(pc, "Konfirmasi password tidak sama."); pc.focus(); e.preventDefault(); return; }
    if (!form.checkValidity()) {
      e.preventDefault();
      const first = form.querySelector(":invalid");
      first.scrollIntoView({ behavior: "smooth", block: "center" });
      setTimeout(() => first.focus({ preventScroll: true }), 350);
      first.reportValidity?.();
      return;
    }
    const b = form.querySelector("[data-submit]");
    b.disabled = true; b.innerHTML = "Mengirim…";
  });
})();
