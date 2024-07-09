
(function (Swiper_alt) {


  // carousel
  function initCarousel() {

    if (document.querySelectorAll(".swiper-alt-container--base") != null) {
      let carouselBase = document.querySelectorAll(".swiper-alt-container--base");

      // forEach function necessary if page has multiple instances of the same carousel
      [].forEach.call(carouselBase, function(el) {

        new Swiper(el, {

          slidesPerView: 1,
          autoHeight: true,
          loop: true,
          noSwipingSelector: "button, a",
          preloadImages: false,

          // pagination
          pagination: {
            el: ".carousel-pagination",
            bulletActiveClass: "active",
            bulletElement: "button",
            clickable: true

          },

          // navigation
          navigation: {
            nextEl: ".carousel-controls-next",
            prevEl: ".carousel-controls-prev"
          },

          // lazy load
          lazy: {
            elementClass: "lazy-load",
            loadedClass: "loaded",
            loadPrevNext: true
          },

          // keyboard
          keyboard: true,

          // accessibility
          a11y: true,
		  on: {
			afterInit: function () {
			  addGTMTitle();
			},
			slideChangeTransitionEnd: function(){
				addGTMTitle();
			}
		  }

        });

		function addGTMTitle()
		{
			let title = document.querySelector(".swiper-alt-slide-active h2").innerText;
			let prevButton = document.querySelector(".carousel-controls-prev");
			prevButton.setAttribute("data-contentTitle", title);
			let nextButton = document.querySelector(".carousel-controls-next");
			nextButton.setAttribute("data-contentTitle", title);
		}
		
      });
    }
  }

  // carousel gallery
  function initCarouselCards() {

    // init base carousel
    if (document.querySelectorAll(".swiper-alt-container--cards") != null) {
      let carouselCards = document.querySelectorAll(".swiper-alt-container--cards");

      // forEach function necessary if page has multiple instances of the same carousel
      [].forEach.call(carouselCards, function(el) {

        new Swiper_alt(el, {
          autoHeight: false,
          loop: true,
          noSwipingSelector: "button, a",
          centeredSlides :true,
          breakpoints: {
            // when window width is > or = to
            0: {
              slidesPerView: 1,
              slidesPerGroup: 1,
              spaceBetween: 20
            },
            768: {
              slidesPerView: 2,
              slidesPerGroup:1,
              spaceBetween: 20
            },
            1180: {
              slidesPerView: 4,
              slidesPerGroup: 1,
              spaceBetween: 20
            }
          },

          // pagination
          pagination: {
            el: ".carousel-pagination",
            bulletActiveClass: "active",
            bulletElement: "button",
            clickable: true
          },

          // navigation
          navigation: {
            nextEl: ".carousel-controls-next",
            prevEl: ".carousel-controls-prev"
          },

          // lazy load
          lazy: {
            elementClass: "lazy-load",
            loadedClass: "loaded",
            loadPrevNext: true,
            watchSlidesVisibility: true
          },

          // keyboard
          keyboard: true,

          // accessibility
          a11y: true

        });

      });
    }
  }

  //custom carousel
  function initCardCarousel() {
    const cardCarouselContainer = document.querySelectorAll(".card-carousel");

    [].forEach.call(cardCarouselContainer, function () {
      function replaceNodes(nodeList, stack) {
        while (nodeList[0].firstChild) {
          nodeList[0].removeChild(nodeList[0].firstChild);
        }
        for (let i = 0; i < stack.length; i++) {
          nodeList[0].appendChild(stack[i]);
        }
      }

      function getOriginalOrder(nodeList) {
        let originalOrder = [];
        for (let i = 0; i < nodeList[0].children.length; i++) {
          originalOrder.push(nodeList[0].children[i]);
        }

        originalOrder = originalOrder.sort((a, b) => {
          let aOrder = a.getAttribute("data-order");
          let bOrder = b.getAttribute("data-order");
          if (aOrder < bOrder) {
            return -1;
          }
          if (aOrder > bOrder) {
            return 1;
          }
          return 0;
        });
        return originalOrder;
      }

      function iterateTo(nodeList, elem, idx) {
        const descList = document.querySelectorAll(".card-carousel-content");
        const preview = document.querySelectorAll(".card-carousel-slide-btn-next");
        const linkList = document.querySelectorAll(".card-carousel-nav");

        let cardOrigOrder = getOriginalOrder(nodeList);
        let descOrigOrder = getOriginalOrder(descList);

        let cardStack = [];
        let descStack = [];

        for (let i = 0; i < cardOrigOrder.length; i++) {
          if (i === idx) {
            linkList[0].children[i].children[0].classList.add("active");
            descList[0].children[i].querySelectorAll('.card-carousel-slide-header')[0].children[0].tabIndex = 0;
          } else {
            linkList[0].children[i].children[0].classList.remove("active");
            descList[0].children[i].querySelectorAll('.card-carousel-slide-header')[0].children[0].tabIndex = -1;
          }
          if (i <= idx) {
            cardStack.unshift(cardOrigOrder[i]);
            descStack.unshift(descOrigOrder[i]);
          } else {
            cardStack.push(cardOrigOrder[i]);
            descStack.push(descOrigOrder[i]);
          }
        }

        replaceNodes(nodeList, cardStack);
        replaceNodes(descList, descStack);
        let nxtIdx = parseInt(idx) + 1 >= descStack.length ? descStack.length - 1 : parseInt(idx) + 1;

        let descHeader = descStack[nxtIdx].querySelectorAll('.card-carousel-slide-header')[0].children[0].innerHTML;

        const tierPage = document.getElementsByClassName('hero-banner--tier');

/*
        if (!tierPage.length) {
          preview[0].textContent = descHeader;
        }
*/

      }

      function nextSlide() {
        const cardList = document.querySelectorAll(".card-carousel-image");
        cardList[0].classList.add('animated');
        let stack = [];
        for (let i = 0; i < cardList[0].children.length; i++) {
          stack.push(cardList[0].children[i]);
        }
        //Get the last item in stack
        let order = parseInt(stack[0].getAttribute("data-order"));
        if (order + 1 > stack.length - 1) {
          iterateTo(cardList, stack[0], 0);
        } else {
          iterateTo(cardList, stack[order + 1], order + 1);
        }

        window.setTimeout(()=> {
          cardList[0].classList.remove('animated');
        },1000);
      }

      function init() {

        const linkList = document.querySelectorAll(".card-carousel-nav");
        const cardList = document.querySelectorAll(".card-carousel-image");
        const descList = document.querySelectorAll(".card-carousel-content");
        const previewButton = document.querySelectorAll(".card-carousel-slide-btn-next");

        for (let i = 0; i < cardList[0].children.length; i++) {
          let card = cardList[0].children[i];
          let link = linkList[0].children[i].children[0];
          let desc = descList[0].children[i];

          card.setAttribute("data-order", i);
          desc.setAttribute("data-order", i);

          link.addEventListener("click", () => {
            cardList[0].classList.add('animated');
            iterateTo(cardList, card, i);
          });
        }

        iterateTo(cardList, cardList[0].children[0], 0);


/*
        const tierPage = document.getElementsByClassName('hero-banner--tier');

        if (!tierPage.length) {
          previewButton[0].addEventListener("click", () => {
            nextSlide();
          });
        }
*/
      }

      init();
    });
  }
  
  

  // init functions & events
  // --------------------------------------------------
  initCarousel();
  initCarouselCards();
  initCardCarousel();

})(Swiper_alt);

