(function (videojs) {
   // add options / events here

   // global options for videoJS
   function initVideoJSGlobalOptions() {
      if (document.querySelectorAll(".video-js") != null) {
         const video = document.querySelectorAll(".video-js");

         // for each video-js
         [].forEach.call(video, function (video) {
            // enable responsive mode - https://docs.videojs.com/tutorial-options.html#responsive
            videojs(video).responsive(true);
         });
      }
   }

   // play/pause videoJS on modal show/hide
   function initVideoJSModal() {
      if (document.querySelector(".modal--video") != null) {
         const modalVideo = document.querySelectorAll(".modal--video");

         [].forEach.call(modalVideo, function (modalVideo) {
            // when modal is open
            modalVideo.addEventListener(
               "show.bs.modal",
               function () {
                  playTargetVideo(modalVideo);
                  toggleCurrentVideos(modalVideo);
               },
               false
            );

            // when modal is closed
            modalVideo.addEventListener(
               "hide.bs.modal",
               function () {
                  pauseTargetVideo(modalVideo);
               },
               false
            );
         });
      }

      // autoplay target video
      function playTargetVideo(modalVideo) {
         if (modalVideo.querySelector(".video-js")) {
            const targetVideoID = modalVideo.querySelector(".video-js").id;
            videojs(targetVideoID).play();
         }
      }

      // pause target video
      function pauseTargetVideo(modalVideo) {
         if (modalVideo.querySelector(".video-js")) {
            const targetVideoID = modalVideo.querySelector(".video-js").id;
            videojs(targetVideoID).pause();
         }
      }

      // while modal is opened pause video currently playing in the background
      function toggleCurrentVideos(modalVideo) {
         if (document.querySelectorAll(".video-js.vjs-playing") != null) {
            const videoCurrentlyPlaying = document.querySelectorAll(".video-js.vjs-playing");

            // for each video-js that is currently playing
            [].forEach.call(videoCurrentlyPlaying, function (videoCurrentlyPlaying) {
               // get ID of playing video
               const videoCurrentlyPlayingID = videoCurrentlyPlaying.id;

               videojs(videoCurrentlyPlayingID).pause();

               // when modal is closed
               modalVideo.addEventListener(
                  "hide.bs.modal",
                  function () {
                     videojs(videoCurrentlyPlayingID).play();
                  },
                  false
               );
            });
         }
      }
   }

   // init functions & events
   // --------------------------------------------------
   initVideoJSGlobalOptions();
   initVideoJSModal();
})(videojs);
