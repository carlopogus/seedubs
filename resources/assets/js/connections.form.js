$(document).ready(function(){



    $('.select-ajax--jira-project').select2({
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

        $(".select-ajax--cw-company").select2({
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
        });

        $(".select-ajax--cw-boards").select2({
          placeholder: 'Select a service board'
        });

        $(".select-ajax--cw-priority").select2({
          placeholder: 'Select a priority'
        });

        $(".select-ajax--cw-agreement").select2({
          placeholder: 'Search for a company, then select an agreement',
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
          // minimumInputLength: 1,
          // minimumResultsForSearch: Infinity,
        });
    });
