/**
 * Envision Legal – Theme JavaScript
 * Handles: mobile nav, accordion, smooth scroll, back-to-top
 */
(function ($) {
  'use strict';

  /* ── Mobile Navigation ──────────────────────────────────────────────────── */
  var $toggle = $('.el-nav-toggle');
  var $nav    = $('.el-nav');

  $toggle.on('click', function () {
    var expanded = $(this).attr('aria-expanded') === 'true';
    $(this).attr('aria-expanded', String(!expanded));
    $nav.toggleClass('is-open');
  });

  // Close nav when clicking outside
  $(document).on('click', function (e) {
    if (!$(e.target).closest('.el-header').length) {
      $toggle.attr('aria-expanded', 'false');
      $nav.removeClass('is-open');
    }
  });

  /* ── Accordion ──────────────────────────────────────────────────────────── */
  $(document).on('click', '.el-accordion__trigger', function () {
    var $trigger = $(this);
    var $item    = $trigger.closest('.el-accordion__item');
    var $panel   = $item.find('.el-accordion__panel');
    var isOpen   = $trigger.attr('aria-expanded') === 'true';

    // Close all other panels in the same accordion
    $trigger.closest('.el-accordion').find('.el-accordion__trigger').each(function () {
      if (this !== $trigger[0]) {
        $(this).attr('aria-expanded', 'false');
        $(this).closest('.el-accordion__item')
               .find('.el-accordion__panel')
               .removeClass('is-open')
               .css('max-height', '');
      }
    });

    // Toggle this panel
    if (isOpen) {
      $trigger.attr('aria-expanded', 'false');
      $panel.removeClass('is-open').css('max-height', '');
    } else {
      $trigger.attr('aria-expanded', 'true');
      $panel.addClass('is-open').css('max-height', $panel[0].scrollHeight + 'px');
    }
  });

  /* ── Smooth Scroll ──────────────────────────────────────────────────────── */
  $(document).on('click', 'a[href^="#"]', function (e) {
    var target = $(this.hash);
    if (target.length) {
      e.preventDefault();
      var headerHeight = $('.el-header').outerHeight() || 0;
      $('html, body').animate(
        { scrollTop: target.offset().top - headerHeight - 20 },
        400
      );
    }
  });

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
      id:             'el-back-to-top',
      'aria-label':   'Back to top',
      html:           '&#8679;',
      css: {
        position:   'fixed',
        bottom:     '2rem',
        right:      '2rem',
        width:      '44px',
        height:     '44px',
        background: 'var(--el-navy)',
        color:      '#fff',
        border:     'none',
        borderRadius: '50%',
        fontSize:   '1.4rem',
        cursor:     'pointer',
        opacity:    '0',
        transition: 'opacity 0.3s ease',
        zIndex:     '50',
        display:    'flex',
        alignItems: 'center',
        justifyContent: 'center',
      }
    });

    $('body').append($btn);

    $(window).on('scroll.btt', function () {
      if ($(this).scrollTop() > 400) {
        $btn.css('opacity', '1');
      } else {
        $btn.css('opacity', '0');
      }
    });

    $btn.on('click', function () {
      $('html, body').animate({ scrollTop: 0 }, 300);
    });
  }

  /* ── Contact form helper (works with CF7 / WPForms) ─────────────────────── */
  function initContactForm() {
    // CF7 hook
    $(document).on('wpcf7mailsent', function () {
      $('.el-form-success').fadeIn();
    });
  }

  /* ── Visible class for animated items ───────────────────────────────────── */
  $(document).on('animationend transitionend', '.el-card.is-visible, .el-practice-card.is-visible', function () {
    $(this).css({ opacity: '', transform: '' });
  });

  // Add CSS rule for visible state dynamically
  var style = document.createElement('style');
  style.textContent = '.is-visible { opacity: 1 !important; transform: translateY(0) !important; }';
  document.head.appendChild(style);

  /* ── Init ────────────────────────────────────────────────────────────────── */
  $(document).ready(function () {
    initScrollReveal();
    initBackToTop();
    initContactForm();
  });

})(jQuery);
