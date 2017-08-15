/**
* Class DetalleFacturap3List of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleFacturap3List = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('facturasp.cuotas.index') );
        },
        model: app.Facturap3Model,

        /**
        * Constructor Method
        */
        initialize : function(){
        },
        agregar: function(id, concepto, type, valor){
            // Setter value
            var model = _.find(this.models, function(item) {
                return item.get('id') == id;
            });
            var object = {
                'facturap1_numero': model.get('facturap1_numero'), 
                'facturap3_id': model.get('id'),
                'facturap3_valor': !_.isUndefined(valor) ? valor : model.get('facturap3_saldo'),
                'facturap3_cuota': model.get('facturap3_cuota')
            }
            // Setter attributes to model
            if ( concepto.call == 'ajustep'){
                modelo = $.extend(object, {
                    'ajustep2_valor': !_.isUndefined(valor) ? valor : model.get('facturap3_saldo'),
                    'ajustep2_documentos_doc': concepto.ajustep2_documentos_doc,
                    'ajustep2_facturap1': model.get('facturap3_facturap1'),
                    'ajustep2_tercero': concepto.tercero,
                    'ajustep2_naturaleza': type == 'D' ? 'D' : 'C',
                    'call': concepto.call,
                }); 
            }
            return modelo;
        },

        eliminar: function(id, concepto){
            // Remove value
            var model = _.find(this.models, function(item) {
                return item.get('id') == id;
            });

            //setter ajustep2Model
            var modelo = {
                'facturap3_id': model.get('id'),
                'deleted': true
            }

            return modelo;
        },

        valor: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('facturap3_saldo'))
            }, 0);
        },

        calculate: function(modelos){
            var saldo = _.reduce(modelos, function(sum, model) {
                return sum + parseFloat(model.get('facturap3_saldo'))
            }, 0);

            var count = modelos.length;

            return { 'saldo': saldo, 'count': count}
        },

        matchPorvencer: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') > 0;
            });

            return this.calculate(match);
        },

        matchMayor360: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') < -360;
            });

            return this.calculate(match);
        },

        matchMenor360: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= -181 && item.get('days') >= -360;
            });

            return this.calculate(match);
        },

        matchMenor180: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= -91 && item.get('days') >= -180;
            });

            return this.calculate(match);
        },

        matchMenor90: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= -61 && item.get('days') >= -90;
            });

            return this.calculate(match);
        },

        matchMenor60: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= -31 && item.get('days') >= -60;
            });

            return this.calculate(match);
        },

        matchMenor30: function(){
            var match = _.filter(this.models, function(item){
                return item.get('days') <= 0 && item.get('days') >= -30;
            });

            return this.calculate(match);
        },

        totalize: function() {
            var valor = this.valor();

            return { 'valor': valor }
        },
   });
})(this, this.document);