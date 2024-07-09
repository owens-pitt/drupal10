(function (hoverintent) {

   function initFlipCard() {

      // Flip Card Hover
      const flipCardHover = document.querySelectorAll(".card[data-interactive='flip-hover']");

      if (flipCardHover != null) {
         [].forEach.call(flipCardHover, function (self) {

            self.querySelector(".card-front").setAttribute("tabIndex", "0"); // allow focus

            // show card back
            function cardBack() {
               self.classList.add("is-active");
            }

            // show card front
            function cardFront() {
               self.classList.remove("is-active");
            }

            // event listeners
            self.addEventListener("focusin", function () {
               cardBack();
            });
            self.addEventListener("focusout", function () {
               cardFront();
            });

            // hover intent
            hoverintent(self, function () {
               // mouse enter
               cardBack();
            }, function () {
               // mouse leave
               cardFront();
            });
         });
      }

      // Flip Card Click
      const flipCardClick = document.querySelectorAll(".card[data-interactive='flip-click']");

      if (flipCardClick != null) {
         [].forEach.call(flipCardClick, function (self) {

            // show card back
            function cardBack() {
               self.classList.add("is-active");

               // Front on keyboard Esc when in focus
               self.addEventListener("focusin", function () {
                  self.addEventListener("keyup", function (e) {
                     if (e.key === "Escape") {
                        cardFront();
                     }
                  });
               });
            }

            // show card front
            function cardFront() {
               self.classList.remove("is-active");
            }

            // event listeners
            self.addEventListener("mouseleave", function () {
               cardFront();
               console.log("mouseleave");
            });
            self.querySelector(".show-card-back").addEventListener("click", function () {
               cardBack();
               console.log("click");
            });
            self.querySelector(".show-card-front").addEventListener("click", function () {
               cardFront();
               console.log("click");
            });
         });
      }
   }

   function initStackedCard() {
      const stackedCardsContainer = document.querySelectorAll(".stacked-cards-container");

      [].forEach.call(stackedCardsContainer, function () {
         function nextSlide(){
            const cardList = document.querySelectorAll(".stacked-cards");
            cardList[0].classList.add('animated');
            let stack=[];
            for(let i=0;i<cardList[0].children.length;i++){
               stack.push(cardList[0].children[i]);
            }
            //Get the last item in stack
            let order = parseInt(stack[0].getAttribute("data-order"));
            if(order+1>stack.length-1){
               iterateTo(cardList,stack[0],0);
            }else{
               iterateTo(cardList,stack[order+1],order+1);
            }
         }
         function iterateTo(nodeList,elem,idx){
            let stack=[];
            let originalOrder=[];
            const linkList = document.querySelectorAll(".stacked-cards-links");
            for(let i=0;i<nodeList[0].children.length;i++){
               originalOrder.push(nodeList[0].children[i]);
            }
            originalOrder=originalOrder.sort((a,b)=>{
               let aOrder=a.getAttribute("data-order");
               let bOrder=b.getAttribute("data-order");
               if(aOrder<bOrder){
                  return -1;
               }
               if(aOrder>bOrder){
                  return 1;
               }
               return 0;
            });
            for( let i=0;i< originalOrder.length;i++){
               if (i!== idx) {
                  linkList[0].children[i].children[0].classList.remove("active");
               }
               else {
                  linkList[0].children[i].children[0].classList.add("active");
               }
               if(i<=idx){
                  stack.unshift(originalOrder[i]);
               }
               else{
                  stack.push(originalOrder[i]);
               }
            }
            while (nodeList[0].firstChild) {
               nodeList[0].removeChild(nodeList[0].firstChild);
            }
            for(let i=0;i<stack.length;i++){
               nodeList[0].appendChild(stack[i]);
            }
         }
         function init(){
            const linkList = document.querySelectorAll(".stacked-cards-links");
            const cardList = document.querySelectorAll(".stacked-cards");

            // auto play
            let interval = setInterval(function () {
               cardList[0].classList.remove('animated');
               nextSlide();
            }, 6000);
            for(let i=0;i<cardList[0].children.length;i++){
               let card = cardList[0].children[i];
               let link = linkList[0].children[i].children[0];
			   
			   cardTitle = card.innerText;
			   
			   if(cardTitle)
			   {
				 link.setAttribute("data-contentTitle", cardTitle);
			   }
			   
               card.setAttribute("data-order",i);
               link.addEventListener("mouseover",()=>{
                  clearInterval(interval);
                  cardList[0].classList.add('animated');
                  iterateTo(cardList,card,i);
               });
               link.addEventListener("focus",()=>{
                  clearInterval(interval);
                  cardList[0].classList.add('animated');
                  iterateTo(cardList,card,i);
               });
               link.addEventListener("mouseout",()=>{
                  interval = setInterval(()=> {

                     nextSlide();
                  }, 6000);
               });
               link.addEventListener("blur",()=>{
                  interval = setInterval(()=> {
                     nextSlide();
                  }, 6000);
               });
            }
         }
         init();
      });
   }

   // init functions
   initFlipCard();
   initStackedCard();
})(hoverintent);