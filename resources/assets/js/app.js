window.LaravelApp = window.LaravelApp || { 'settings': {}, 'behaviors': {}, 'locale': {} };
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

(function ($) {

  LaravelApp.attachBehaviors = function (context, settings) {
    context = context || document;
    settings = settings || LaravelApp.settings;
    // Execute all of them.
    $.each(LaravelApp.behaviors, function () {
      if ($.isFunction(this.attach)) {
        this.attach(context, settings);
      }
    });
  };

  //Attach all behaviors.
  $(function () {
    LaravelApp.attachBehaviors(document, LaravelApp.settings);
  });

})(jQuery);
