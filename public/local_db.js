const  indexedDB = window.indexedDB;
const form = document.getElementById('form_value_once_area'); 
const delete_form = document.getElementById('delete_area_form');
//const save_print_form = document.getElementById('save_print_serialice');
/*if (save_print_form) {
  console.log('y');
}
else {
  console.log('x');
}*/
if (indexedDB && form) { 
    let db;
    const request = indexedDB.open('Evaluations',1);

    request.onsuccess = () => {
      db = request.result;
      console.log('Open',db);
    }
    request.onupgradeneeded = () => {
      db = request.result;
      console.log('Create',db);
      const objectStore1 = db.createObjectStore('puntajes_atributos',{
        autoIncrement: false 
      });
      const objectStore2 = db.createObjectStore('puntajes_areas',{
        autoIncrement: false 
      });
      const objectStore3 = db.createObjectStore('comentarios',{
        autoIncrement: false 
      }); 
    }    
    request.onerror = (error) => {
      console.log('Error',error);
    }
    const addData = (data) => {
      const transaction = db.transaction(['puntajes_atributos'],'readwrite');
      const objectStore1 = transaction.objectStore('puntajes_atributos');
      let request = objectStore1.get(parseInt(data.id_area));
      request.onerror = function(event) {
        request = objectStore1.add(data, parseInt(data.id_area));
      };
      request.onsuccess = function(event) {
        request = objectStore1.put(data, parseInt(data.id_area));
      }
    }

    const get_total_point = () => {
        const transaction = db.transaction(['puntajes_areas'],'readwrite');
        const objectStore5 = transaction.objectStore('puntajes_areas');
        
        $('.rev_per').each(function(){ 
            let request = objectStore5.get(parseInt($(this).attr('id').slice(7)));
            let val_id_area = $(this).attr('id').slice(7);
            request.onsuccess = function(event) {
              if (request.result) { 
                $("#rev_per"+val_id_area).html(request.result.point_main+'<strong> / </strong>'+request.result.point_base);
              }  
            }
            /*request.onerror = function(event) {
              console.log('xd'); 
            }*/ 
        });
    }

    const addData_area_t = (data) => {
      const transaction = db.transaction(['puntajes_areas'],'readwrite');
      const objectStore2 = transaction.objectStore('puntajes_areas');
      let request = objectStore2.get(parseInt(data.id_area));
      /*request.onerror = function(event) {
        request = objectStore2.add(data, parseInt(data.id_area));
      };*/
      request.onsuccess = function(event) {
        if (request.result) {
          request = objectStore2.put(data, parseInt(data.id_area));
        }
        else {
          request = objectStore2.add(data, parseInt(data.id_area));
        }get_total_point();
      }
    }

    const send_to_api = (id_key) => {
      //report_body http://pms_clean.test/api/ ap_rst_ul
      var api_rest_url = $('#ap_rst_ul').val();
      var myHeader = $('#ap_rst_tn').val();
      fetch(api_rest_url.trim()+"/report_body/"+id_key, {
        method: 'DELETE',
        headers: new Headers({'auth-tkn-pms': myHeader}),
      }) 
      .then((response) => response.json())
      .then((response) => {
          //show_answer_delete(response);
          //$('#modal_delete_areas').modal('hide');
          //$("#allthepage").load(" #allthepage");
          location.reload();
      })
    }

    const DeleteArea = (id,id_key) => {
      
      //console.log(id+'|---|'+valid_deleted);
      send_to_api(id_key);
      const transaction1 = db.transaction(['puntajes_atributos'],'readwrite');
      const objectStore5 = transaction1.objectStore('puntajes_atributos');
      let request1 = objectStore5.delete(parseInt(id));
      request1.onsuccess = function(event) {
        const transaction2 = db.transaction(['puntajes_areas'],'readwrite');
        const objectStore6 = transaction2.objectStore('puntajes_areas');
        let request2 = objectStore6.delete(parseInt(id));
        request2.onsuccess = function(event) {
          console.log('Did it');  
        } 
      }
    }

    form.addEventListener('submit',(e) => {
      e.preventDefault();
      var attrs = []; var count_attrs = 0;
      $(".att_area_val").each(function(){
        attrs[count_attrs] = {
          atributo: $(this).prop('name'),
          point: $(this).val(),
        };
        count_attrs++;
      });
      const data = {
        id_body: e.target.area_body.value,
        id_area: e.target.area_id.value,
        attrs
      };
      //console.log(data);
      addData(data);

      var puntaje = $('#t_hab_label').html();
      puntaje = puntaje.slice(6);
      var valores = [];
      var val1 = 0;
      var val2 = 0;
      valores = puntaje.split("/");
      val1 = parseFloat(valores[0]);
      val2 = parseFloat(valores[1]);
      const data_2 = {
        id_area: e.target.area_id.value,
        id_body: e.target.area_body.value,
        point_main: val1,
        point_base: val2,
      };
      addData_area_t(data_2);
      $('#modal_evaluacion').modal('hide');
    })

    delete_form.addEventListener('submit',(e) => {
      e.preventDefault();  
      DeleteArea($('#dlt_area_ref_id').val(),$('#dlt_area_id').val());
    })

    /*save_print_form.addEventListener('submit',(e) => {
      e.preventDefault();  
      console.log('Stop it');
    })*/

    const search_by_area_id_totals = (id) => {
      const transaction = db.transaction(['puntajes_areas'],'readwrite');
      const objectStore2 = transaction.objectStore('puntajes_areas');
      let request = objectStore2.get(parseInt(id));
      request.onsuccess = function(event) {
        if (request.result) {
          let base_point_base = request.result.point_base;
          let base_point_main = request.result.point_main;
          $('#t_hab_label').html('TOTAL   '+base_point_main+'/'+base_point_base);  
        } 
        else{
          $('#t_hab_label').html('TOTAL 0/0'); 
        }
      }
    }
    const search_by_area_id_attrs = (id) => {
      const transaction = db.transaction(['puntajes_atributos'],'readwrite');
      const objectStore1 = transaction.objectStore('puntajes_atributos');
      let request = objectStore1.get(parseInt(id));
        request.onsuccess = function(event) {
          if (request.result) {
            let atributos = request.result.attrs; 
            for (var i = 0; i < atributos.length; i++) { //alert(atributos[i]['point'])
             $("input[name="+atributos[i]['atributo']+"]").val(atributos[i]['point']);
              let attrs = [];let main_attrs=0; let base_attrs=0;
              attrs = $("[name="+'at_in_label'+atributos[i]['atributo']+"]").html().split("/");
              main_attrs = parseFloat(atributos[i]['point']);
              base_attrs = parseFloat(attrs[1]);
              $("[name="+'at_in_label'+atributos[i]['atributo']+"]").html(main_attrs+'/'+base_attrs);
            }
          } 
          else{
            
          }
        }
    }
    const AddUpdateCommentIn = (data) => {
      const transaction = db.transaction(['comentarios'],'readwrite');
      const objectStore3 = transaction.objectStore('comentarios');
      let request = objectStore3.get('comment_in');
      /*request.onerror = function(event) {
        request = objectStore2.add(data, parseInt(data.id_area));
      };*/
      request.onsuccess = function(event) {
        if (request.result) {
          request = objectStore3.put(data,'comment_in');
        }
        else {
          request = objectStore3.add(data,'comment_in');
        }
      }
    }
    const VerifyUpdateCommentIn = () => {
      const transaction = db.transaction(['comentarios'],'readwrite');
      const objectStore4 = transaction.objectStore('comentarios');
      let request = objectStore4.get('comment_in');
      request.onsuccess = function(event) {
         if (request.result) {  
          $("#comments_in").val(request.result); 
         }
         else{
          $("#comments_in").val('Sin Comentarios');
          AddUpdateCommentIn('Sin Comentarios'); 
         }
      } 
    }

    

    const finish_serialice_header = (id_header,points) => { 
      get_total_point_header(points['points_m'],points['points_b']);
      var points_result = (parseFloat(points['main'])*100)/parseFloat(points['base']); //console.log(points);
      const transaction = db.transaction(['comentarios'],'readwrite');
      const objectStore9 = transaction.objectStore('comentarios');
      var comment_in = objectStore9.get("comment_in");

      comment_in.onsuccess = function(event) { 
        if (comment_in.result !== undefined) { 
         // console.log(comment_in.result); 
          var api_rest_url = $('#ap_rst_ul').val();
          var myHeader = $('#ap_rst_tn').val();
          /*fetch(api_rest_url.trim()+"/report/"+id_header, {
            method: 'PATCH',
            headers: new Headers({'auth-tkn-pms': myHeader}),
            body: 'comentarios_in='+comment_in.result+'&&percent_total='+points_result
          }) 
          .then((response) => response.json())
          .then((response) => {
            location.reload();
          })*/
        }
      }
    }
    const finish_serialice_body = (body) => {
      //console.log(body);     
      //var main_point;var base_point;
      const transaction = db.transaction(['puntajes_areas'],'readwrite');
      const objectStore8 = transaction.objectStore('puntajes_areas');
      var bodies=[];var count_bodies = 0; 
      var points_m=[]; var points_b=[]; var count_points=0;
      

      for (var i = 0; i < body.length; i++) { 
        var request = objectStore8.get(parseInt(body[i])); 
        request.onsuccess = function(event) { 
          if (event.target.result !== undefined) { 
            bodies[count_bodies] =  {
              id: parseFloat(event.target.result.id_body),
              percent_review: parseFloat(event.target.result.point_main),
            };
            points_m[count_bodies] = event.target.result.point_main;
            points_b[count_bodies] = event.target.result.point_base;
            count_bodies++; 
          }
          
        }
      } 
      result = {
        'points_m' : points_m,
        'points_b' : points_b,
      };return result;
    }
    const finish_serialice_subbody = (id_header,ids_body,ids_area) => { 
      //console.log(id_header); console.log(ids_body); console.log(ids_area);
      const transaction = db.transaction(['puntajes_atributos'],'readwrite');
      const objectStore7 = transaction.objectStore('puntajes_atributos');
      var subs_bodies;var count_subs_bodies = 0;
      var subs_bodies = []; var subs_bodies_count=0;
      for (var i = 0; i < ids_body.length; i++) { 
        var request = objectStore7.get(parseInt(ids_body[i])); 
        request.onsuccess = function(event) { 
          if (event.target.result !== undefined) { 
            for (var j = 0; j < event.target.result.attrs.length; j++) {
              subs_bodies[count_subs_bodies] = {
                ref_id_header : parseFloat(id_header),
                ref_id_body : parseFloat(event.target.result.id_body),
                ref_id_attribute_body: parseFloat(event.target.result.attrs[j]['atributo']),
                percent_review : parseFloat(event.target.result.attrs[j]['point']),
                comments : '----',  
              };count_subs_bodies++;
            }
          }
        };
      }
      var body_result = finish_serialice_body(ids_body); 
      for (const item of body_result) {
        console.log(item)
      }
      //finish_serialice_header(id_header,body_result);
      //console.log(subs_bodies);
    }
    const finish_get_data = () => {
      console.log('%cRunning...',
            'background:linear-gradient(45deg,red,blue); color:#FFFFFF; padding: 5px 10px;');
      console.log('\n');  
      $("#print_sendDB").attr("disabled", true);
      $(".attribute_admin").attr("disabled", true);
      $(".delete_area_btn").attr("disabled", true);
      $("#add_area_form").attr("disabled", true);
      $("#add_area_btn").attr("disabled", true); 
      $("#comments_in").attr("disabled", true);
      var points = [];   var ids_body = [];count_ids_body=0;
      var point_m = 0;  var ids_area = [];count_ids_area=0;
      var points_b = 0;//rev_per att_ad
      $('.attribute_admin').each(function(){
        ids_body[count_ids_body] = parseFloat($(this).attr('id').slice(6).trim());
        count_ids_body++;
        ids_area[count_ids_area] = parseFloat($(this).attr('name').trim());
        count_ids_area++;
        /*points = $(this).html().replace(/<[^>]*>?/g, '').split("/");
        point_m = parseFloat(points[0]);
        point_b = parseFloat(points[1]);
        console.log(point_m+'/'+point_b);*/  
      });
      finish_serialice_subbody($('#report_id_value').val(),ids_body,ids_area);
    }  
    $(document).ready(function(){  
      $(".attribute_admin").click(function(){
        //alert($('#area_id_modal_point').val());
        search_by_area_id_totals($('#area_id_modal_point').val());
        search_by_area_id_attrs($('#area_id_modal_point').val());
      });  

      VerifyUpdateCommentIn();
      get_total_point();
      $("#comments_in").on("change", function() {  
        AddUpdateCommentIn($("#comments_in").val());
          /*if((e.keyCode || e.which) == 13) {
            if($(this).hasClass("first")) {
              alert('hola');
            }
          }*/
      });
      $("#comments_in").keyup(function(e) {
          var code = e.keyCode ? e.keyCode : e.which;
          if (code == 13) {
            AddUpdateCommentIn($("#comments_in").val());
          }
      });

      $('#save_print_serialice').submit(function( event ) {
          event.preventDefault(); 
          finish_get_data();
      }); 

    });
    
}