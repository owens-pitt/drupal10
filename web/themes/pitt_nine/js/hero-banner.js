(function (videojs) {
   // add options / events here

   // videoJS playback controls
   function initHeroBannerPlaybackControl() {
      if (document.querySelectorAll(".hero-banner--video") != null) {
         let heroBannerVideo = document.querySelectorAll(".hero-banner--video");

         [].forEach.call(heroBannerVideo, function (el) {
            let heroBannerVideoBtn = el.querySelector(".hero-banner--video-btn");

            // pause
            function pauseHeroVideo() {
               heroBannerVideoBtn.classList.add("paused");
               let targetVideoID = el.querySelector(".video-js").id;
               console.log(el.querySelector(".video-js"));
               console.log(targetVideoID + ' <<< here')
               videojs(targetVideoID).pause();
            }

            // play
            function playHeroVideo() {
               heroBannerVideoBtn.classList.remove("paused");
               let targetVideoID = el.querySelector(".video-js").id;
               videojs(targetVideoID).play();
            }

            // toggle play/pause controls
            heroBannerVideoBtn.addEventListener("click", function () {
               if (heroBannerVideoBtn.classList.contains("paused")) {
                  playHeroVideo();
               } else {
                  pauseHeroVideo();
               }
            });
         });
      }
   }

   // init functions & events
   // --------------------------------------------------
   initHeroBannerPlaybackControl();
})(videojs);
