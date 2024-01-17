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


  $(document).on("keypress","#search_", function(event) {
    if (event.which == 13) {
      $("#result").html("");
      var num = $( this ).val();
      $.ajax({
        method: "POST",
        url: "result.php",
        async: true,
        cache: false,
        data: {InvNum: num}
      }).done(function(res){
        $(".s_").html(res);
      });
      return false;
    }
  });

  $(document).on("click",".ajouter", function (event) {
    kib.Recherche();
  });
  $(document).on("dblclick",".ajouter", function (event) {
    console.log("Double-clic non autoriser !!!!");
    return false;
  });

  $(document).on("click",".valider", function (event) {
    var arr    = [];
    var arr2   = [];
    var nLigne = $(".nLigne").text();
    $("#loading").show();
    $("table.detail tr#session").each(function(){
      arr.push($(this).find("td:first").text() + '&&&&&&' + $(this).children().eq(3).text());
      arr2.push($(this).children().eq(1).children("input").val());
    });

    var result =  arr2.reduce(function(result, field, index) {
      result[arr[index]] = field;
      return result;
    }, {});

    $.ajax({
      method: "POST",
      url: "result.php",
      async: true,
      cache: false,
      data: {VnLigne: nLigne, result: result}
    }).done(function(res){
      $("#loading").hide();
      console.log(res);
      var origin = window.location.origin;
      var url    = origin + '/invKIBO/csv.php';
      window.location.href = `${url}?nLigne=${nLigne}`;

      setTimeout(function () {
              location.reload(true);
            }, 5000);
      return false;
    });

    

  });
  $(document).on("dblclick",".valider", function (event) {
    console.log("Double-clic non autoriser !!!!");
    return false;
  });
  

  $( "#frm" ).on( "submit", function( e ) {
      var frm=new FormData(this);
      $.ajax({
        xhr:function(){ 
          var httpReq=new XMLHttpRequest();
          httpReq.upload.addEventListener("progress",function(ele){
             if (ele.lengthComputable) {
              var percentage=((ele.loaded / ele.total) * 100); 
              $("#progress-bar").css("width",percentage+"%");
              $("#progress-bar").html(Math.round(percentage)+"%");
             }
          });
          return httpReq;
        },
        url:"result.php",
        type:"POST",
        contentType: false,
        processData: false,
        data:frm,
        beforeSend:function(){
          $("#progress-bar").css("width","0%");
          $("#progress-bar").html("0%");
        },
        success:function(res){
          $("#result").html(res);
        },
        error:function(xhr){
          $("#result").html("Échec du téléchargement : "+xhr.statusText);
        }
      });
      $(".progress").delay(5000).fadeOut('slow');
      $(".s_").html('');
      return false;
  });

  $(document).on("click", ".delete", function(){
    $(this).parents("tr").remove();
    return false;
  });

  function isExistCB(cb){
    return Array.from($('tr[id*=session]'))
              .some(element => ($('td:nth(2)',$(element)).html()===cb));
  }
  function isExistREF(ref){
    return Array.from($('tr[id*=session]'))
              .some(element => ($('td:nth(3)',$(element)).html()===ref));
  }

  function notIncludes(array, value) {
    return !array.includes(value);
  }

  var kib = {}; 
  kib.Recherche=function() { 
    $('#recherche_').each(function() {
      if ( $( this ).val() != "" && $("#qte_").val() != "") {
        var recherche_ = $( this ).val();
        var nLigne     = $(".nLigne").text();
        let qty        = $("#qte_").val();
        if(isExistCB(recherche_) || isExistREF(recherche_)){
            var array   = [];
            $( "table.detail tr#session").each( function(e) {
              let cb      = $( this ).children().eq(2).text();
              let ref     = $( this ).children().eq(3).text();
              if (array.indexOf(ref) === -1) {
                if(cb == recherche_ || ref == recherche_){                
                  let qte     = $( this ).children().eq(1).children("input").val();
                  let somme   = parseInt(qte) + parseInt(qty);
                  $( this ).children().eq(1).children("input").css("border","2px solid red");
                  $( this ).children().eq(1).children("input").val(somme);
                  $( this ).addClass("table-success bold");
                  array.push(ref);
                }   
              }              
            });
        }
        else {
          $.ajax({
            method: "POST",
            url: "result.php",
            async: true,
            cache: false,
            data: {nLigne: nLigne, ref: recherche_, qte: qty}
          }).done(function(res){
            $(".detail").append(res);
            alert("Ligne ajoutée dans le tableau !!!");
          });
        }
      }
      else{
        alert("Veuillez renseigner tous les champs svp !!!")
      }
      $("#qte_").val("");
      $("#recherche_").val("");
      return false;
    });
  };


})(jQuery);