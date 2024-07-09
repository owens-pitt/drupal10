(function (debounce, gsap, ScrollTrigger) {

  function initRankingList() {
    if (document.querySelectorAll(".ranking-list") != null) {
      let rankingList = document.querySelectorAll(".ranking-list");

      [].forEach.call(rankingList, function (el) {
        let stickyContent = el.querySelector(".ranking-list-sticky-content");
        let rankingListBg = el.querySelector(".ranking-list-bg");

        ScrollTrigger.matchMedia({

          // setup animations and ScrollTriggers for screens 768px wide or greater
          // These ScrollTriggers will be reverted/killed when the media query doesn't match anymore.
          "(min-width: 992px)": function () {

            window.addEventListener(
              "resize",
              debounce(function () {
                ScrollTrigger.refresh();
              }, 250)
            );

            let leftCol = ScrollTrigger.create({
              trigger: stickyContent,
              start: "top top",
              endTrigger: el,
              end: "bottom bottom",
              pin: true,
              pinSpacing: false
            });

            // bg image trigger
            let stickyBg = ScrollTrigger.create({
              trigger: rankingListBg,
              start: "top top",
              endTrigger: el,
              end: "bottom bottom",
              pin: true,
              pinSpacing: false
            });

            ScrollTrigger.refresh();
            leftCol.enable();
            stickyBg.enable();
          },
          // setup animations and ScrollTriggers for screens 767px wide or less
          "(max-width: 767px)": function () {
            console.log("mobile");
          }
        });
      });
    }
  }

  function initTileTriggers() {
    const tileTrigger = document.querySelectorAll('.ranking-list-scroll-item-trigger');

    if (tileTrigger.length !== 0) {
      for (let i = 0; i < tileTrigger.length; i++) {
        tileTrigger[i].addEventListener('click', function () {
          // console.log('tile expanded');
          tileTrigger[i].parentElement.classList.toggle('expanded');
        });
      }
    }
  }

  // init functions & events
  // --------------------------------------------------
  initRankingList();
  initTileTriggers();

})(Drupal.debounce, gsap, ScrollTrigger);
