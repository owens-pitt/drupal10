
(function () {
   // add options / events here

   // media callout caption
   function initMediaCalloutCaption() {
      let mediaCaptionBtn = document.querySelectorAll(".media-caption-btn");

      if (mediaCaptionBtn != null) {
         [].forEach.call(mediaCaptionBtn, function (mediaCaptionBtn) {
            let mediaCalloutCaption = mediaCaptionBtn.nextElementSibling;

            // show caption
            function showCaption() {
               mediaCaptionBtn.setAttribute("aria-expanded", "true");
               mediaCaptionBtn.classList.add("active");
               mediaCalloutCaption.classList.remove("animate-out");
               mediaCalloutCaption.classList.add("animate-in");
               mediaCalloutCaption.setAttribute("aria-hidden", "false");
               if (mediaCalloutCaption.classList.contains("hidden")) {
                  mediaCalloutCaption.classList.remove("hidden");
               }

               // Hide Menu on keyboard Esc
               document.addEventListener("keyup", function (e) {
                  if (e.key === "Escape") {
                     hideCaption();
                  }
               });
            }

            // hide caption
            function hideCaption() {
               mediaCaptionBtn.setAttribute("aria-expanded", "false");
               mediaCaptionBtn.classList.remove("active");
               mediaCalloutCaption.classList.remove("animate-in");
               mediaCalloutCaption.classList.add("animate-out");
               mediaCalloutCaption.setAttribute("aria-hidden", "true");
               captionAnimationCallback();
            }

            // caption callbacks
            function captionAnimationCallback() {
               mediaCalloutCaption.addEventListener("animationend", transitionEnd, false);
               function transitionEnd() {
                  if (mediaCalloutCaption.classList.contains("animate-out")) {
                     mediaCalloutCaption.classList.remove("animate-out");
                     mediaCalloutCaption.classList.add("hidden");
                  }
               }
            }

            // Show/Hide Menu on btn trigger
            mediaCaptionBtn.addEventListener("click", function () {
               if (mediaCalloutCaption.classList.contains("animate-in")) {
                  hideCaption();
               } else {
                  showCaption();
               }
            });
         });
      }
   }

   // init functions & events
   // --------------------------------------------------
   initMediaCalloutCaption();
})();
