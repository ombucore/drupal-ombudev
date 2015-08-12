if (typeof(DevelDebugBar) == 'undefined') {
  // namespace
  var DevelDebugBar = {};
  DevelDebugBar.Widgets = {};

}

(function($, PhpDebugBar) {

  DevelDebugBar.Widgets.MarkupWidget = PhpDebugBar.Widget.extend({

  className: 'debug-bar-markup-widget',

  render: function() {

    this.bindAttr('data', function(data) {
      this.$el.html(data);
    });

  }

});

})(jQuery, PhpDebugBar);

