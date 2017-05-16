/**
* Class DetalleFactura3List of Backbone Collection
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.DetalleFactura3List = Backbone.Collection.extend({
        url: function() {
            return window.Misc.urlFull( Route.route('recibos.factura.index') );
        },
        model: app.Factura3Model,

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

            //setter recibo2Model || nota2Model
            if( concepto.call == 'recibo' ){
                var modelo = {
                    'recibo2_conceptosrc': concepto.recibo2_conceptosrc,
                    'recibo2_naturaleza': 'C',
                    'factura1_numero': model.get('factura1_numero'), 
                    'factura3_cuota': model.get('factura3_cuota'),
                    'recibo2_factura1': model.get('factura3_factura1'),
                    'factura3_valor': type == 'input' ? valor : model.get('factura3_saldo'),
                    'call': concepto.call,
                }
            }

            if( concepto.call == 'nota' ){
                var modelo = {
                    'nota2_conceptonota': concepto.nota1_conceptonota,
                    'factura1_numero': model.get('factura1_numero'), 
                    'factura3_cuota': model.get('factura3_cuota'),
                    'nota2_factura1': model.get('factura3_factura1'),
                    'nota2_documentos_doc': model.get('factura1_documentos'),
                    'factura3_valor': type == 'input' ? valor : model.get('factura3_saldo'),
                    'call': concepto.call,
                }   
            }

            return modelo;
        },

        eliminar: function(id, concepto){
            // Remove value
            var model = _.find(this.models, function(item) {
                return item.get('id') == id;
            });

            //setter recibo2Model || nota2Model
            var modelo = {
                'factura1_numero': model.get('factura1_numero'),
                'deleted': true
            }

            return modelo;
        },

        valor: function() {
            return this.reduce(function(sum, model) {
                return sum + parseFloat(model.get('factura3_saldo'))
            }, 0);
        },

        calculate: function(modelos){
            var saldo = _.reduce(modelos, function(sum, model) {
                return sum + parseFloat(model.get('factura3_saldo'))
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
            var porvencer = this.matchPorvencer();
            var mayor360 = this.matchMayor360();
            var menor360 = this.matchMenor360();
            var menor180 = this.matchMenor180();
            var menor90 = this.matchMenor90();
            var menor60 = this.matchMenor60();
            var menor30 = this.matchMenor30();
            var tcount = porvencer.count + menor30.count + menor60.count + menor90.count + menor180.count +menor360.count + mayor360.count;

            return { 'valor': valor, 'porvencer': porvencer, 'mayor360': mayor360, 'menor360': menor360, 'menor180': menor180, 'menor90': menor90, 'menor60': menor60, 'menor30': menor30, 'tcount': tcount}
        },
   });
})(this, this.document);