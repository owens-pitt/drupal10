
(function (debounce, gsap, ScrollTrigger) {
   // add options / events here

   // add keyboard tab class
   // check to see if user is tabbing - then toggle class to body for styled focus
   function initKeyTabToggle() {
      function userTabbing(e) {
         if (e.keyCode === 9 && !document.body.classList.contains("is-tabbing")) {
            document.body.classList.add("is-tabbing");
         }
      }

      function userNotTabbing() {
         if (document.body.classList.contains("is-tabbing")) {
            document.body.classList.remove("is-tabbing");
         }
      }

      window.addEventListener("keydown", userTabbing);
      window.addEventListener("click", userNotTabbing);
   }

   // get inner height of viewport and set custom property to root
   // used to maximize viewport on mobile scrolling
   function initMobileHeightCalc() {
      if (!window.matchMedia("(min-width: 992px)").matches) {
         const vh = window.innerHeight * 0.01;
         document.documentElement.style.setProperty("--vh", `${vh}px`);
         // resize event with debounce for performance.
         window.addEventListener(
            "resize",
            debounce(function () {
               initMobileHeightCalc();
            }, 500)
         );
      }
   }

   //init smooth scroll
   function initSmoothScroll() {
      function scrollAnchors(e, respond = null) {
         const distanceToTop = (el) => Math.floor(el.getBoundingClientRect().top);
         e.preventDefault();
         var targetID = respond ? respond.getAttribute("href") : this.getAttribute("href");
         const targetAnchor = document.querySelector(targetID);
         if (!targetAnchor) return;
         const originalTop = distanceToTop(targetAnchor);
         window.scrollBy({top: originalTop, left: 0, behavior: "smooth"});
         const checkIfDone = setInterval(function () {
            const atBottom = window.innerHeight + window.pageYOffset >= document.body.offsetHeight - 2;
            if (distanceToTop(targetAnchor) === 0 || atBottom) {
               targetAnchor.tabIndex = "-1";
               targetAnchor.focus();
               window.history.pushState("", "", targetID);
               clearInterval(checkIfDone);
            }
         }, 100);
      }

      // example <a href="#anchorID" class="anchor-link">
      if (document.querySelector(".anchor-link") != null) {
         let links = document.querySelectorAll(".anchor-link");
         [].forEach.call(links, function (each) {
            each.onclick = scrollAnchors;
         });
      }
   }

   //init progress bar Pittwire
   function initProgressBar() {
      if (document.querySelector(".progress-wrapper") != null) {
         let progressBar = document.querySelector(".progress-bar");

         gsap.to(progressBar, {
            scrollTrigger: {
               onUpdate: (self) => {
                  progressBar.style.width = self.progress.toFixed(5) * 100 + "%";
               }
            }
         });
      }
   }

   // Init Functions & Events
   // --------------------------------------------------
   initKeyTabToggle();
   initMobileHeightCalc();
   initSmoothScroll();
   initProgressBar();

})(Drupal.debounce, gsap, ScrollTrigger);
