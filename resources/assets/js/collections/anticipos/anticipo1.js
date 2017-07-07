/**
* Class AnticiposList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.AnticiposList = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('anticipos.index') );
        },
        model: app.AnticipoModel,

        /**
        * Constructor Method
        */
        initialize : function(){
            
        },

        agregar: function(id, data, valor, naturaleza){
            var model =  _.find(this.models, function(item){
                return item.get('id') == id;
            });
            // Preparo objeto
            if (data.call == 'recibo') {
                modelo = {
                    'recibo2_conceptosrc': data.recibo2_conceptosrc,
                    'recibo2_naturaleza': (naturaleza == 'D') ? 'D' : 'C',
                    'recibo2_anticipo': model.get('id'),
                    'recibo2_valor': (valor == 0 ) ? model.get('anticipo1_saldo') : valor,
                    'valor': (valor == 0 ) ? model.get('anticipo1_saldo') : valor,
                    'recibo2_numero': model.get('anticipo1_numero'),
                }; 
            }else if(data.call == 'ajustesc'){
                modelo = {
                    'ajustec2_valor': (valor == 0 ) ? model.get('anticipo1_saldo') : valor,
                    'valor': (valor == 0 ) ? model.get('anticipo1_saldo') : valor,
                    'ajustec2_documentos_doc': data.ajustec2_documentos_doc,
                    'ajustec2_anticipo': model.get('id'),
                    'ajustec2_tercero': data.tercero,
                    'ajustec2_naturaleza': (naturaleza == 'D') ? 'D' : 'C',
                };
            }else if( data.call == 'nota' ){
                modelo = {
                    'nota2_valor': (valor == 0 ) ? model.get('anticipo1_saldo') : valor,
                    'valor': (valor == 0 ) ? model.get('anticipo1_saldo') : valor,
                    'nota2_conceptonota': data.nota1_conceptonota,
                    'nota2_anticipo': model.get('id'),
                    'nota2_documentos_doc': data.nota2_documentos_doc,
                    'nota2_numero': model.get('anticipo1_numero'),

                };
            }
            return modelo;
        },
   });
})(this, this.document);