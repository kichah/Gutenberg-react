/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./src-blocks/product-carousel/view.js ***!
  \*********************************************/
__webpack_require__.r(__webpack_exports__);
/**
 * Frontend JavaScript for Product Carousel
 * Handles multiple carousels on the same page
 */
const AUTO_PLAY_TIME = 2000;
(function () {
  'use strict';

  function initProductCarousels() {
    // Check if EmblaCarousel is available
    if (typeof EmblaCarousel === 'undefined') {
      console.error('EmblaCarousel library not loaded');
      return;
    }

    // Find ALL carousel blocks on the page
    const carouselBlocks = document.querySelectorAll('.wc-product-carousel-block');
    console.log('Found', carouselBlocks.length, 'carousel blocks');

    // Initialize each carousel independently
    carouselBlocks.forEach(function (carouselBlock, index) {
      const emblaNode = carouselBlock.querySelector('.embla');
      if (!emblaNode) {
        console.error('Carousel element not found in block', index);
        return;
      }
      const loop = emblaNode.dataset.loop === 'true';
      const autoplay = emblaNode.dataset.autoplay === 'true';
      const navigationDiv = carouselBlock.querySelector('.carousel-navigation');
      console.log('Initializing carousel', index, '{ loop:', loop, 'autoplay:', autoplay, '}');

      // Function to get slides based on screen width
      function getSlidesToShow() {
        const width = window.innerWidth;
        if (width < 480) {
          return 1;
        } else if (width < 768) {
          return 2;
        } else if (width < 1024) {
          return 3;
        }
        return 4;
      }

      // Function to update slide widths
      function updateSlideWidths() {
        const slidesToShow = getSlidesToShow();
        const slideWidth = 100 / slidesToShow;
        const slides = emblaNode.querySelectorAll('.embla__slide');
        slides.forEach(slide => {
          slide.style.flex = `0 0 ${slideWidth}%`;
        });
      }

      // Function to show/hide navigation
      function updateNavigationVisibility() {
        const slidesToShow = getSlidesToShow();
        const totalProducts = emblaNode.querySelectorAll('.embla__slide').length;
        if (navigationDiv) {
          if (totalProducts > slidesToShow) {
            navigationDiv.style.display = 'flex';
          } else {
            navigationDiv.style.display = 'none';
          }
        }
      }

      // Initial setup
      updateSlideWidths();

      // Initialize Embla Carousel
      const emblaApi = EmblaCarousel(emblaNode, {
        loop,
        slidesToScroll: 1,
        align: 'start',
        containScroll: 'trimSnaps'
      });

      // Get navigation buttons for THIS specific carousel
      const prevBtn = carouselBlock.querySelector('.embla__prev');
      const nextBtn = carouselBlock.querySelector('.embla__next');

      // Button handlers
      if (prevBtn) {
        prevBtn.addEventListener('click', function (e) {
          e.preventDefault();
          emblaApi.scrollPrev();
        });
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
          e.preventDefault();
          emblaApi.scrollNext();
        });
      }

      // Update button states
      function updateButtonStates() {
        if (prevBtn) {
          const canScrollPrev = emblaApi.canScrollPrev();
          prevBtn.disabled = !canScrollPrev;
          prevBtn.style.opacity = canScrollPrev ? '1' : '0.3';
        }
        if (nextBtn) {
          const canScrollNext = emblaApi.canScrollNext();
          nextBtn.disabled = !canScrollNext;
          nextBtn.style.opacity = canScrollNext ? '1' : '0.3';
        }
      }

      // Set up Embla events
      emblaApi.on('select', updateButtonStates);
      emblaApi.on('init', function () {
        updateButtonStates();
        updateNavigationVisibility();
      });

      // Initial updates
      updateButtonStates();
      updateNavigationVisibility();

      // Autoplay functionality
      let autoplayInterval;
      if (autoplay) {
        autoplayInterval = setInterval(function () {
          emblaApi.scrollNext();
        }, AUTO_PLAY_TIME);
        emblaNode.addEventListener('mouseenter', function () {
          if (autoplayInterval) {
            clearInterval(autoplayInterval);
          }
        });
        emblaNode.addEventListener('mouseleave', function () {
          if (autoplay) {
            autoplayInterval = setInterval(function () {
              emblaApi.scrollNext();
            }, AUTO_PLAY_TIME);
          }
        });
      }

      // Update on window resize with debounce
      let resizeTimeout;
      window.addEventListener('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function () {
          updateSlideWidths();
          emblaApi.reInit();
          updateButtonStates();
          updateNavigationVisibility();
        }, 250);
      });
      console.log('Carousel', index, 'initialized successfully');
    });
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initProductCarousels);
  } else {
    initProductCarousels();
  }
})();
/******/ })()
;
//# sourceMappingURL=view.js.map