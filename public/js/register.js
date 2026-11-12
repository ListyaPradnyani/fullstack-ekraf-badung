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
    let urls = [];
    inp.addEventListener("change", () => {
      urls.forEach(URL.revokeObjectURL); urls = [];
      if (box) box.innerHTML = "";
      const files = [...inp.files], max = +inp.dataset.max || 1;
      let msg = "";
      if (files.length > max) msg = `Maksimal ${max} berkas.`;
      else if (files.some(f => f.size > MAX_MB * 1024 * 1024)) msg = `Ukuran tiap berkas maksimal ${MAX_MB} MB.`;
      if (msg) { inp.value = ""; showErr(inp, msg); return; }
      showErr(inp, "");
      if (box) files.forEach(f => {
        const u = URL.createObjectURL(f); urls.push(u);
        const im = new Image(); im.src = u; im.alt = f.name; box.appendChild(im);
      });
    });
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
