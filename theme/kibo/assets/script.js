(function ($) {
  'use strict';

  // data background
  $('[data-background]').each(function () {
    $(this).css({
      'background-image': 'url(' + $(this).data('background') + ')'
    });
  });

  // collapse
  $('.collapse').on('shown.bs.collapse', function () {
    $(this).parent().find('.ti-plus').removeClass('ti-plus').addClass('ti-minus');
  }).on('hidden.bs.collapse', function () {
    $(this).parent().find('.ti-minus').removeClass('ti-minus').addClass('ti-plus');
  });

  // match height
  $('.match-height').matchHeight({
    byRow: true,
    property: 'height',
    target: null,
    remove: false
  });


  $("#search").keypress(function(event) {
    if (event.which == 13) {
      san.Recherche();
    }       
  });

  $("#search_").keypress(function(event) {
    if (event.which == 13) {
      kib.Recherche();
    }       
  });
  
  $(document).on( "click",".r_", function() {
    $("#loading").show();
    $.ajax({
      method: "POST",
      url: "result.php",
      async: true,
      cache: false,
      data: { id: $(this).attr("id") }
    }).done(function(res){
      $('.Articlemodal-lg').modal('hide');
      var articles_ = $(".articles_").html();
      $("#loading").hide();
      $('.articles_').hide().html(articles_+res).fadeIn('slow');
      var site_ = $("#site").val();
      $("td."+site_).css({"background-color": "#3598dc", "color": "#FFFFFF"});
    });
    
     return false;
  });

  $(document).on( "click",".rs_", function() {
    $("#loading").show();
    $.ajax({
      method: "POST",
      url: "result_sortie.php",
      async: true,
      cache: false,
      data: { id: $(this).attr("id") }
    }).done(function(res){
      $('.Articlemodal-lg').modal('hide');
      $(".resultat_").html("");
      $("#loading").hide();
      $(".resultat_").html(res);
      $('.detail').modal('show');
    });
    
     return false;
  });

  var site = $("#site").val();
  $("th."+site).css({"background-color": "#f8d13b", "color": "#FFFFFF"});

  $(document).on("click", ".delete", function(){
      $(this).parents("tr").remove();
      return false;
  });

  $(document).on("click", ".supprimer_tout", function(){
      location.reload();
      return false;
  });

  $(document).on("click", ".reactualiser", function(){
    var rowCount = $(".articles_ tr").length;
    if(rowCount > 0){
      $("#loading").show();
      var arr = [];
      $(".articles_ tr").each(function(){
          arr.push($(this).find("td:first").text());
      });
      $.ajax({
          method: "POST",
          url: "result.php",
          async: true,
          cache: false,
          data: { id: arr }
        }).done(function(res){
          $("#loading").hide();
          $(".ligne_").fadeOut("6000", function() {
            $(".ligne_").remove();
            $(".articles_").html(res).fadeIn('slow');
            var sites_ = $("#site").val();
            $("td."+sites_).css({"background-color": "#3598dc", "color": "#FFFFFF"});
          });          
        });
    }
    return false;
  });

  $('table').on('click', '.edit',function () {
    var tr      = $(this).closest("tr");
    var id      = tr.find("td:eq(0)").text();
    var dess    = tr.find("td:eq(1)").text();
    var emp     = tr.find("td:eq(6)").text();
    var lot     = tr.find("td:eq(7)").text();
    var qte     = tr.find("td:eq(9)").text();
    var sp      = emp.split('-');
    var sp_     = qte.split(',');

    $('h5.modal-title').html(id+' - '+dess);
    $('#ref').val(id);
    $('#emp').val(sp[0].trim());
    $('#lot').val(lot);
    $('#qte').val(sp_[0].trim());
    $('.edition').modal('show');

    return false;
  });

  $('.modal').on( "submit",".ajout_ligne", function(e) {
    $("#loading").show();
    $(".info").hide();
    var ref     = $('#ref').val();
    var emp     = $("input[name='emp']:checked").val();
    var qte     = $('#qte_sortie').val();

    if(!ref || !emp || !qte ){
      $("#loading").hide();
      $(".info").show();
    }
    else{
      var donnee = $(this).serializeArray();
      //console.log(donnee);
      $.ajax({
          method: "POST",
          url: "result_sortie.php",
          data: donnee
        }).done(function(res){
          var articles_ = $(".articles_").html();
          $('.articles_').hide().html(articles_+res).fadeIn('slow');
          $('.detail').modal('hide');
          $("#loading").hide();
        });
    }    

    return false;
   });

  $(document).on("click", ".Ajouter_sortie", function(){
    var arr  = [];
    var arr2 = [];

    var rowCount = $(".articles_ tr").length;
    if(rowCount > 0){
      $("#loading").show();
      $(".articles_ tr").each(function(){
        arr.push($(this).find("td:first").text());
        arr2.push($(this).children().eq(2).text() + '-----'+ $(this).children().eq(3).text() + '-----'+ $(this).children().eq(4).children("input").val());
      });

      var result =  arr2.reduce(function(result, field, index) {
                        result[arr[index]] = field;
                        return result;
                  }, {});

      //console.log(result);
      $.ajax({
          method: "POST",
          url: "result_sortie.php",
          async: true,
          cache: false,
          data: { add: result }
      }).done(function(res){
          $("#loading").hide();
          $(".message").html(res);
          $(".message").show();
          $(".articles_").html("");

          /*setTimeout(function () {
            location.reload(true);
          }, 10000);*/
          
      });
    }
    return false;
  });

  $('.modal form').on("click", "#envoi", function(r){
    $("#loading").show();
    var ref     = $('#ref').val();
    var emp     = $('#emp').val();
    var lot     = $('#lot').val();
    const date_ = $('#date_').val();
    var qte     = $('#qte').val();

    if(!$('#ref').val() || !$('#emp').val() ){
      $("#loading").hide();
      return false;
    }

    $.ajax({
          method: "POST",
          url: "result.php",
          async: true,
          cache: false,
          data: {ref: ref, emp: emp, lot: lot, date_: date_, qte: qte}
        }).done(function(res){
          $(".r").html(res);
          alert(res);
          var rowCount = $(".articles_ tr").length;
          if(rowCount > 0){
            var arr = [];
            $(".articles_ tr").each(function(){
                arr.push($(this).find("td:first").text());
            });
            $.ajax({
                method: "POST",
                url: "result.php",
                async: true,
                cache: false,
                data: { id: arr }
              }).done(function(res){
                $("#loading").hide();
                $(".ligne_").fadeOut("6000", function() {
                  $(".ligne_").remove();
                  $(".articles_").html(res).fadeIn('slow');
                  var sites_ = $("#site").val();
                  $("td."+sites_).css({"background-color": "#3598dc", "color": "#FFFFFF"});
                });          
              });
          }
        $('.edition').modal('hide');
        $("#loading").hide();
    });
    return false;
  });


  $(document).on("click", ".Ajouter", function(e){
    var date_ = new Date().toJSON().slice(0,10).split('-').reverse().join('-');

    $('h5.modal-title').html("Ajout nouveau inventaire");
    $('#ref').prop( "disabled", false );
    $('#qte').val("0");
    $('#date_').val(date_);
    $('.edition').modal('show');
    $( "#date_" ).datepicker({
        dateFormat: 'dd-mm-yy',
    });
    return false;
  });

  $('.dateRange').datepicker({
    inputs: $('.dateRangeInput'),
    language: 'fr'
  });

  $('.dateRangeTrigger').click(function() {
    $(this).closest('.input-group').find('.dateRangeInput').datepicker('show');
  });

  $(document).on("click", "#print_", function(e){
    var d = $('#startDate').val().split("/").reverse().join("-");
    var f = $('#endDate').val().split("/").reverse().join("-");
    window.open("impression.php?d="+d+"&f="+f,"_blank");
    return false;
  });

  var san = {}; 
  san.Recherche=function() { 
    $('#search').each(function() {
      if ($(this).val() != "") {
        if ($.fn.DataTable.isDataTable("#datatable_")) {
          $('#datatable_').DataTable().clear().destroy();
        }
        $("#loading").show();

        var rowCount = $(".articles_ tr").length;
        
        $.ajax({
          method: "POST",
          url: "result.php",
          data: { recherche: $(this).val() }
        }).done(function(res){
          $("#search").val("");
          $("#loading").hide();
          if ( res.indexOf('ligne_') > -1 ) {
            var articles_ = $(".articles_").html();
            $('.articles_').hide().html(articles_+res).fadeIn('slow');
            var site_ = $("#site").val();
            $("td."+site_).css({"background-color": "#3598dc", "color": "#FFFFFF"});
          }
          else{
            $(".resultat").html(res);          
            $('#datatable_').DataTable({
                "order": [ 1, "asc" ],
                "pageLength": 10,
                "language": {
                    "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                    "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                    "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                    "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                    "sInfoPostFix":    "",
                    "sInfoThousands":  ",",
                    "sLengthMenu":     "Afficher _MENU_ éléments",
                    "sLoadingRecords": "Chargement...",
                    "sProcessing":     "Traitement...",
                    "sSearch":         "Rechercher :",
                    "sZeroRecords":    "Aucun élément correspondant trouvé",
                    "oPaginate": {
                        "sFirst":    "Premier",
                        "sLast":     "Dernier",
                        "sNext":     "Suiv",
                        "sPrevious": "Préc"
                    },
                    "oAria": {
                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                    },
                    "select": {
                            "rows": {
                                "_": "%d lignes sélectionnées",
                                "0": "Aucune ligne sélectionnée",
                                "1": "1 ligne sélectionnée"
                            } 
                    }
                }
            });
            $('.Articlemodal-lg').modal('show');
          }
        });
      }
      else return false;
    });
  };

  var kib = {}; 
  kib.Recherche=function() { 
    $('#search_').each(function() {
      if ($(this).val() != "") {
        if ($.fn.DataTable.isDataTable("#datatable_")) {
          $('#datatable_').DataTable().clear().destroy();
        }
        $("#loading").show();
        $("#qte_sortie").val("");
        $(".message").html("");
        $(".info").hide();
        $(".message").hide();
        var rowCount = $(".articles_ tr").length;
        
        $.ajax({
          method: "POST",
          url: "result_sortie.php",
          data: { recherche: $(this).val() }
        }).done(function(res){
          $("#search_").val("");
          $("#loading").hide();
          if (res.includes("h5_")) {
            $('.Articlemodal-lg').modal('hide');
            $(".resultat_").html("");
            $("#loading").hide();
            $(".resultat_").html(res);
            $('.detail').modal('show');
          }
          else{
            $(".resultat").html(res);          
            $('#datatable_').DataTable({
                "order": [ 1, "asc" ],
                "pageLength": 10,
                "language": {
                    "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                    "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                    "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                    "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                    "sInfoPostFix":    "",
                    "sInfoThousands":  ",",
                    "sLengthMenu":     "Afficher _MENU_ éléments",
                    "sLoadingRecords": "Chargement...",
                    "sProcessing":     "Traitement...",
                    "sSearch":         "Rechercher :",
                    "sZeroRecords":    "Aucun élément correspondant trouvé",
                    "oPaginate": {
                        "sFirst":    "Premier",
                        "sLast":     "Dernier",
                        "sNext":     "Suiv",
                        "sPrevious": "Préc"
                    },
                    "oAria": {
                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                    },
                    "select": {
                            "rows": {
                                "_": "%d lignes sélectionnées",
                                "0": "Aucune ligne sélectionnée",
                                "1": "1 ligne sélectionnée"
                            } 
                    }
                }
            });
            $('.Articlemodal-lg').modal('show');
          }
        });
      }
      else return false;
    });
  };

})(jQuery);