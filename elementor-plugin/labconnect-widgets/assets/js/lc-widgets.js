/**
 * LabConnect Widgets — tiny vanilla store shared by Track Cards, Pricing Cards
 * and the Final CTA (the Elementor version of the React SelectionProvider).
 * Works across separate widgets on the same page; re-runs inside the Elementor editor.
 */
(function () {
  "use strict";
  var cfg = window.LCW_CONFIG || {};

  function waLink(number, message) {
    var n = String(number || cfg.whatsapp || "").replace(/\D/g, "");
    return (n ? "https://wa.me/" + n : "https://wa.me/") + "?text=" + encodeURIComponent(message);
  }

  function fill(template, pkg) {
    var price = [pkg.amount, pkg.period].filter(Boolean).join(" ");
    return String(template || "")
      .replace(/\{package\}/g, pkg.name || "")
      .replace(/\{price\}/g, price)
      .replace(/\{amount\}/g, pkg.amount || "")
      .replace(/\{period\}/g, pkg.period || "");
  }

  function packageData(card) {
    return {
      id: card.getAttribute("data-lc-package"),
      name: card.getAttribute("data-lc-name") || "",
      amount: card.getAttribute("data-lc-amount") || "",
      period: card.getAttribute("data-lc-period") || "",
    };
  }

  function current(group) {
    var card = document.querySelector('.lc-pricing-card.is-selected[data-lc-group="' + group + '"]');
    return card ? packageData(card) : null;
  }

  function refreshCtas() {
    document.querySelectorAll("[data-lc-wa]").forEach(function (el) {
      var group = el.getAttribute("data-lc-wa");
      var pkg = current(group) || {
        name: el.getAttribute("data-lc-fallback-name") || "",
        amount: el.getAttribute("data-lc-fallback-amount") || "",
        period: el.getAttribute("data-lc-fallback-period") || "",
      };
      el.setAttribute("href", waLink(el.getAttribute("data-lc-number"), fill(el.getAttribute("data-lc-template"), pkg)));
    });
    document.querySelectorAll("[data-lc-summary]").forEach(function (el) {
      var pkg = current(el.getAttribute("data-lc-summary"));
      if (pkg) el.textContent = pkg.name;
    });
  }

  function swapVariant(btn, selected) {
    var on = btn.getAttribute("data-lc-variant-on");
    var off = btn.getAttribute("data-lc-variant-off");
    if (!on || !off) return;
    btn.classList.remove("lc-btn--" + on, "lc-btn--" + off);
    btn.classList.add("lc-btn--" + (selected ? on : off));
  }

  function selectPackage(card) {
    var group = card.getAttribute("data-lc-group");
    document.querySelectorAll('.lc-pricing-card[data-lc-group="' + group + '"]').forEach(function (c) {
      var on = c === card;
      c.classList.toggle("is-selected", on);
      var btn = c.querySelector("[data-lc-select]");
      if (btn) {
        btn.setAttribute("aria-pressed", on ? "true" : "false");
        swapVariant(btn, on);
      }
    });
    selectTrack(group, false);
    refreshCtas();
  }

  function selectTrack(id, scroll) {
    var target = null;
    document.querySelectorAll("[data-lc-track]").forEach(function (t) {
      var on = t.getAttribute("data-lc-track") === id;
      t.classList.toggle("is-selected", on);
      t.setAttribute("aria-pressed", on ? "true" : "false");
      if (on) target = t.getAttribute("data-lc-target");
    });
    if (scroll && target && target.charAt(0) === "#") {
      var el = document.querySelector(target);
      if (el) el.scrollIntoView({ behavior: "smooth" });
    }
  }

  function bindOnce(root) {
    if (root.__lcBound) return;
    root.__lcBound = true;
    root.addEventListener("click", function (e) {
      var sel = e.target.closest("[data-lc-select]");
      if (sel) {
        e.preventDefault();
        selectPackage(sel.closest(".lc-pricing-card"));
        return;
      }
      var track = e.target.closest("[data-lc-track]");
      if (track) {
        e.preventDefault();
        selectTrack(track.getAttribute("data-lc-track"), true);
        return;
      }
      var toggle = e.target.closest(".lc-header__toggle");
      if (toggle) {
        var header = toggle.closest(".lc-header");
        var drawer = header && header.querySelector(".lc-header__drawer");
        var open = !header.classList.contains("is-open");
        header.classList.toggle("is-open", open);
        toggle.setAttribute("aria-expanded", open ? "true" : "false");
        toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
        if (drawer) drawer.hidden = !open;
        return;
      }
      var drawerLink = e.target.closest(".lc-header__drawer a");
      if (drawerLink) {
        var h = drawerLink.closest(".lc-header");
        h.classList.remove("is-open");
        h.querySelector(".lc-header__drawer").hidden = true;
        var tg = h.querySelector(".lc-header__toggle");
        if (tg) tg.setAttribute("aria-expanded", "false");
      }
    });
  }

  function init() {
    bindOnce(document);
    refreshCtas();
  }

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", init);
  else init();

  // Elementor editor / frontend re-renders
  window.addEventListener("elementor/frontend/init", function () {
    if (window.elementorFrontend && window.elementorFrontend.hooks) {
      window.elementorFrontend.hooks.addAction("frontend/element_ready/global", function () {
        refreshCtas();
      });
    }
  });

  window.LCW = { refresh: refreshCtas, selectPackage: selectPackage, selectTrack: selectTrack };
})();
