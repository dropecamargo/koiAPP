/**
* Class MainSoporteTecnicoView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainSoporteTecnicoView = Backbone.View.extend({

        el: '#soportetecnico-main',
        events: {
            'click .btn-search': 'changeTechnical',
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Reference to fields
            this.spinnerCalendar = this.$('#spinner-calendar');
            this.$calendar = this.$('#calendar');
            
            this.calendar();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initSelect2();
        },

        calendar: function (){
        	this.$calendar.fullCalendar({
        		header: {
				    left: 'prev,next',
				    center: 'title',
				    right: 'month,agendaWeek,agendaDay'
        		},
    			eventClick: function(calEvent, jsEvent, view) {

    				console.log(calEvent, jsEvent, view);
			    }
        	});
        },

        /**
        * Event Change Asesor
        */
        changeTechnical: function (e) {
            e.preventDefault();

	    	var _this = this,
	    		technical = this.$('#search_technical').val(),
	    		tercero = this.$('#search_tercero').val();

			if( typeof(technical) !== 'undefined' && !_.isUndefined(technical) && !_.isNull(technical) && technical != '' || typeof(tercero) !== 'undefined' && !_.isUndefined(tercero) && !_.isNull(tercero) && tercero != '' ){
			    $.ajax({
			        type: 'GET',
			        url: window.Misc.urlFull( Route.route('soportetecnico.index') ),
			        data: { 
			            search_technical: technical,
			            search_tercero: tercero,
			        },
			        beforeSend: function() {
			            window.Misc.setSpinner( _this.spinnerCalendar );
			        }
			    })
			    .done(function(resp) {
			        window.Misc.removeSpinner( _this.spinnerCalendar );

			        if(!_.isUndefined(resp.success)) {
			            // response success or error
			            var text = resp.success ? '' : resp.errors;
			            if( _.isObject( resp.errors ) ) {
			                text = window.Misc.parseErrors(resp.errors);
			            }
			            if( !resp.success ) {
			                alertify.error(text);
			                return;
			            }

			            // Remove event && addEvenet && renderEvent lib -> fullcalendar.io
			        	_this.$calendar.fullCalendar('removeEvents');
			            _this.$calendar.fullCalendar('addEventSource', resp.ordenes);         
			            _this.$calendar.fullCalendar('rerenderEvents');
			        }	
			    })
			    .fail(function(jqXHR, ajaxOptions, thrownError) {
			        window.Misc.removeSpinner( _this.spinnerCalendar );
			        alertify.error(thrownError);
			    });
			}
        },

    });

})(jQuery, this, this.document);
