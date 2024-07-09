
(function (Collapse) {
   // add options / events here

   // init bootstrap native collapse
   [].forEach.call(document.querySelectorAll('[data-toggle="collapse"]'), function (element) {
      new Collapse(element);
   });
   
   accordions = document.querySelectorAll('[data-toggle="collapse"]');
   accordions.forEach(function(accordion) {

		accordion.addEventListener('click', function() {

			this.classList.toggle("data-gtm-openAccordion");
		});
   });
})(Collapse);
