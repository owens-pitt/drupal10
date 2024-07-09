// const options to be added to the script page and updated per module
// el represents the element that needs the transition in / out

// use this to import into another script
// import {options, show, hide} from "../../scripts/transition";

var options = {
   stateOpening: "is-animating-in",
   stateOpened: "is-visible",
   stateClosing: "is-animating-out",
   stateClosed: "is-hidden",
   transition: true
};

// show element -- transition in
var show = function(el, settings) {
   return new Promise((resolve) => {
      if (settings.transition) {
         el.classList.remove(settings.stateClosed);
         el.classList.add(settings.stateOpening);

         // on element transition end
         el.addEventListener("animationend", function _f() {
            // prevent bubbling if element state is closed
            if(el.classList.contains(settings.stateClosed)) {
               el.classList.remove(settings.stateClosed);
            }
            el.classList.add(settings.stateOpened);
            el.setAttribute("aria-hidden", false);
            el.classList.remove(settings.stateOpening);
            resolve(el);
            this.removeEventListener("animationend", _f);
         });
      } else {
         el.classList.add(settings.stateOpened);
         el.classList.remove(settings.stateClosed);
         el.setAttribute("aria-hidden", false);
         resolve(el);
      }
   });
};

// hide element -- transition out
var hide = function(el, settings) {
   return new Promise((resolve) => {
      if (settings.transition) {
         el.classList.add(settings.stateClosing);
         el.classList.remove(settings.stateOpened);

         // if element state is still opening
         if(el.classList.contains(settings.stateOpening)) {
            el.classList.remove(settings.stateOpening);
         }

         // on element transition end
         el.addEventListener("animationend", function _f() {
            // prevent bubbling if element state is opened
            if(el.classList.contains(settings.stateOpened)) {
               el.classList.remove(settings.stateOpened);
            }
            el.classList.remove(settings.stateClosing);
            el.classList.add(settings.stateClosed);
            el.setAttribute("aria-hidden", true);
            resolve(el);
            this.removeEventListener("animationend", _f);
         });
      } else {
         el.classList.add(settings.stateClosed);
         el.classList.remove(settings.stateOpened);
         el.setAttribute("aria-hidden", true);
         resolve(el);
      }
   });
};

// how to use in your script
// if (el.classList.contains(options.stateClosed)) {
//    show(el, options);
//
//    // additional options can go here...
// }
//
// if (el.classList.contains(options.stateOpened)) {
//    hide(el, options);
//
//    // additional options can go here...
// }
