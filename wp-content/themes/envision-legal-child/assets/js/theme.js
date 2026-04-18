/**
 * Envision Legal – Theme JavaScript
 * Handles: mobile nav, sub-menu toggle, accordion, smooth scroll, anchor-open, back-to-top
 */
(function ($) {
  'use strict';

  /* ── Mobile Navigation ──────────────────────────────────────────────────── */
  var $toggle = $('.el-nav-toggle');
  var $nav    = $('.el-nav');
  var mobileNavBreakpoint = '(max-width: 768px)';

  function isMobileNav() {
    return window.matchMedia(mobileNavBreakpoint).matches;
  }

  function closeMobileNav() {
    $toggle.attr('aria-expanded', 'false');
    $nav.removeClass('is-open');
    $('.el-nav__list .sub-menu').removeClass('is-open').css('max-height', '');
    $('.el-nav__list .menu-item-has-children > a').attr('aria-expanded', 'false');
    $('.el-nav__list .el-submenu-toggle').attr('aria-expanded', 'false').find('span').text('▾');
  }

  $toggle.on('click', function () {
    var expanded = $(this).attr('aria-expanded') === 'true';
    $(this).attr('aria-expanded', String(!expanded));
    $nav.toggleClass('is-open');
  });

  $(document).on('click', function (e) {
    if (!$(e.target).closest('.el-header').length) {
      closeMobileNav();
    }
  });

  /* ── Mobile Sub-menu Toggle ─────────────────────────────────────────────── */
  // Inject a toggle arrow button after each parent nav link on mobile
  function initMobileSubmenus() {
    $('.el-nav__list .menu-item-has-children').each(function () {
      var $item = $(this);
      // Avoid duplicating buttons
      if ($item.find('.el-submenu-toggle').length) return;

      var $btn = $('<button>', {
        'class':       'el-submenu-toggle',
        'type':        'button',
        'aria-expanded': 'false',
        'aria-label':  'Toggle sub-menu',
        html:          '<span>▾</span>',
      });

      $item.children('a').after($btn);

      $btn.on('click', function (e) {
        e.stopPropagation();
        if (!isMobileNav()) return;
        var $subMenu  = $item.children('.sub-menu');
        var isOpen    = $btn.attr('aria-expanded') === 'true';

        // Close any other open sub-menus at this level
        $item.siblings('.menu-item-has-children').each(function () {
          $(this).children('.sub-menu').removeClass('is-open').css('max-height', '');
          $(this).children('.el-submenu-toggle').attr('aria-expanded', 'false').find('span').text('▾');
        });

        if (isOpen) {
          $subMenu.removeClass('is-open').css('max-height', '');
          $btn.attr('aria-expanded', 'false').find('span').text('▾');
        } else {
          $subMenu.addClass('is-open').css('max-height', $subMenu[0].scrollHeight + 'px');
          $btn.attr('aria-expanded', 'true').find('span').text('▴');
        }
      });
    });
  }

  $(window).on('resize.elNav', function () {
    if (!isMobileNav()) {
      closeMobileNav();
    }
  });

  $(document).on('click', '.el-nav__list a', function () {
    if (!isMobileNav()) return;
    if ($(this).siblings('.sub-menu').length) return;
    closeMobileNav();
  });

  /* ── Accordion helpers ──────────────────────────────────────────────────── */
  function openAccordionItem($item) {
    var $trigger = $item.find('.el-accordion__trigger');
    var $panel   = $item.find('.el-accordion__panel');

    // Close siblings first
    $item.siblings('.el-accordion__item').each(function () {
      $(this).find('.el-accordion__trigger').attr('aria-expanded', 'false');
      $(this).find('.el-accordion__panel').removeClass('is-open').css('max-height', '');
    });

    // Open this one
    $trigger.attr('aria-expanded', 'true');
    $panel.addClass('is-open').css('max-height', $panel[0].scrollHeight + 'px');
  }

  function closeAccordionItem($item) {
    $item.find('.el-accordion__trigger').attr('aria-expanded', 'false');
    $item.find('.el-accordion__panel').removeClass('is-open').css('max-height', '');
  }

  /* ── Accordion click ────────────────────────────────────────────────────── */
  $(document).on('click', '.el-accordion__trigger', function () {
    var $item  = $(this).closest('.el-accordion__item');
    var isOpen = $(this).attr('aria-expanded') === 'true';
    if (isOpen) {
      closeAccordionItem($item);
    } else {
      openAccordionItem($item);
    }
  });

  /* ── Smooth Scroll + auto-open accordion on anchor links ───────────────── */
  $(document).on('click', 'a[href^="#"]', function (e) {
    var hash    = this.hash;
    var $target = $(hash);
    if (!$target.length) return;

    e.preventDefault();

    var headerHeight = $('.el-header').outerHeight() || 0;

    if ($target.hasClass('el-accordion__item')) {
      openAccordionItem($target);
      setTimeout(function () {
        $('html, body').animate(
          { scrollTop: $target.offset().top - headerHeight - 20 },
          400
        );
      }, 50);
    } else {
      $('html, body').animate(
        { scrollTop: $target.offset().top - headerHeight - 20 },
        400
      );
    }
  });

  /* ── Auto-open accordion if page loads with a hash in the URL ───────────── */
  function openFromHash() {
    var hash = window.location.hash;
    if (!hash) return;
    var $target = $(hash);
    if ($target.hasClass('el-accordion__item')) {
      openAccordionItem($target);
      setTimeout(function () {
        var headerHeight = $('.el-header').outerHeight() || 0;
        $('html, body').scrollTop($target.offset().top - headerHeight - 20);
      }, 100);
    }
  }

  /* ── Scroll-triggered animations ────────────────────────────────────────── */
  function initScrollReveal() {
    var $items = $('.el-card, .el-practice-card, .el-team-card, .el-stat');

    if (!('IntersectionObserver' in window)) {
      $items.addClass('is-visible');
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.1 }
    );

    $items.each(function () {
      this.style.opacity    = '0';
      this.style.transform  = 'translateY(20px)';
      this.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      observer.observe(this);
    });
  }

  /* ── Back-to-top button ──────────────────────────────────────────────────── */
  function initBackToTop() {
    var $btn = $('<button>', {
      id:           'el-back-to-top',
      'aria-label': 'Back to top',
      html:         '&#8679;',
      css: {
        position:       'fixed',
        bottom:         '2rem',
        right:          '2rem',
        width:          '44px',
        height:         '44px',
        background:     'var(--el-navy)',
        color:          '#fff',
        border:         'none',
        borderRadius:   '50%',
        fontSize:       '1.4rem',
        cursor:         'pointer',
        opacity:        '0',
        transition:     'opacity 0.3s ease',
        zIndex:         '50',
        display:        'flex',
        alignItems:     'center',
        justifyContent: 'center',
      }
    });

    $('body').append($btn);

    $(window).on('scroll.btt', function () {
      $btn.css('opacity', $(this).scrollTop() > 400 ? '1' : '0');
    });

    $btn.on('click', function () {
      $('html, body').animate({ scrollTop: 0 }, 300);
    });
  }

  /* ── Contact form helper ─────────────────────────────────────────────────── */
  function initContactForm() {
    $(document).on('wpcf7mailsent', function () {
      $('.el-form-success').fadeIn();
    });
  }

  /* ── Visible class cleanup ───────────────────────────────────────────────── */
  $(document).on('animationend transitionend', '.el-card.is-visible, .el-practice-card.is-visible', function () {
    $(this).css({ opacity: '', transform: '' });
  });

  var style = document.createElement('style');
  style.textContent = '.is-visible { opacity: 1 !important; transform: translateY(0) !important; }';
  document.head.appendChild(style);

  /* ── Exit-intent / Scroll-depth Popup ───────────────────────────────────── */
  function initExitPopup() {
    var STORAGE_KEY = 'el_popup_dismissed';
    var MIN_TIME_MS  = 30000; // 30 seconds minimum on page
    var SCROLL_DEPTH = 0.60;  // 60% scroll depth

    // Don't show if already dismissed this session.
    if (sessionStorage.getItem(STORAGE_KEY)) return;

    // Don't show if the popup element doesn't exist on this page.
    var $popup    = $('#el-exit-popup');
    var $overlay  = $('#el-exit-overlay');
    if (!$popup.length) return;

    var shown       = false;
    var pageLoadTime = Date.now();

    function dismiss() {
      $overlay.removeClass('is-visible');
      $popup.removeClass('is-visible').attr('aria-hidden', 'true');
      sessionStorage.setItem(STORAGE_KEY, '1');
      // Re-enable body scroll
      $('body').css('overflow', '');
      shown = true;
    }

    function showPopup() {
      if (shown) return;
      if ((Date.now() - pageLoadTime) < MIN_TIME_MS) return;
      shown = true;
      $overlay.addClass('is-visible');
      $popup.addClass('is-visible').attr('aria-hidden', 'false');
      // Trap focus — move to first focusable element
      $popup.find('a, button').first().trigger('focus');
      // Prevent body scroll
      $('body').css('overflow', 'hidden');
    }

    // Exit-intent: mouse leaves the top of the viewport (desktop only).
    $(document).on('mouseleave.exitpopup', function (e) {
      if (e.clientY <= 0) {
        showPopup();
      }
    });

    // Scroll-depth: fire at 60% of page height.
    $(window).on('scroll.exitpopup', function () {
      if (shown) {
        $(window).off('scroll.exitpopup');
        return;
      }
      var scrolled      = $(window).scrollTop() + $(window).height();
      var pageHeight    = $(document).height();
      var depth         = scrolled / pageHeight;
      if (depth >= SCROLL_DEPTH) {
        showPopup();
        $(window).off('scroll.exitpopup');
      }
    });

    // Close on overlay click.
    $overlay.on('click', function () {
      dismiss();
    });

    // Close on dismiss button click.
    $popup.on('click', '.el-popup__close, .el-popup__dismiss', function () {
      dismiss();
    });

    // Close on Escape key.
    $(document).on('keydown.exitpopup', function (e) {
      if (e.key === 'Escape' && shown && $popup.hasClass('is-visible')) {
        dismiss();
      }
    });

    // Focus trap: keep Tab inside the modal when visible.
    $popup.on('keydown', function (e) {
      if (e.key !== 'Tab') return;
      var $focusable = $popup.find('a, button, [tabindex]:not([tabindex="-1"])');
      var $first = $focusable.first();
      var $last  = $focusable.last();
      if (e.shiftKey) {
        if ($(document.activeElement).is($first)) {
          e.preventDefault();
          $last.trigger('focus');
        }
      } else {
        if ($(document.activeElement).is($last)) {
          e.preventDefault();
          $first.trigger('focus');
        }
      }
    });
  }

  /* ── Init ────────────────────────────────────────────────────────────────── */
  $(document).ready(function () {
    initScrollReveal();
    initBackToTop();
    initContactForm();
    openFromHash();
    initMobileSubmenus();
    initExitPopup();
  });

})(jQuery);
