if (typeof(DeveloperToolbar) == 'undefined') {
  // namespace
  var DeveloperToolbar = {};
  DeveloperToolbar.Widgets = {};

}

(function($, PhpDebugBar) {

  var csscls = PhpDebugBar.utils.makecsscls('phpdebugbar-widgets-');

  DeveloperToolbar.Widgets.DatabaseWidget = PhpDebugBar.Widget.extend({

    className: csscls('database'),

    onFilterClick: function(el) {
      $(el).toggleClass(csscls('excluded'));

      var excludedLabels = [];
      this.$toolbar.find(csscls('.filter') + csscls('.excluded')).each(function() {
        excludedLabels.push(this.rel);
      });

      this.$list.$el.find("li[connection=" + $(el).attr("rel") + "]").toggle();

      this.set('exclude', excludedLabels);
    },

    render: function() {
      this.$status = $('<div />').addClass(csscls('status')).appendTo(this.$el);

      this.$toolbar = $('<div></div>').addClass(csscls('toolbar')).appendTo(this.$el);

      var filters = [], self = this;

      this.$list = new PhpDebugBar.Widgets.ListWidget({ itemRenderer: function(li, stmt) {
        $('<code />').addClass(csscls('sql')).html(PhpDebugBar.Widgets.highlight(stmt.sql, 'sql')).appendTo(li);
        if (stmt.duration) {
          $('<span title="Duration" />').addClass(csscls('duration')).text(stmt.duration).appendTo(li);
        }
        if (stmt.connection) {
          $('<span title="Connection" />').addClass(csscls('database')).text(stmt.connection).appendTo(li);
          li.attr("connection",stmt.connection);
          if ( $.inArray(stmt.connection, filters) == -1 ) {
            filters.push(stmt.connection);
            $('<a href="javascript:" />')
              .addClass(csscls('filter'))
              .text(stmt.connection)
              .attr('rel', stmt.connection)
              .on('click', function() { self.onFilterClick(this); })
              .appendTo(self.$toolbar);
            if (filters.length>1) {
              self.$toolbar.show();
              self.$list.$el.css("margin-bottom","20px");
            }
          }
        }
        if (stmt.params && !$.isEmptyObject(stmt.params)) {
          var table = $('<table><tr><th colspan="2">Params</th></tr></table>').addClass(csscls('params')).appendTo(li);
          for (var key in stmt.params) {
            if (typeof stmt.params[key] !== 'function') {
              table.append('<tr><td class="' + csscls('name') + '">' + key + '</td><td class="' + csscls('value') +
                  '">' + stmt.params[key] + '</td></tr>');
            }
          }
          li.css('cursor', 'pointer').click(function() {
            if (table.is(':visible')) {
              table.hide();
            } else {
              table.show();
            }
          });
        }
      }});
      this.$list.$el.appendTo(this.$el);

      this.bindAttr('data', function(data) {
        this.$list.set('data', data.statements);
        this.$status.empty();

        // Search for duplicate statements.
        for (var sql = {}, duplicate = 0, i = 0; i < data.statements.length; i++) {
          var stmt = data.statements[i].sql;
          if (data.statements[i].params && !$.isEmptyObject(data.statements[i].params)) {
            stmt += ' {' + $.param(data.statements[i].params, false) + '}';
            }
            sql[stmt] = sql[stmt] || { keys: [] };
            sql[stmt].keys.push(i);
          }
          // Add classes to all duplicate SQL statements.
          for (var stmt in sql) {
            if (sql[stmt].keys.length > 1) {
              duplicate++;
              for (var i = 0; i < sql[stmt].keys.length; i++) {
                this.$list.$el.find('.' + csscls('list-item')).eq(sql[stmt].keys[i])
                  .addClass(csscls('sql-duplicate')).addClass(csscls('sql-duplicate-'+duplicate));
              }
            }
          }

          var t = $('<span />').text(data.total_statements + " statements were executed").appendTo(this.$status);
          if (duplicate) {
            t.append(", " + duplicate + " of which were duplicated");
          }
          if (data.total_duration) {
            this.$status.append($('<span title="Accumulated duration" />').addClass(csscls('duration')).text(data.total_duration));
          }
        });
      }

    });

})(jQuery, PhpDebugBar);

