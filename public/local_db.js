const  indexedDB = window.indexedDB;
const form = document.getElementById('form_value_once_area');
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
        point_main: val1,
        point_base: val2,
      };
      addData_area_t(data_2);
      $('#modal_evaluacion').modal('hide');
    })
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
            alert(0);
          }
        }
    }
    $(document).ready(function(){
      $(".attribute_admin").click(function(){
        //alert($('#area_id_modal_point').val());
        search_by_area_id_totals($('#area_id_modal_point').val());
        search_by_area_id_attrs($('#area_id_modal_point').val());
      });
    });
}