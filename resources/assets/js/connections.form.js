(function ($, LaravelApp, window, document, undefined) {

  var serviceBoard;
  var $statusMaps = $('.status-maps');
  var $statusMapGroupItem = $('.status-map-group--item').first().clone();


  LaravelApp.behaviors.test = {
    attach: function(context, settings) {
      this.select2Init();
      this.serviceMappingAddMore();
      this.removeInput();
    },

    getCwStatuses: function (boardId, callback) {
      $.get("/ajax/get-cw-board-statuses?q=" + boardId, function (data) {
        $.each(data, function(i, v) {
          data[i].text = v.name;
        });
        callback(data);
      });
    },

    select2Init: function () {

      var self = this;

      $('.select-ajax--jira-project').once().select2({
        placeholder: 'Search for a project',
        ajax: {
          url: "/ajax/get-jira-projects",
          dataType: 'json',
          delay: 1000,
          data: function (params) {
            return {
              q: params.term
            };
          },
          processResults: function (data, params) {
            var result = [];
            $.each(data, function(i,v){

              result.push({
                text: data[i].name + ' - (' + data[i].key + ')',
                id: data[i].key
              });
            });
            return { results: result }
          },
          cache: true
        },
        minimumInputLength: 1
      });

      $(".select-ajax--cw-company").once().select2({
        placeholder: 'Search for a company',
        ajax: {
          url: "/ajax/find-cw-companies",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              q: params.term
            };
          },
          processResults: function (data, params) {
            $.each(data, function(i,v){
              data[i].text = data[i].name
            });
            return { results: data }
          },
          cache: true
        },
        minimumInputLength: 1
      }).on('select2:select', function (evt) {
        $(".select-ajax--cw-agreement").removeAttr('disabled');
      });

      $(".select-ajax--cw-boards").once('cw-service-board').each(function(){
        $(this).select2({
          placeholder: 'Select a service board',
        })

        .on('select2:select', '.select-ajax--status-map-cw', function (evt) {
          self.serviceBoard = $(this).val();
          self.getCwStatuses(self.serviceBoard, function(data) {
            $('.select-ajax--status-map-cw').trigger('change.select2');
          });
        });

        self.serviceBoard = $(this).val();

      });


      $(".select-ajax--cw-priority").once().select2({
        placeholder: 'Select a priority'
      });

      $('.select-ajax--status-map-cw').once().each(function(){
        var $this = $(this);
        self.getCwStatuses(self.serviceBoard, function(data) {
          $.each(data, function (i, v) {
            $this.append('<option value="' + v.id + '">' + v.name + '</option>');
          });
          $this.select2({placeholder: 'Select a ticket status'});
        });
      });


      $('.select-ajax--status-map-jira').once().val('').select2({
        placeholder: 'Select a Jira status'
      });

      $(".select-ajax--cw-agreement").once().select2({
        placeholder: 'Select an agreement',
        ajax: {
          url: "/ajax/find-cw-agreements",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              q: $(".select-ajax--cw-company").val()
            };
          },
          formatNoMatches: function () {
            return "No Results Found <a href='#' class='btn btn-danger'>Use it anyway</a>";
          },
          processResults: function (data, params) {
            data = results = Array.isArray(data) ? data : [data];
            $.each(data, function(i,v){
              data[i].text = data[i].name
            });
            return { results: data }
          },
          cache: true
        },
      });
    },

    serviceMappingAddMore: function() {
      var self = this;
      $('.jira-cw-status-map-add').once('add-another').click(function () {
        var $clone = $statusMapGroupItem.clone();
        $clone.find('select').removeAttr('disabled');

        var index = $statusMaps.find('.status-map-group--item').length;

        $.each($clone.find('select'), function(i,v){
          var name = $(this).attr('name');
          var newName = name.replace(/([0-9])/, index);
          $(this).attr('name', newName);
        });

        $('.status-map-group').append($clone);
        $statusMaps = $('.status-maps');
        self.attach();
      });
    },

    removeInput: function () {
      $('.close').once('remove-input').click(function(e){
        var $parent = $(this).closest('.form-group');
        if ($parent.index() !== 0) {
          $parent.remove();
        }
      });
    }

  };

})(jQuery, LaravelApp, this, this.document);



// $(document).ready(function(){


//   $('.jira-cw-status-map-add').click(function () {
//     var $clone = $statusMapGroupItem.clone();
//     $clone.find('select').removeAttr('disabled');

//     var index = $statusMaps.find('.status-map-group--item').length;

//     $.each($clone.find('select'), function(i,v){
//       var name = $(this).attr('name');
//       var newName = name.replace(/([0-9])/, index);
//       $(this).attr('name', newName);
//     });

//     $('.status-map-group').append($clone);
//     $statusMaps = $('.status-maps');
//     connectionsForm.select2Init();
//   });

// });

//# sourceMappingURL=connections.form.js.map
