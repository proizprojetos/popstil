window.addEvent('domready', function(){
   document.formvalidator.setHandler('texto', function(value) {
      regex=/^\d{4}-\d{2}-\d{2}$/;
      return regex.test(value);
   });
});

