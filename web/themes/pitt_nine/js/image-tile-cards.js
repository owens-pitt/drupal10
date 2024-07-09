// import styles

(function () {
   function initImgTileCards() {
      const tileTrigger = document.querySelectorAll('.image-tile-cards-trigger');

      if (tileTrigger.length !==0) {
         for (let i =0; i<tileTrigger.length; i++) {
            tileTrigger[i].addEventListener('click', function () {
               // console.log('tile expanded');
               tileTrigger[i].parentElement.parentElement.classList.toggle('expanded');
            });
         }
      }
   }

   initImgTileCards();
})(hoverintent);