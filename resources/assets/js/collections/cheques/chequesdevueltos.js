/**
* Class ChDevueltoList of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.ChDevueltoList = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('chequesdevueltos.index') );
        },
        model: app.ChDevueltoModel,

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
                    'chdevuelto_id': model.get('id'),
                    'recibo2_valor': ( _.isUndefined(valor) )  ? model.get('chdevuelto_saldo') : valor,
                    'valor': ( _.isUndefined(valor) )  ? model.get('chdevuelto_saldo') : valor,
                    'recibo2_numero': model.get('chdevuelto_numero'),
                }; 
            }else if(data.call == 'ajustesc'){
                modelo = {
                    'ajustec2_valor': ( _.isUndefined(valor) ) ? model.get('chdevuelto_saldo') : valor,
                    'valor': ( _.isUndefined(valor) ) ? model.get('chdevuelto_saldo') : valor,
                    'ajustec2_documentos_doc': data.ajustec2_documentos_doc,
                    'chdevuelto_id': model.get('id'),
                    'ajustec2_tercero': data.tercero,
                    'ajustec2_naturaleza': (naturaleza == 'D') ? 'D' : 'C',
                };
            }else if( data.call == 'nota' ){
                modelo = {
                    'nota2_valor': ( _.isUndefined(valor) )  ? model.get('chdevuelto_saldo') : valor,
                    'valor': ( _.isUndefined(valor) )  ? model.get('chdevuelto_saldo') : valor,
                    'nota2_conceptonota': data.nota1_conceptonota,
                    'chdevuelto_id': model.get('id'),
                    'nota2_documentos_doc': data.nota2_documentos_doc,
                    'nota2_numero': model.get('chdevuelto_numero'),

                };
            }
            return modelo;
        },
        eliminar: function(id, data){
            // Remove value
            var model = _.find(this.models, function(item) {
                return item.get('id') == id;
            });

            //setter recibo2Model || nota2Model || ajustec2Model
            var modelo = {
                'chdevuelto_id': model.get('id'),
                'deleted': true
            }

            return modelo;
        },
   });
})(this, this.document);